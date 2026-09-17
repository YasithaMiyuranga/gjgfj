<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use DB;

class Utility extends Model
{
    use HasFactory;

    public static function Seting()
    {

        $array['date_format'] = 'Y-m-d';
        $array['is_cod_enabled'] = 'on';
        $array['is_bank_transfer_enabled'] = 'on';
        $array['CURRENCY_NAME'] = 'USD';
        $array['CURRENCY'] = '$';
        $array['title_text'] = 'EcommerceGo';
        $array['footer_text'] = 'EcommerceGo';
        $array['SITE_RTL'] = 'off';
        $array['cust_theme_bg'] = 'on';
        $array['cust_darklayout'] = 'on';
        $array['color'] = 'theme-3';
        $array['site_date_format'] = 'M j, Y';
        $array['site_time_format'] = 'g:i A';
        $array['logo_light'] = 'storage/uploads/logo/logo-light.png';
        $array['logo_dark'] = 'storage/uploads/logo/logo-dark.png';
        $array['favicon'] = 'storage/uploads/logo/favicon.png';
        $array['theme_logo'] = 'storage/uploads/logo/logo.png';
        $array['invoice_logo'] = 'storage/uploads/logo/logo.png';
        $array['theme_favicon'] = 'storage/uploads/logo/Favicon.png';
        $array['metakeyword'] = '';
        $array['metadesc'] = '';
        $array['google_analytic'] = '';
        $array['fbpixel_code'] = '';
        $array['storejs'] = '';
        $array['storage_setting'] = 'local';
        $array['local_storage_validation'] = 'jpg,jpeg,png,csv,svg,pdf';
        $array['local_storage_max_upload_size'] = '2048000';
        $array['s3_key'] = '';
        $array['s3_secret'] = '';
        $array['s3_region'] = '';
        $array['s3_bucket'] = '';
        $array['s3_url'] = '';
        $array['s3_endpoint'] = '';
        $array['s3_max_upload_size'] = '';
        $array['s3_storage_validation'] = '';
        $array['wasabi_key'] = '';
        $array['wasabi_secret'] = '';
        $array['wasabi_region'] = '';
        $array['wasabi_bucket'] = '';
        $array['wasabi_url'] = '';
        $array['wasabi_root'] = '';
        $array['wasabi_max_upload_size'] = '';
        $array['wasabi_storage_validation'] = '';
        $array['MAIL_DRIVER'] = '';
        $array['MAIL_HOST'] = '';
        $array['MAIL_PORT'] = '';
        $array['MAIL_USERNAME'] = '';
        $array['MAIL_PASSWORD'] = '';
        $array['MAIL_ENCRYPTION'] = '';
        $array['MAIL_FROM_NAME'] = '';
        $array['MAIL_FROM_ADDRESS'] = '';
        $array['enable_storelink'] = 'on';
        $array['enable_domain'] = 'off';
        $array['domains'] = '';
        $array['enable_subdomain'] = 'off';
        $array['subdomain'] = '';
        $array['metaimage'] = 'themes/grocery/theme_img/img_1.png';
        $array['enable_cookie'] = 'on';
        $array['necessary_cookies'] = 'on';
        $array['cookie_logging'] = 'on';
        $array['cookie_title'] = 'We use cookies!';
        $array['cookie_description'] = 'Hi, this website uses essential cookies to ensure its proper operation and tracking cookies to understand how you interact with it.';
        $array['strictly_cookie_title'] = 'Strictly necessary cookies';
        $array['strictly_cookie_description'] = 'These cookies are essential for the proper functioning of my website. Without these cookies, the website would not work properly';
        $array['more_information_description'] = 'For any queries in relation to our policy on cookies and your choices, please';
        $array['more_information_title'] = '';
        $array['contactus_url'] = '#';
        $array['chatgpt_key'] = '';

        return $array;
    }

    public static function upload_file($request, $key_name, $name, $path, $custom_validation = [], $image = '')
    {
        try {
            $settings = Utility::Seting();
            if (!empty($settings['storage_setting'])) {
                if ($settings['storage_setting'] == 'wasabi') {
                    config(
                        [
                            'filesystems.disks.wasabi.key' => $settings['wasabi_key'],
                            'filesystems.disks.wasabi.secret' => $settings['wasabi_secret'],
                            'filesystems.disks.wasabi.region' => $settings['wasabi_region'],
                            'filesystems.disks.wasabi.bucket' => $settings['wasabi_bucket'],
                            'filesystems.disks.wasabi.endpoint' => 'https://s3.' . $settings['wasabi_region'] . '.wasabisys.com'
                        ]
                    );

                    $max_size = !empty($settings['wasabi_max_upload_size']) ? $settings['wasabi_max_upload_size'] : '2048';
                    $mimes =  !empty($settings['wasabi_storage_validation']) ? $settings['wasabi_storage_validation'] : '';
                } else if ($settings['storage_setting'] == 's3') {
                    config(
                        [
                            'filesystems.disks.s3.key' => $settings['s3_key'],
                            'filesystems.disks.s3.secret' => $settings['s3_secret'],
                            'filesystems.disks.s3.region' => $settings['s3_region'],
                            'filesystems.disks.s3.bucket' => $settings['s3_bucket'],
                            'filesystems.disks.s3.use_path_style_endpoint' => false,
                        ]
                    );
                    $max_size = !empty($settings['s3_max_upload_size']) ? $settings['s3_max_upload_size'] : '2048';
                    $mimes =  !empty($settings['s3_storage_validation']) ? $settings['s3_storage_validation'] : '';
                } else {
                    $max_size = !empty($settings['local_storage_max_upload_size']) ? $settings['local_storage_max_upload_size'] : '2048';

                    $mimes =  !empty($settings['local_storage_validation']) ? $settings['local_storage_validation'] : '';
                }


                $file = !empty($image) ? $image : $request->$key_name;
                // $file = $request->$key_name;

                if (count($custom_validation) > 0) {
                    $validation = $custom_validation;
                } else {

                    $validation = [
                        'mimes:' . $mimes,
                        'max:' . $max_size,
                    ];
                }

                if (empty($image)) {
                    $validator = \Validator::make($request->all(), [
                        $key_name => $validation
                    ]);
                }


                if (empty($image) && $validator->fails()) {
                    $res = [
                        'flag' => 0,
                        'msg' => $validator->messages()->first(),
                    ];
                    return $res;
                } else {

                    $name = $name;

                    if ($settings['storage_setting'] == 'local') {
                        $path = $path . '/';
                        $image = !empty($image) ? $image : $request->file($key_name);
                        \Storage::disk('theme')->putFileAs(
                            $path,
                            $image,
                            $name
                        );
                        $path = $path . $name;
                    } else if ($settings['storage_setting'] == 'wasabi') {
                        $image = !empty($image) ? $image : $request->file($key_name);
                        $path = \Storage::disk('wasabi')->putFileAs($path, $image, $name);
                    } else if ($settings['storage_setting'] == 's3') {
                        $path = \Storage::disk('s3')->putFileAs(
                            $path,
                            $file,
                            $name
                        );
                    }

                    $image_url = '';
                    if ($settings['storage_setting'] == 'local') {
                        $image_url = url($path);
                    } else if ($settings['storage_setting'] == 'wasabi') {
                        $image_url = \Storage::disk('wasabi')->url($path);
                    } else if ($settings['storage_setting'] == 's3') {
                        $image_url = \Storage::disk('s3')->url($path);
                    }

                    $res = [
                        'flag' => 1,
                        'msg'  => 'success',
                        'url'  => $path,
                        'image_path'  => $path,
                        'full_url'  => $image_url
                    ];

                    return $res;
                }
            } else {
                $res = [
                    'flag' => 0,
                    'msg' => __('Please set proper configuration for storage.'),
                ];


                return $res;
            }
        } catch (\Exception $e) {
            $res = [
                'flag' => 0,
                'msg' => $e->getMessage(),
            ];
            return $res;
        }
    }

    public static function keyWiseUpload_file($request, $key_name, $name, $path, $data_key, $custom_validation = [])
    {
    }
}
