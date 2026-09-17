<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('employes')->insert([
            'name' => 'Ravindu Yasara',
            'email' => 'ravinduyasara@gmail.com',
            'emp_type' => 'Payment Employee',
            'basic_amount' => '50000',
            'etf'  => '5000',
            'epf' => '5000',
            'password' => '$1234',
            'code' => '1234',
            'active' => 'active',
            'regdate' => '2024-02-14',
            'created_at' => '2024-02-14 08:39:45',
            'updated_at' => '2024-02-14 08:39:45',
        ]);
    }
}
