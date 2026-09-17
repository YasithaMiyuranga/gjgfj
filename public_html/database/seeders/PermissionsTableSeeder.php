<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::insert([
            ['name' => 'view_customer_details', 'description' => 'View customer details','created_at' => now(), 'updated_at' => now()],
            ['name' => 'view_all_booking_events', 'description' => 'All booking events show or selected events show access','created_at' => now(), 'updated_at' => now()],
            ['name' => 'view_rent_items', 'description' => 'Can access rent items list','created_at' => now(), 'updated_at' => now()],
            ['name' => 'create_rent_item', 'description' => 'Can create new rent item list','created_at' => now(), 'updated_at' => now()],
            ['name' => 'receive_rent_item', 'description' => 'Receive rent item access','created_at' => now(), 'updated_at' => now()],
        ]);

    }
}
