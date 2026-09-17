<?php

if (!function_exists('getAppSettings')) {
    /**
     * Get the app settings from the JSON file.
     *
     * @return array
     */
    function getAppSettings()
    {
        $filePath = storage_path('settings.json'); 
        if (file_exists($filePath)) {
            $json = file_get_contents($filePath);
            return json_decode($json, true);
        }
        return [];
    }
}
