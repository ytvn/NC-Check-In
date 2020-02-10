<?php

use Illuminate\Database\Seeder;

class PassCodeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pass_codes')->insert([
            'pass_code' => '12345678',
            'description' => "test",
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
