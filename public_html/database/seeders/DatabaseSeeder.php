<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
use Database\Seeders\ItemTableSeeder as SeedersItemTableSeeder;
use Illuminate\Database\Seeder;
use DB;
use EmployesTableSeeder;
use ItemTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $superAdmin = Admin::create([
            'name' => 'SuperAdmin',
            'email' => 'superadmin@example.com',
            'profile_image' => 'themes/grocery/uploads/avatar.png',
            'type' => 'superadmin',
            'email_verified_at' => null,
            'password' => bcrypt('1234'),
            'mobile' => 9999999999,
            'register_type' => 'email',
            'theme_id' => 'grocery',
            'created_by' => 0,
            'current_store' => 1,
            'lang' => 'en',
            'requested_plan' => 1, // Use a valid integer value here
        ]);

        $admin = Admin::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'profile_image' => 'themes/grocery/uploads/avatar.png',
            'type' => 'admin',
            'email_verified_at' => null,
            'password' => bcrypt('1234'),
            'mobile' => 9999999999,
            'register_type' => 'email',
            'theme_id' => 'grocery',
            'created_by' => 1,
            'current_store' => 2,
            'lang' => 'en',
            'requested_plan' => 1, // Use a valid integer value here
        ]);

        $data = [
            ['name' => 'title_text', 'value' => 'EcommerceGo SaaS', 'theme_id' => '4zero', 'store_id' => 1, 'created_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'footer_text', 'value' => 'EcommerceGo SaaS', 'theme_id' => '4zero', 'store_id' => 1, 'created_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'cust_theme_bg', 'value' => 'on', 'theme_id' => '4zero', 'store_id' => 1, 'created_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'SITE_RTL', 'value' => 'off', 'theme_id' => '4zero', 'store_id' => 1, 'created_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'cust_darklayout', 'value' => 'off', 'theme_id' => '4zero', 'store_id' => 1, 'created_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'logo_light', 'value' => 'storage/uploads/logo/logo-light.png', 'theme_id' => '4zero', 'store_id' => 1, 'created_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'logo_dark', 'value' => 'storage/uploads/logo/logo-dark.png', 'theme_id' => '4zero', 'store_id' => 1, 'created_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'favicon', 'value' => 'storage/uploads/logo/favicon.png', 'theme_id' => '4zero', 'store_id' => 1, 'created_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'enable_cookie', 'value' => 'on', 'theme_id' => '4zero', 'store_id' => 1, 'created_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'cookie_logging', 'value' => 'on', 'theme_id' => '4zero', 'store_id' => 1, 'created_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'cookie_title', 'value' => 'We use cookies!', 'theme_id' => '4zero', 'store_id' => 1, 'created_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'cookie_description', 'value' => 'Hi, this website uses essential cookies to ensure its proper operation and tracking cookies to understand how you interact with it', 'theme_id' => '4zero', 'store_id' => 1, 'created_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'necessary_cookies', 'value' => 'on', 'theme_id' => '4zero', 'store_id' => 1, 'created_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'strictly_cookie_title', 'value' => 'Strictly necessary cookies', 'theme_id' => '4zero', 'store_id' => 1, 'created_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'strictly_cookie_description', 'value' => 'These cookies are essential for the proper functioning of my website. Without these cookies, the website would not work properly', 'theme_id' => '4zero', 'store_id' => 1, 'created_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'more_information_description', 'value' => 'Contact Us Description', 'theme_id' => '4zero', 'store_id' => 1, 'created_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'contactus_url', 'value' => '#', 'theme_id' => '4zero', 'store_id' => 1, 'created_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'more_information_title', 'value' => '#', 'theme_id' => '4zero', 'store_id' => 1, 'created_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'enable_storelink', 'value' => 'on', 'theme_id' => '4zero', 'store_id' => 1, 'created_by' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'enable_domain', 'value' => 'off', 'theme_id' => '4zero', 'store_id' => 1, 'created_by' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'domains', 'value' => '', 'theme_id' => '4zero', 'store_id' => 1, 'created_by' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'enable_subdomain', 'value' => 'off', 'theme_id' => '4zero', 'store_id' => 1, 'created_by' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'subdomain', 'value' => '', 'theme_id' => '4zero', 'store_id' => 1, 'created_by' => 2, 'created_at' => now(), 'updated_at' => now()]
        ];

        DB::table('settings')->insert($data);

        //$this->call(CustomerTableSeeder::class);
        //$this->call(EmployesTableSeeder::class);
        //$this->call(SeedersItemTableSeeder::class);
        $itemdaa = [
            [
                'item_id' => 1,
                'item_name' => 'TX 7R Beam 230W Moving Head Light',
                'total_stock' => 26,
                'in_stock' => 26,
                'out_stock' => 0,
                'rent_price' => 2500.00,
                'product_amount' => 115000.00,
                'category' => 'Lights',
                'status' => 'Available',
                'description' => '● Moving Head Lights ● Light Source:Induction Lamps ● Input Voltage(V):AC90-240V 50-60HZ ● Lamp Power(W):230 ● Lamp Luminous Flux(lm):7950 ● Lamp Luminous Efficiency(lm/w):85 ● CRI (Ra>):85 ● Color Temperature(CCT):Cool White ● Working Temperature',
                'visible_to_customer' => 'Yes',
                'image' => 'uploads/products/17084142156516.webp',
                'created_at' => '2024-02-13 11:18:52',
                'updated_at' => '2024-02-13 11:18:52'
            ],
            [
                'item_id' => 2,
                'item_name' => 'LED Par Light 54x3W RGBW',
                'total_stock' => 100,
                'in_stock' => 100,
                'out_stock' => 0,
                'rent_price' => 500.00,
                'product_amount' => 15000.00,
                'category' => 'Lights',
                'status' => 'Available',
                'description' => 'LED Par lights with RGBW color mixing. Suitable for stage, wedding, and party lighting.',
                'visible_to_customer' => 'Yes',
                'image' => 'uploads/products/17084123114206.webp',
                'created_at' => '2024-02-14 10:22:33',
                'updated_at' => '2024-02-14 10:22:33'
            ],
            [
                'item_id' => 3,
                'item_name' => 'Wireless Microphone UHF',
                'total_stock' => 50,
                'in_stock' => 50,
                'out_stock' => 0,
                'rent_price' => 1200.00,
                'product_amount' => 60000.00,
                'category' => 'Audio',
                'status' => 'Available',
                'description' => 'High-quality UHF wireless microphone system, offering clear sound transmission with a long range.',
                'visible_to_customer' => 'Yes',
                'image' => 'uploads/products/17084196363952.webp',
                'created_at' => '2024-02-15 09:47:11',
                'updated_at' => '2024-02-15 09:47:11'
            ],
            [
                'item_id' => 4,
                'item_name' => 'DJ Mixer Pioneer DJM-900NXS2',
                'total_stock' => 10,
                'in_stock' => 10,
                'out_stock' => 0,
                'rent_price' => 4000.00,
                'product_amount' => 200000.00,
                'category' => 'Audio',
                'status' => 'Available',
                'description' => 'Professional 4-channel DJ mixer with advanced features and outstanding sound quality.',
                'visible_to_customer' => 'Yes',
                'image' => 'uploads/products/17084074855384.webp',
                'created_at' => '2024-02-16 12:34:56',
                'updated_at' => '2024-02-16 12:34:56'
            ],
            [
                'item_id' => 5,
                'item_name' => 'Line Array Sound System',
                'total_stock' => 5,
                'in_stock' => 5,
                'out_stock' => 0,
                'rent_price' => 10000.00,
                'product_amount' => 500000.00,
                'category' => 'Audio',
                'status' => 'Available',
                'description' => 'High-performance line array sound system, ideal for large events and professional sound reinforcement.',
                'visible_to_customer' => 'Yes',
                'image' => 'uploads/products/17084069484350.webp',
                'created_at' => '2024-02-17 14:45:45',
                'updated_at' => '2024-02-17 14:45:45'
            ],
            [
                'item_id' => 6,
                'item_name' => 'LED Video Wall P3.91',
                'total_stock' => 20,
                'in_stock' => 20,
                'out_stock' => 0,
                'rent_price' => 15000.00,
                'product_amount' => 300000.00,
                'category' => 'Visual',
                'status' => 'Available',
                'description' => 'High-resolution P3.91 LED video wall, perfect for concerts, corporate events, and outdoor advertising.',
                'visible_to_customer' => 'Yes',
                'image' => 'uploads/products/17084091858043.webp',
                'created_at' => '2024-02-18 16:56:45',
                'updated_at' => '2024-02-18 16:56:45'
            ],
            [
                'item_id' => 7,
                'item_name' => 'Stage Truss System',
                'total_stock' => 30,
                'in_stock' => 30,
                'out_stock' => 0,
                'rent_price' => 2000.00,
                'product_amount' => 60000.00,
                'category' => 'Stage',
                'status' => 'Available',
                'description' => 'Modular aluminum stage truss system, versatile for creating custom structures for events and shows.',
                'visible_to_customer' => 'Yes',
                'image' => 'uploads/products/17083433739031.webp',
                'created_at' => '2024-02-19 18:07:45',
                'updated_at' => '2024-02-19 18:07:45'
            ],
            [
                'item_id' => 8,
                'item_name' => 'Fog Machine 1500W',
                'total_stock' => 15,
                'in_stock' => 15,
                'out_stock' => 0,
                'rent_price' => 800.00,
                'product_amount' => 12000.00,
                'category' => 'Effects',
                'status' => 'Available',
                'description' => 'Powerful 1500W fog machine, creating dense, long-lasting fog effects for parties, events, and theatrical productions.',
                'visible_to_customer' => 'Yes',
                'image' => 'uploads/products/17084095205587.webp',
                'created_at' => '2024-02-20 20:18:45',
                'updated_at' => '2024-02-20 20:18:45'
            ],
            [
                'item_id' => 9,
                'item_name' => 'Projector 5000 Lumens',
                'total_stock' => 12,
                'in_stock' => 12,
                'out_stock' => 0,
                'rent_price' => 3500.00,
                'product_amount' => 42000.00,
                'category' => 'Visual',
                'status' => 'Available',
                'description' => 'High brightness 5000 lumens projector, suitable for presentations, movies, and outdoor screenings.',
                'visible_to_customer' => 'Yes',
                'image' => 'uploads/products/17084081517739.webp',
                'created_at' => '2024-02-21 22:29:01',
                'updated_at' => '2024-02-21 22:29:01'
            ],
            [
                'item_id' => 10,
                'item_name' => 'Portable PA System',
                'total_stock' => 20,
                'in_stock' => 20,
                'out_stock' => 0,
                'rent_price' => 1500.00,
                'product_amount' => 30000.00,
                'category' => 'Audio',
                'status' => 'Available',
                'description' => 'Compact and portable PA system, ideal for small events and gatherings.',
                'visible_to_customer' => 'Yes',
                'image' => 'uploads/products/1708406698826.webp',
                'created_at' => '2024-02-22 10:00:00',
                'updated_at' => '2024-02-22 10:00:00'
            ],
            [
                'item_id' => 11,
                'item_name' => 'LED Stage Light Bar',
                'total_stock' => 30,
                'in_stock' => 30,
                'out_stock' => 0,
                'rent_price' => 700.00,
                'product_amount' => 21000.00,
                'category' => 'Lights',
                'status' => 'Available',
                'description' => 'Versatile LED light bar for dynamic stage lighting effects.',
                'visible_to_customer' => 'Yes',
                'image' => 'uploads/products/17084183478618.webp',
                'created_at' => '2024-02-23 11:00:00',
                'updated_at' => '2024-02-23 11:00:00'
            ],
            [
                'item_id' => 12,
                'item_name' => 'Digital Mixing Console',
                'total_stock' => 8,
                'in_stock' => 8,
                'out_stock' => 0,
                'rent_price' => 5000.00,
                'product_amount' => 40000.00,
                'category' => 'Audio',
                'status' => 'Available',
                'description' => 'State-of-the-art digital mixing console for professional live sound and recording.',
                'visible_to_customer' => 'Yes',
                'image' => 'uploads/products/1708412593169.webp',
                'created_at' => '2024-02-24 12:00:00',
                'updated_at' => '2024-02-24 12:00:00'
            ],
            [
                'item_id' => 13,
                'item_name' => 'Spotlight with Stand',
                'total_stock' => 15,
                'in_stock' => 15,
                'out_stock' => 0,
                'rent_price' => 800.00,
                'product_amount' => 12000.00,
                'category' => 'Lights',
                'status' => 'Available',
                'description' => 'High-intensity spotlight, includes a durable stand for stage and event lighting.',
                'visible_to_customer' => 'Yes',
                'image' => 'uploads/products/17084122016409.webp',
                'created_at' => '2024-02-25 13:00:00',
                'updated_at' => '2024-02-25 13:00:00'
            ],
            [
                'item_id' => 14,
                'item_name' => 'Confetti Cannon',
                'total_stock' => 10,
                'in_stock' => 10,
                'out_stock' => 0,
                'rent_price' => 900.00,
                'product_amount' => 9000.00,
                'category' => 'Effects',
                'status' => 'Available',
                'description' => 'Powerful confetti cannon for celebrations and events, creating a spectacular effect.',
                'visible_to_customer' => 'Yes',
                'image' => 'uploads/products/17084179645223.webp',
                'created_at' => '2024-02-26 14:00:00',
                'updated_at' => '2024-02-26 14:00:00'
            ],
            [
                'item_id' => 15,
                'item_name' => 'Stage Lighting Controller',
                'total_stock' => 20,
                'in_stock' => 20,
                'out_stock' => 0,
                'rent_price' => 2000.00,
                'product_amount' => 40000.00,
                'category' => 'Lights',
                'status' => 'Available',
                'description' => 'Advanced lighting controller for managing complex lighting setups on stage.',
                'visible_to_customer' => 'Yes',
                'image' => 'uploads/products/17084127262197.webp',
                'created_at' => '2024-02-27 15:00:00',
                'updated_at' => '2024-02-27 15:00:00'
            ],
            [
                'item_id' => 16,
                'item_name' => 'Battery Powered LED Uplight',
                'total_stock' => 40,
                'in_stock' => 40,
                'out_stock' => 0,
                'rent_price' => 600.00,
                'product_amount' => 24000.00,
                'category' => 'Lights',
                'status' => 'Available',
                'description' => 'Versatile and portable uplight with battery operation for easy placement and setup.',
                'visible_to_customer' => 'Yes',
                'image' => 'uploads/products/1707803402.gif',
                'created_at' => '2024-02-28 16:00:00',
                'updated_at' => '2024-02-28 16:00:00'
            ],
            [
                'item_id' => 17,
                'item_name' => 'Karaoke Machine with Microphones',
                'total_stock' => 25,
                'in_stock' => 25,
                'out_stock' => 0,
                'rent_price' => 1100.00,
                'product_amount' => 27500.00,
                'category' => 'Audio',
                'status' => 'Available',
                'description' => 'Fun and easy-to-use karaoke machine, comes with two microphones for duets and parties.',
                'visible_to_customer' => 'Yes',
                'image' => 'uploads/products/17084131938171.webp',
                'created_at' => '2024-02-29 17:00:00',
                'updated_at' => '2024-02-29 17:00:00'
            ]
        ];

        DB::table('item')->insert($itemdaa);

        DB::table('item_categories')->insert([
            ['id' => 1, 'name' => 'Lights'],
            ['id' => 2, 'name' => 'Effects'],
            ['id' => 3, 'name' => 'Audio'],
            ['id' => 4, 'name' => 'Stage'],
            ['id' => 5, 'name' => 'Visual'],
        ]);

        DB::table('customer')->insert([
            ['customer_id' => 2, 'customer_name' => 'Sasindu Seeker Entertainment', 'nic' => '1', 'location' => 'matara', 'customer_phone' => '0710358723', 'address' => 'godagama', 'city' => 'Matara, Sri Lanka', 'status' => 'open', 'points' => NULL, 'register_date' => '2024-02-14', 'created_at' => '2024-02-14 10:35:25', 'updated_at' => '2024-02-14 10:35:25'],
            ['customer_id' => 4, 'customer_name' => 'Vaga Arachchi', 'nic' => '89', 'location' => 'matara', 'customer_phone' => '0716720151', 'address' => 'polhena', 'city' => 'Matara, Sri Lanka', 'status' => 'open', 'points' => NULL, 'register_date' => '2024-02-14', 'created_at' => '2024-02-14 10:36:35', 'updated_at' => '2024-02-14 10:36:35'],
            ['customer_id' => 5, 'customer_name' => 'University of Ruhuna faculty of science', 'nic' => '2', 'location' => 'matara', 'customer_phone' => '0714455091', 'address' => 'Ruhuna Matara', 'city' => 'Matara, Sri Lanka', 'status' => 'open', 'points' => NULL, 'register_date' => '2024-02-14', 'created_at' => '2024-02-14 10:38:44', 'updated_at' => '2024-02-14 10:38:44'],
            ['customer_id' => 6, 'customer_name' => 'Black Jay DJ', 'nic' => '90', 'location' => 'matara', 'customer_phone' => '0771981188', 'address' => 'Weligama', 'city' => 'weligama', 'status' => 'open', 'points' => NULL, 'register_date' => '2024-02-14', 'created_at' => '2024-02-14 10:40:25', 'updated_at' => '2024-02-14 10:40:25'],
            ['customer_id' => 7, 'customer_name' => 'Chamara Lion Entertainment', 'nic' => '91', 'location' => 'matara', 'customer_phone' => '0771645073', 'address' => 'galla', 'city' => 'galle', 'status' => 'open', 'points' => NULL, 'register_date' => '2024-02-14', 'created_at' => '2024-02-14 10:42:49', 'updated_at' => '2024-02-14 10:42:49'],
            ['customer_id' => 8, 'customer_name' => 'Cool Zone', 'nic' => '92', 'location' => 'matara', 'customer_phone' => '0777901935', 'address' => 'Galle', 'city' => 'galle', 'status' => 'open', 'points' => NULL, 'register_date' => '2024-02-14', 'created_at' => '2024-02-14 10:45:33', 'updated_at' => '2024-02-14 10:45:33'],
            // Add all other records similarly
        ]);

        DB::table('employes')->insert([
            'name' => 'Ravindu Yasara',
            'email' => 'ravinduyasara@gmail.com',
            'emp_type' => 'Permenent Employee',
            'basic_amount' => '50000',
            'etf'  => 5000,
            'epf' => 5000,
            'password' => '$1234',
            'code' => '1234',
            'active' => 'active',
            'regdate' => '2024-02-14',
            'created_at' => '2024-02-14 08:39:45',
            'updated_at' => '2024-02-14 08:39:45',
        ]);

    }
}
