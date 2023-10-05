<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('events')->insert([
            [
                'name' => 'sdfEncounter',
                'effect' => 20,
            ],
            [
                'name' => 'crushEncounter',
                'effect' => 15,
            ],
            [
                'name' => 'pigeon',
                'effect' => 10,
            ],
            [
                'name' => 'covid',
                'effect' => 10,
            ],
            [
                'name' => 'depression',
                'effect' => 40,
            ],
            [
                'name' => 'moneyEncounter',
                'effect' => 50,
            ],
            [
                'name' => 'bestVersion',
                'effect' => 100,
            ],
        ]);
    }
}
