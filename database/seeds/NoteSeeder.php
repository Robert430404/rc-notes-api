<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('notes')->insert([
            'name'    => str_random(10),
            'content' => str_random(100),
            'type'    => rand(1,3),
        ]);
    }
}
