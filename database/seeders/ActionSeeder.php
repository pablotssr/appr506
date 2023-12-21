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
                'diaryDesc' => 'Petite tape sur le front'
            ],
            [
                'name' => 'give object',
                'effect' => 20,
                'diaryDesc' => 'À reçu un objet'
            ],
            [
                'name' => 'clean',
                'effect' => 15,
                'diaryDesc' => "À pris une douche"
            ],
            [
                'name' => 'snake',
                'effect' => 0,
                'diaryDesc' => 'Partie de snake'
            ],
            [
                'name' => 'run',
                'effect' => 0,
                'diaryDesc' => 'Petite course'
            ],
            [
                'name' => 'math',
                'effect' => 0,
                'diaryDesc' => 'Calcul mental'
            ],
        ]);
    }
}
