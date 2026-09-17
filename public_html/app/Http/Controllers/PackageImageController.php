<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\PackageImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Helper\Helper;
use Illuminate\Support\Facades\DB;

class PackageImageController extends Controller
{
    /**
     * Shows the list of package images for the given package Id.
     *
     * @param int $id The package id.
     *
     * @return \Illuminate\Http\Response
     */
    public function packageImages($id)
    {
        $package = Package::find($id);
        $packageImages = PackageImage::where('package_id', $id)->get();
        return view('package.packageimages', ['package' => $package, 'packageImages' => $packageImages]);
    }
    /**
     * Shows the form to upload package images for the given package id.
     *
     * @param int $id The package id.
     *
     * @return \Illuminate\Http\Response
     */
    public function createPackageImages($id)
    {
        $package = Package::find($id);
        if( !$package) {
            return redirect()->back()->with('error', 'Package not found');
        }
        return view('package.createpackageimages', ['package' => $package]);
    }
    /**
     * Stores the package images.
     */
    public function storePackageImages(Request $request)
    {
        $data = Validator::make($request->all(), [
            'package_images' => 'required|array|min:1',
            'package_images.*' => 'image|mimes:jpeg,png,webp,jpg,gif,svg,jfif|max:5120',
            'packageId' => 'required|exists:package,package_id',
        ]);

        if( $data->fails())
        {
            return redirect()->back()->withErrors($data)->withInput();
        }

        $data = $data->validated();

        DB::beginTransaction();
        try {
            foreach ($data['package_images'] as $image) {
                $packageImage = new PackageImage();
                $packageImage->package_id = $data['packageId'];
                $packageImage->image_path = Helper::getFileUrl($image, 'uploads/packages/images/');
                $packageImage->save();
            }

            DB::commit();
            return redirect()->back()->with('success', 'Package image added successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while adding the package image: ' . $e->getMessage());
        }
    }
    /**
     * Delete a package image by ID.
     *
     * @param int $id Package image ID
     * @return \Illuminate\Http\RedirectResponse
     */

    public function deletePackageImage($id)
    {
        $packageImage = PackageImage::find($id);
        if( !$packageImage) {
            return redirect()->back()->with('error', 'Package image not found');
        }
        $packageImage->delete();
        return redirect()->back()->with('success', 'Package image deleted successfully');
    }
}
