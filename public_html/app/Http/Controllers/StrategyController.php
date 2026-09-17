<?php

namespace App\Http\Controllers;

use App\Models\AdminEvent;
use App\Models\Option;
use App\Models\Category;
use App\Models\Strategy;
use App\Models\SubOption;
use App\Models\TaskTemplate;
use App\Models\TeamCategory;
use Illuminate\Http\Request;
use App\Models\StrategyOption;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StrategyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Admin_events.strategy.index', [
            'strategies' => Strategy::all()
        ]);
    }


    public function loadSubOption(Request $request)
    {
        // pass data if needed
        $data = ['eventCategories' => Category::all()];

        $html = view('subStrategies.taskmanagement', $data)->render();

        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }

    public function loadSubOptionEdit(Request $request)
    {
        // pass data if needed
        $data = [
            'taskTemplate' => TaskTemplate::where('id', $request->id)->with('tasks')->first(),
            'eventCategories' => Category::all(),
            'taskTemplateStatus' => DB::select('SELECT statuses.* FROM task_template_status INNER JOIN statuses ON task_template_status.status_id = statuses.id WHERE task_template_status.task_template_id = ?', [$request->id]),
        ];

        $html = view('subStrategies.taskmanagementedit', $data)->render();

        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }


    public function loadSubOptionMainTasks(Request $request)
    {
        // pass data if needed
        $data_task = [
            'taskTemplates' => TaskTemplate::with('tasks')->get(),
        ];

        $data_team=[
            'events' => AdminEvent::all(),
            'team_categories' => TeamCategory::all(),
        ];

        if ($request->sub_option_name) {
            switch ($request->sub_option_name) {
                case 'Task Management':
                    $html = view('subStrategies.mainTask', $data_task)->render();
                    break;
                case 'Team Assignment':
                    $html = view('subStrategies.teammanagement', $data_team)->render();
                    break;
                default:
                    $html = null;
                    break;
            }


        }


        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $subOptions = SubOption::all();
        return view('Admin_events.strategy.create', compact('categories', 'subOptions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'is_default' => 'boolean',
            'category_id' => 'required|integer|exists:category,id',
            'options' => 'required|array|min:1',
            'options.*.name' => 'required|string|max:255',
            'options.*.sub_options' => 'required|array|min:1',
            'options.*.sub_options.*' => 'required|integer|exists:sub_options,id',
        ]);

        if ($validated->fails()) {
            return redirect()->back()
                ->withErrors($validated)
                ->withInput();
        }

        // Start DB transaction
        DB::beginTransaction();

        try {
            // Create Strategy
            $strategy = Strategy::create([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'is_default' => $request->is_default ?? false,
            ]);

            // Add each option
            foreach ($request->options as $optionData) {
                // Create or reuse the option
                $option = Option::firstOrCreate(['name' => $optionData['name']]);

                // 3. Create the strategy_option pivot row
                $strategyOption = StrategyOption::create([
                    'strategy_id' => $strategy->id,
                    'option_id' => $option->id,
                ]);

                // 4. Attach every chosen sub-option
                $strategyOption->subOptions()->attach(
                    $optionData['sub_options'],  // array of IDs
                    ['previous' => null, 'next' => null]
                );
            }

            DB::commit();

            return redirect()->route('useradmin.strategies.index')
                ->with('success', 'Strategy updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again.')
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Strategy $strategy)
    {
        //
    }

    /**
     * Shows the edit form for a strategy, pre-filled with the existing data.
     *
     * @param  \App\Models\Strategy  $strategy
     * @return \Illuminate\Http\Response
     */
    public function edit(Strategy $strategy)
    {
        return view('Admin_events.strategy.edit', [
            'strategy' => $strategy,
            'categories' => Category::all(),
            'subOptions' => SubOption::all(),
            'strategyOptions' => $strategy->strategyOptions()
                ->with(['option', 'subOptions']) // ← eager-load option
                ->get(),
        ]);
    }
    /**
     * Update the specified strategy in the database.
     *
     * Validates the incoming request data and updates the existing strategy record,
     * including its related options. If the update is successful, returns a success
     * message; otherwise, returns an error message.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Strategy  $strategy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Strategy $strategy)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:category,id',
            'is_default' => 'nullable|boolean',
            'options' => 'required|array|min:1',
            'options.*.name' => 'required|string|max:255',
            'options.*.sub_options' => 'required|array|min:1',
            'options.*.sub_options.*' => 'required|integer|exists:sub_options,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        try {
            // 1. Update basic strategy data
            $strategy->update([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'is_default' => $request->is_default ?? false,
            ]);

            // 2. Wipe existing strategy_option rows (and their sub-options)
            foreach ($strategy->strategyOptions as $strategyOption) {
                $strategyOption->subOptions()->detach(); // pivot
                $strategyOption->delete();               // strategy_option row
            }

            // 3. Re-create everything from the form
            foreach ($request->options as $optionData) {
                $option = Option::firstOrCreate(['name' => $optionData['name']]);

                $strategyOption = StrategyOption::create([
                    'strategy_id' => $strategy->id,
                    'option_id' => $option->id,
                ]);

                // Attach sub-options
                $strategyOption->subOptions()->attach(
                    $optionData['sub_options'],
                    ['previous' => null, 'next' => null]
                );
            }

            DB::commit();

            return redirect()->route('useradmin.strategies.index')
                ->with('success', 'Strategy updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Failed to update strategy. Please try again.')
                ->withInput();
        }
    }

    /**
     * Remove the specified strategy from storage.
     *
     * Deletes the related options before deleting the strategy itself.
     * If the deletion is successful, returns a success message; otherwise,
     * returns an error message.
     *
     * @param  \App\Models\Strategy  $strategy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Strategy $strategy)
    {
        DB::beginTransaction();

        try {
            // 1. Detach / delete pivot rows in strategy_option_sub_option
            foreach ($strategy->strategyOptions as $strategyOption) {
                $strategyOption->subOptions()->detach();
                $strategyOption->delete();
            }

            // 2. Delete the strategy itself
            $strategy->delete();

            DB::commit();

            return redirect()->route('useradmin.strategies.index')
                ->with('success', 'Strategy deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Failed to delete strategy. Please try again.');
        }
    }

    /**
     * Show the default strategy view.
     *
     * Takes a page number as a query string parameter and shows the corresponding
     * strategy option and its sub-options.
     *
     * If the page number is out of range, returns a 404 error.
     *
     * @return \Illuminate\Http\Response
     */
    public function strategiesView()
    {
        $strategy = Strategy::where('is_default', 1)->firstOrFail();
        $page = (int) request('page', 0);
        $subPage = (int) request('sub_page', 0);

        $strategyOptions = $strategy->strategyOptions()->with('option', 'subOptions')->get();
        $currentPivot = $strategyOptions->get($page);
        abort_if(is_null($currentPivot), 404);

        $subOptions = $currentPivot->subOptions;
        abort_if(!isset($subOptions[$subPage]), 404);

        return view('Admin_events.strategy.view', [
            'strategy' => $strategy,
            'strategyOptions' => $strategyOptions,
            'currentOption' => $currentPivot->option,
            'subOption' => $subOptions[$subPage],
            'page' => $page,
            'subPage' => $subPage,
            'lastPage' => $strategyOptions->count() - 1,
            'lastSubPage' => count($subOptions) - 1,
        ]);
    }

    /**
     * Redirects to the next page or sub-page, depending on the user's progress.
     *
     * If the user has completed all the sub-options for the current page, redirects
     * to the next page. If the user has completed all the pages, redirects to the
     * index page with a success message.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $strategyId
     * @param  int  $page
     * @param  int  $subPage
     * @return \Illuminate\Http\Response
     */
    public function saveSubOption(Request $request, $strategyId, $page, $subPage)
    {

        $strategy = Strategy::findOrFail($strategyId);
        $subOptionsCount = $strategy->strategyOptions[$page]->subOptions->count();

        if ($subPage + 1 < $subOptionsCount) {
            return redirect()->route('useradmin.strategies.view', [
                'page' => $page,
                'sub_page' => $subPage + 1
            ]);
        } elseif ($page + 1 < $strategy->strategyOptions->count()) {
            return redirect()->route('useradmin.strategies.view', [
                'page' => $page + 1,
                'sub_page' => 0
            ]);
        } else {
            return redirect()->route('useradmin.strategies.index')->with('success', 'All completed!');
        }
    }

}
