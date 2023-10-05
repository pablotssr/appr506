<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('actions')->insert([
            [
                'name' => 'caresser',
                'effect' => 15,
            ],
            [
                'name' => 'give object',
                'effect' => 20,
            ],
            [
                'name' => 'clean',
                'effect' => 15,
            ],
            [
                'name' => 'snake',
                'effect' => 0,
            ],
            [
                'name' => 'run',
                'effect' => 0,
            ],
            [
                'name' => 'math',
                'effect' => 0,
            ],
        ]);
    }
}
