<?php

use Illuminate\Database\Seeder;

class CouriersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('couriers')->insert([
            'name' => 'JNE',
            'status' => 1
        ]);
        DB::table('couriers')->insert([
            'name' => 'J&T',
            'status' => 1
        ]);
        DB::table('couriers')->insert([
            'name' => 'Wahana',
            'status' => 1
        ]);
        DB::table('couriers')->insert([
            'name' => 'Ninja Express',
            'status' => 1
        ]);
        DB::table('couriers')->insert([
            'name' => 'SiCepat',
            'status' => 1
        ]);
        DB::table('couriers')->insert([
            'name' => 'GoJek',
            'status' => 1
        ]);
        DB::table('couriers')->insert([
            'name' => 'Grab',
            'status' => 1
        ]);
    }
}
