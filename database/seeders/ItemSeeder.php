<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('items')->insert([
            [
                'name' => 'Jouet Bien',
                'price' => 75,
                'effect' => 15,
                'type' => 'jouet',
            ],
            [
                'name' => 'Jouet Nul',
                'price' => 75,
                'effect' => 10,
                'type' => 'jouet',
            ],
            [
                'name' => 'Nourriture Bonne',
                'price' => 50,
                'effect' => 15,
                'type' => 'nourriture',
            ],
            [
                'name' => 'Nourriture Mauvaise',
                'price' => 50,
                'effect' => 10,
                'type' => 'nourriture',
            ],
            [
                'name' => 'Petit Soin',
                'price' => 50,
                'effect' => 10,
                'type' => 'soin',
            ],
            [
                'name' => 'Gros Soin',
                'price' => 50,
                'effect' => 20,
                'type' => 'soin',
            ],
        ]);
    }
}
