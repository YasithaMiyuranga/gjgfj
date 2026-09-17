<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\packageitem;
use Illuminate\Support\Facades\DB;
use App\Models\package;

class PackageitemController extends Controller
{
    public function view()
    {
        $categories = packageitem::all();
        return view('packageitem.packageitem', compact('categories'));

    }
    public function add()
    {
        $package = package::all();
        return view('packageitem.packageitemadd', compact('package'));


    }
    public function store(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'package_id' => 'required',
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Add image validation rules',
            'qty' => 'required',
            'description' => 'required',
            'status' => 'required',

        ]);

        $imageName = time().'.'.$request->image->extension(); // Generate a unique name for the image
        $request->image->move(public_path('uploads'), $imageName);

        // Create a new Sideterm
        $sideterm = new packageItem();
        $sideterm->package_id = $request->input('package_id');
        $sideterm->name = $request->input('name');
        $sideterm->image =$imageName;
        $sideterm->qty = $request->input('qty');
        $sideterm->description = $request->input('description');
        $sideterm->status = $request->input('status');

        $sideterm->save();

        return back()->with('status', 'Data updated successfully');
    }

    public function delete($id)
{

    $offices = packageitem::find($id);
    $offices->delete();
  return back()->with('success', 'Record deleted successfully');

}

public function edit($id)
{
    $package = DB::table('package_item')->where('id', $id)->first();

    if ($package) {
        return view('packageitem.packageitemedit', compact('package'));
    } else {
        return back()->with('success', 'Record deleted successfully');
    }
}

public function updates(Request $request, $id)
{
    $affected = DB::table('package_item')
        ->where('id', $id)
        ->update([

            'name' => $request->input('name'),
            'image' => $request->input('image'),
            'qty' => $request->input('qty'),
            'description' => $request->input('description'),
            'status' => $request->input('status'),



        ]);

    if ($affected > 0) {
        return back()->with('status', 'Data updated successfully');
    } else {
        return back()->with('status', 'Data updated successfully');
    }
}

}
