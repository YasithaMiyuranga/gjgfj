<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('customer')->insert([
            ['customer_id' => 2, 'customer_name' => 'Sasindu Seeker Entertainment', 'nic' => '1', 'location' => 'matara', 'customer_phone' => '0710358723', 'address' => 'godagama', 'city' => 'Matara, Sri Lanka', 'status' => 'open', 'points' => NULL, 'register_date' => '2024-02-14', 'created_at' => '2024-02-14 10:35:25', 'updated_at' => '2024-02-14 10:35:25'],
            ['customer_id' => 4, 'customer_name' => 'Vaga Arachchi', 'nic' => '89', 'location' => 'matara','customer_phone' => '0716720151', 'address' => 'polhena', 'city' => 'Matara, Sri Lanka', 'status' => 'open', 'points' => NULL, 'register_date' => '2024-02-14', 'created_at' => '2024-02-14 10:36:35', 'updated_at' => '2024-02-14 10:36:35'],
            ['customer_id' => 5, 'customer_name' => 'University of Ruhuna faculty of science', 'nic' => '2', 'location' => 'matara', 'customer_phone' => '0714455091', 'address' => 'Ruhuna Matara', 'city' => 'Matara, Sri Lanka', 'status' => 'open', 'points' => NULL, 'register_date' => '2024-02-14', 'created_at' => '2024-02-14 10:38:44', 'updated_at' => '2024-02-14 10:38:44'],
            ['customer_id' => 6, 'customer_name' => 'Black Jay DJ', 'nic' => '90', 'location' => 'matara', 'customer_phone' => '0771981188', 'address' => 'Weligama', 'city' => 'weligama', 'status' => 'open', 'points' => NULL, 'register_date' => '2024-02-14', 'created_at' => '2024-02-14 10:40:25', 'updated_at' => '2024-02-14 10:40:25'],
            ['customer_id' => 7, 'customer_name' => 'Chamara Lion Entertainment', 'nic' => '91', 'location' => 'matara', 'customer_phone' => '0771645073', 'address' => 'galla', 'city' => 'galle', 'status' => 'open', 'points' => NULL, 'register_date' => '2024-02-14', 'created_at' => '2024-02-14 10:42:49', 'updated_at' => '2024-02-14 10:42:49'],
            ['customer_id' => 8, 'customer_name' => 'Cool Zone', 'nic' => '92', 'location' => 'matara','customer_phone' => '0777901935', 'address' => 'Galle', 'city' => 'galle', 'status' => 'open', 'points' => NULL, 'register_date' => '2024-02-14', 'created_at' => '2024-02-14 10:45:33', 'updated_at' => '2024-02-14 10:45:33'],
            // Add all other records similarly
        ]);
    }
}
