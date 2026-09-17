<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SEOController extends Controller
{
    public function home()
    {

        $settings = getAppSettings();
        return view('Admin.seoHome', compact('settings'));
    }

    public function packages()
    {

        $settings = getAppSettings();
        return view('Admin.seoPackages', compact('settings'));
    }



    public function contact()
    {

        $settings = getAppSettings();
        return view('Admin.seoContact', compact('settings'));
    }

    public function showSEO()
    {


        $settings = getAppSettings();
        // Return the 'Admin.task_management' view
        return view('Admin.SEO', ['settings' => $settings]);
    }


    public function saveImageAlt(Request $request){


        $filePath = storage_path('settings.json');

        // Load current settings from file or create an empty array if not exist
        $config = file_exists($filePath) ? json_decode(file_get_contents($filePath), true) : [];

        $file_name= $request->file_name;
        $image_alt= $request->image_alt;
        $image_page= $request->image_page;

        $config['app'][$image_page]['images'][$file_name]["alt"]= $image_alt;  

        

        file_put_contents($filePath, json_encode($config, JSON_PRETTY_PRINT));
        return response()->json([
            'success' => true,
            'message' => 'Image Alt saved successfully.',
            'data' => $config,  
        ]);
    }

    public function saveDetails(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'appName' => 'nullable|string|max:255',
            'appDescription' => 'nullable|string',
            'appKeywords' => 'nullable|string',
            'imageIcon' => 'nullable|image|mimes:ico,png,jpeg|max:1024',
            'imageLogo' => 'nullable|image|mimes:ico,png,jpeg|max:1024',
            'facebookLink' => 'nullable|string|max:255',
            'instagramLink' => 'nullable|string|max:255',
            'googleAnalyticsId' => 'nullable|string|max:255',

        ]);

        // Get the form inputs
        $appName = $request->appName;
        $app_description = $request->appDescription;
        $app_keywords = $request->appKeywords;
        $facebook_link=$request->facebookLink;
        $instagram_link=$request->instagramLink;
        $google_analytics_id=$request->googleAnalyticsId;


        // Path to settings.json file
        $filePath = storage_path('settings.json');

        // Load current settings from file or create an empty array if not exist
        $config = file_exists($filePath) ? json_decode(file_get_contents($filePath), true) : [];

        // Update settings with form data
        if (isset($appName)) {
            $config['app_name'] = $appName;
        }

        if (isset($app_description)) {
            $config['app_description'] = $app_description;
        }

        if (isset($app_keywords)) {
            $config['app_keywords'] = $app_keywords;
        }
        if (isset($app_keywords)) {
            $config['app_keywords'] = $app_keywords;
        }

        if(isset($facebook_link)){
            $config['facebook_link'] = $facebook_link;
        }

        if(isset($instagram_link)){
            $config['instagram_link'] = $instagram_link;
        }

        if(isset($google_analytics_id)){
            $config['google_analytics_id'] = $google_analytics_id;
        }

        if ($request->hasFile('imageIcon')) {

            $imageIcon = $request->file('imageIcon');
            $imageIconName = 'favicon_' . time() . '.' . $imageIcon->getClientOriginalExtension();
            $imageIcon->move(public_path('assets/images/Company'), $imageIconName);
            $config['app_icon'] = $imageIconName;  
        }

        if ($request->hasFile('imageLogo')) {
            $imageLogo = $request->file('imageLogo');
            $imageLogoName = 'logo_' . time() . '.' . $imageLogo->getClientOriginalExtension();
            $imageLogo->move(public_path('assets/images/Company'), $imageLogoName);
            $config['app_logo'] = $imageLogoName;  
        }

        // Save the updated config back to settings.json
        file_put_contents($filePath, json_encode($config, JSON_PRETTY_PRINT));

        return response()->json([
            'success' => true,
            'message' => 'App details saved successfully.',
            'data' => $config,  // Optionally return the updated config
        ]);
    }
}
