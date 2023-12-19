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
                'name' => 'sdfEncounter1',
                'eventDesc' => "S'est fait lever par un clodo",
                'effect' => 20,
            ],
            [
                'name' => 'sdfEncounter2',
                'eventDesc' => 'À bastonné un clodo',
                'effect' => 20,
            ],
            [
                'name' => 'crushEncounter1',
                'eventDesc' => "À rencontré l'amour et s'est fait recaler",
                'effect' => 15,
            ],
            [
                'name' => 'crushEncounter',
                'eventDesc' => "À rencontré l'amour et ça se passe bien",
                'effect' => 15,
            ],
            [
                'name' => 'pigeon',
                'eventDesc' => "S'est fait étronné dessus par un pigeon",
                'effect' => 10,
            ],
            [
                'name' => 'covid',
                'eventDesc' => "À attrapé le covid en 2023 mdr",
                'effect' => 10,
            ],
            [
                'name' => 'depression1',
                'eventDesc' => "Méga dépression nerveuse",
                'effect' => 40,
            ],
            [
                'name' => 'depression2',
                'eventDesc' => "À pris un coup au moral mais ça va",
                'effect' => 40,
            ],
            [
                'name' => 'moneyEncounter',
                'eventDesc' => "À trouvé l'argent de quelqu'un",
                'effect' => 50,
            ],
            [
                'name' => 'bestVersion',
                'eventDesc' => "À ouvert son troisième œil",
                'effect' => 100,
            ],
        ]);
    }
}
