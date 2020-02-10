<?php

use Illuminate\Database\Seeder;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rooms')->insert([
            'id' => "1",
            'name' => "Phiên 1",
            "num_of_rows" => 14,
            "num_of_columns" => 15,
            "cols_have_space_left" => "7",
            'active'=> null,
        ]);

        DB::table('rooms')->insert([
            "id" => "2",
            'name' => "Phiên 2",
            "num_of_rows" => 14,
            "num_of_columns" => 15,
            "cols_have_space_left" => "7",
            'active'=> null,
        ]);
    }
}
