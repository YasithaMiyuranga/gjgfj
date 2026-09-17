<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubOptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sub_options')->insert([
            ['name' => 'Task Management', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Team Assignment', 'created_at' => now(), 'updated_at' => now()],            
            ['name' => 'Budget Allocation', 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}
