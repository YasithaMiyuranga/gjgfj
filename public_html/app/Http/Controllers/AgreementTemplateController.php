<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Term;
use App\Models\SubTerm;
use App\Models\AgreementCategory;
use App\Models\AgreementTemplate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class AgreementTemplateController extends Controller
{
    /**
     * Display all agreement templates
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Agreement.templates.index', [
            'agreementTemplates' => AgreementTemplate::all()
        ]);
    }

    /**
     * Show the form for creating a new template
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Get all the agreement categories
        $agreementCategories = AgreementCategory::all();
        return view('Agreement.templates.create', compact('agreementCategories'));
    }

    /**
     * Store a newly created agreement template to the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $validatedData = Validator::make($request->all(), [
           'agreement_category_id' => 'required|exists:agreement_categories,id',
           'agreement_name' => 'required|string|max:255',
           'agreement_description' => 'required|string|max:255',
           'topics' => 'required|array',
           'topics.*.title' => 'required|string|max:255',
           'topics.*.subtopics' => 'required|array',
           'topics.*.subtopics.*.title' => 'required|string|max:255',
           'topics.*.subtopics.*.description' => 'required|string|max:255',
       ],
       [
          'topics.*.title' => [
              'required' => 'The term title is required.',
              'max' => 'The term title must be no more than 255 characters.',
          ],
          'topics.*.subtopics.*.title' => [
              'required' => 'The subTerm title is required.',
              'max' => 'The subTerm title must be no more than 255 characters.',
          ],
          'topics.*.subtopics.*.description' => [
              'required' => 'The subTerm description is required.',
              'max' => 'The subTerm description must be no more than 255 characters.',
          ],
       ]);

        if($validatedData->fails()){
            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        $isDefault = $request->has('is_default');

        if ($isDefault) {
            AgreementTemplate::query()->update(['is_default' => false]);
        }

        DB::beginTransaction();
        try {
            // Create the agreement template
            $agreementTemplate = AgreementTemplate::create([
                'agreement_category_id' => $request->agreement_category_id,
                'name' => $request->agreement_name,
                'content' => $request->agreement_description,
                'is_default' => $isDefault
            ]);

            // Create the topics and subtopics
            foreach ($request->topics as $topic) {
                $term = $agreementTemplate->terms()->create([
                    'title' => $topic['title'],
                    'description' => $topic['description'] ?? null,
                ]);

                foreach ($topic['subtopics'] as $subtopic) {
                    $term->subterms()->create([
                        'title' => $subtopic['title'],
                        'description' => $subtopic['description'] ?? null,
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('useradmin.agreement_templates.index')->with('success', 'Agreement template created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error creating agreement template: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified template.
     *
     * @param  \App\Models\AgreementTemplate  $agreementTemplate
     * @return \Illuminate\Http\Response
     */
    public function edit(AgreementTemplate $agreementTemplate)
    {
        $agreementTemplate->load('terms', 'terms.subterms');
        // Get all the agreement categories
        $agreementCategories = AgreementCategory::all();
        return view('Agreement.templates.edit', compact('agreementTemplate', 'agreementCategories'));
    }

    /**
     * Update the specified template in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AgreementTemplate  $agreementTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AgreementTemplate $agreementTemplate)
    {
        // dd($request->all());
        $validatedData = Validator::make($request->all(), [
            'agreement_category_id' => 'required|exists:agreement_categories,id',
            'agreement_name' => 'required|string|max:255|unique:agreement_templates,name,' . $agreementTemplate->id,
            'agreement_description' => 'required|string|max:255',
            'topics' => 'required|array',
            'topics.*.title' => 'required|string|max:255',
            'topics.*.subtopics' => 'required|array',
            'topics.*.subtopics.*.title' => 'required|string|max:255',
            'topics.*.subtopics.*.description' => 'required|string|max:255',
        ], [
            'topics.*.title' => [
              'required' => 'The term title is required.',
              'max' => 'The term title must be no more than 255 characters.',
            ],
            'topics.*.subtopics.*.title' => [
                'required' => 'The subTerm title is required.',
                'max' => 'The subTerm title must be no more than 255 characters.',
            ],
            'topics.*.subtopics.*.description' => [
                'required' => 'The subTerm description is required.',
                'max' => 'The subTerm description must be no more than 255 characters.',
            ],
        ]);

        if($validatedData->fails()){
            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        if ($request->has('is_default') == true) {
            AgreementTemplate::query()->update(['is_default' => false]);
        }

        DB::beginTransaction();
        try {
            // Update the agreement template
            $agreementTemplate->update([
                'agreement_category_id' => $request->agreement_category_id,
                'name' => $request->agreement_name,
                'content' => $request->agreement_description,
                'is_default' => $request->has('is_default') ? true : false
            ]);

            // Get existing terms' IDs
            $existingTermIds = $agreementTemplate->terms()->pluck('id')->toArray();

            // Delete all subterms for existing terms
            Term::whereIn('id', $existingTermIds)->each(function ($term) {
                $term->subterms()->delete();
            });

            // Update  or create terms and subterms
            $updatedTermIds = [];
            foreach ($request->topics as $topic) {
                $term = Term::updateOrCreate(
                    [
                        'agreement_template_id' => $agreementTemplate->id,
                        'title' => $topic['title'],
                    ],
                    [
                        'description' => $topic['description'] ?? null,
                    ]
                );

                $updatedTermIds[] = $term->id;

                // Update subTerms
                foreach ($topic['subtopics'] as $subtopic) {
                    $term->subterms()->updateOrCreate(
                        [
                            'title' => $subtopic['title'],
                        ],
                        [
                            'description' => $subtopic['description'] ?? null,
                        ]
                    );
                }
            }
            // Delete terms that are no longer in the updated list
            Term::where('agreement_template_id', $agreementTemplate->id)
                ->whereNotIn('id', $updatedTermIds)
                ->delete();

            DB::commit();
            return redirect()->route('useradmin.agreement_templates.index')->with('success', 'Agreement template updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error updating agreement template. Please try again.');
        }
    }

    /**
     * Remove the specified agreement template and its terms and subterms from the database.
     *
     * @param  \App\Models\AgreementTemplate  $agreementTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(AgreementTemplate $agreementTemplate)
    {
        try{
            $terms = $agreementTemplate->terms;
            if( $terms){
                foreach ($terms as $term) {
                    $subterms = $term->subterms;
                    foreach ($subterms as $subterm) {
                        $subterm->delete();
                    }
                    $term->delete();
                }
            }
            $agreementTemplate->delete();
            return redirect()->route('useradmin.agreement_templates.index')->with('success', 'Agreement template deleted successfully.');
        }catch(\Exception $e){
         return redirect()->route('useradmin.agreement_templates.index')->with('error', 'Agreement template assigned to an agreement cannot be deleted.');
        }
    }
}
