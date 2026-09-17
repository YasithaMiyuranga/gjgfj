<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Helper\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Package;
use App\Models\PackageItem;
use Illuminate\Support\Facades\Validator;

class PackageController extends Controller
{
    function newpackage()
    {
        $items = DB::table('item')->where('visible_to_customer', 'Yes')->get();
        return view('package.createpackage', ['items' => $items]);
    }

    //*** FUNCTION TO SAVE PACKAGE TO THE DATABASE ***//
    function savepackage(Request $request)
    {
        $data = Validator::make($request->all(), [
            'package_name' => 'string|required|max:255|unique:package,package_name',
            'category' => 'string|required',
            'price' => 'string|required',
            'description' => 'string|nullable',
            'status' => 'string|required',
            'type' => 'string|required',
            'image' => 'required|image|mimes:jpeg,png,webp,jpg,gif,svg,jfif|max:5120',
            'price_visible' => 'required|boolean|in:0,1',
        ]);

        if( $data->fails())
        {
            return redirect()->back()->withErrors($data)->withInput();
        }
        $data = $data->validated();


        DB::beginTransaction();
        try {
            $imageName = null;

            $package = new Package();
            $package->package_name = $data['package_name'];
            $package->category = $data['category'];
            $package->price = $data['price'];
            $package->price_visible = $data['price_visible'];
            $package->description = $data['description'];
            $package->status = $data['status'];
            $package->type = $data['type'];
            $package->image = Helper::getFileUrl($request->image, 'uploads/packages/');;
            $package->save();

            $package_id = $package->package_id;

            $packageItems = json_decode($request->selected_items);

            foreach ($packageItems as $packageItem) {
                $packageitem = new PackageItem();
                $packageitem->package_id = $package_id;
                $packageitem->item_id = $packageItem->itemId;
                $packageitem->item_name = $packageItem->itemName;
                $packageitem->quantity = $packageItem->quantity;

                $packageitem->save();
            }

            DB::commit();
            return redirect()->route('useradmin.package.all')->with('success', 'Package created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while creating the package: ' . $e->getMessage());
        }
    }
    //** Function to check package name */
    public function checkPackageName(Request $request)
    {
        $validatedData = $request->validate([
            'packageName' => 'required|string|max:255',
        ]);

        $packageName = $validatedData['packageName'];
        $packageExists = Package::where('package_name', $packageName)->exists();

        return response()->json(['exists' => $packageExists]);
    }
    //** Function to check package name in edit */
    public function checkPackageNameEdit(Request $request)
    {
        $validatedData = $request->validate([
            'packageName' => 'required|string|max:255',
        ]);

        $packageName = $validatedData['packageName'];
        $packageExists = Package::where('package_name', $packageName)->where('package_id', '!=', $request->packageId)->exists();

        return response()->json(['exists' => $packageExists]);

    }

    //*** FUNCTION TO VIEW ALL PACKAGES ***//
    function allpackages()
    {
        $packagedata = DB::table('package')->get();
        return view('package.allpackages', ['packagedata' => $packagedata]);
    }

    //*** FUNCTION TO EDIT PACKAGES ***//
    function editpackage($id)
    {
        $packagedata = DB::table('package')->where('package_id', $id)->first();
        $addedItems = DB::table('package_item')->where('package_id', $id)->get();
        $items = DB::table('item')->where('visible_to_customer', 'Yes')->get();
        return view('package.editpackage', ['packagedata' => $packagedata, 'addedItems' => $addedItems, 'items' => $items]);
    }

    //*** FUNCTION TO UPDATE PACKAGES DATA IN DB ***//
    function updatepackage(Request $request, $id)
    {

        $data = Validator::make($request->all(), [
            'package_name' => 'string|required|max:255|unique:package,package_name,' . $id.',package_id',
            'category' => 'string|required',
            'price' => 'string|required',
            'description' => 'string|nullable',
            'status' => 'string|required',
            'type' => 'string|required',
            'image' => 'nullable|image|mimes:jpeg,png,webp,jpg,gif,svg,jfif|max:5120',
            'price_visible' => 'required|boolean|in:0,1',
        ]);

        if( $data->fails())
        {
            return redirect()->back()->withErrors($data)->withInput();
        }

        $package = Package::find($id);
        if ($request->hasFile('image')) {
            $oldimageName = DB::table('package')->where('package_id', $id)->pluck('image')->first();
            $image_path = $oldimageName;

            if ($oldimageName !== null && $oldimageName !== '' && file_exists($image_path)) {
                unlink($image_path);
            }
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $path = Helper::getFileUrl($request->image, 'uploads/packages/');
            $package->image =$path;
        } else {
            $imageName = DB::table('package')->where('package_id', $id)->pluck('image')->first();;
        }

        // Update Package Details
        $package->package_name = $request->package_name;
        $package->category = $request->category;
        $package->price = $request->price;
        $package->price_visible = $request->price_visible;
        $package->description = $request->description;
        $package->status = $request->status;
        $package->type = $request->type;
        $package->save();

        $packageItems = json_decode($request->selected_items);
        $deletepacakgeItems = json_decode($request->old_package_items);
        $addedpackageItems = $request->package_item_id;
        $quantity = $request->package_quantity;


        if ($deletepacakgeItems != null) {
            foreach ($deletepacakgeItems as $deleteItem) {
                $packageItem = PackageItem::find($deleteItem);
                $packageItem->delete();
            }
        }

        $i = 0;
        if ($addedpackageItems != null) {
            foreach ($addedpackageItems as $addedItem) {
                $packageItem = PackageItem::find($addedItem);
                $packageItem->quantity = $quantity[$i];
                $i++;
                $packageItem->save();
            }
        }

        if ($packageItems != null) {
            foreach ($packageItems as $packageItem) {
                $packageitem = new PackageItem();
                $packageitem->package_id = $id;
                $packageitem->item_id = $packageItem->itemId;
                $packageitem->item_name = $packageItem->itemName;
                $packageitem->quantity = $packageItem->quantity;

                $packageitem->save();
            }
        }
        return redirect()->route('useradmin.package.all')->with('success', 'Package updated successfully');
    }

    //*** FUNCTION TO DELETE PACKAGES ***//
    function deletepackage($id)
    {
        $package = Package::find($id);
        $package->delete();
        return redirect()->route('useradmin.package.all')->with('success', 'Package deleted successfully');
    }

    //*** FUNCTION TO REMOVE ITEMS FROM PACKAGES ***//
    function deletepackageitem(Request $request)
    {
        $id = $request->itemId;
        $oldimageName = DB::table('package')->where('package_id', $id)->pluck('image')->first();
        $image_path = $oldimageName;

        if ($oldimageName !== null && $oldimageName !== '' && file_exists($image_path)) {
            unlink($image_path);
        }


        $packageitem = PackageItem::find($id);
        $packageitem->delete();
        return response()->json(['success' => 'Item removed successfully.']);
    }

    //*** FUNCTION TO GET ALL PREDEFINED PACKAGE ITEMS THROUGH AJAX REQUEST ***//
    function packageitems(Request $request)
    {
        $id = $request->predefined_package_id;
        $predefinedItems = DB::table('package_item')->where('package_id', $id)->get();
        return response()->json(['predefinedItems' => $predefinedItems]);
    }

    //*** FUNCTION TO SERCH AND FILTER CATERGORY PACKAGES ***//
    public function searchpackage(Request $request)
    {
        
        $query = $request->input('query');
        $category = $request->input('category');

        $packages = Package::query();

        if (!empty($query)) {
            $packages->where('package_name', 'like', '%' . $query . '%');
        }

        if (!empty($category) && $category !== 'all') {
            $packages->where('category', $category);
        }

        $packages = $packages->get();
        $html = view('partision.package-list', compact('packages'))->render();
        return response()->json(['html' => $html]);
    }

}
