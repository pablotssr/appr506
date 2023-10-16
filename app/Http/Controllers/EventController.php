<?php

namespace App\Http\Controllers;


use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EventController extends Controller
{

    public function triggerEvent(Request $request)
    {
        $user = Auth::user();
        $pet = $user->pet;

        if (!$pet) {
            return response()->json(['message' => 'User does not have a pet'], 400);
        }

        // Define the probabilities for each event
        $eventProbabilities = [
            'sdf' => 0.2,  // 20% chance of 'sdf' event
            'love' => 0.3, // 30% chance of 'love' event
            'pigeon' => 0.2, // 10% chance of 'pigeon' event
            'covid' => 0.1, // 10% chance of 'covid' event
            'dep' => 0.1, // 20% chance of 'dep' event
            'best' => 0.1, // 10% chance of 'best' event
        ];

        // Randomly select an event based on probabilities
        $selectedEvent = $this->selectEvent($eventProbabilities);

        // Trigger the selected event
        return $this->$selectedEvent($pet);
    }

    private function selectEvent($eventProbabilities)
    {
        $rand = mt_rand() / mt_getrandmax();
        $cumulativeProbability = 0;

        foreach ($eventProbabilities as $event => $probability) {
            $cumulativeProbability += $probability;
            if ($rand <= $cumulativeProbability) {
                return $event;
            }
        }

        // This should never happen if probabilities sum to 1
        return null;
    }
    private function sdf($pet)
    {
        $user = Auth::user();
        $pet = $user->pet;

        if (!$pet) {
            return response()->json(['message' => 'User does not have a pet'], 400);
        }

        $sdf = Event::where('name', 'sdfEncounter')->first();
        if (!$sdf) {
            return response()->json(['message' => 'not found'], 400);
        }

        $before = $pet->health;
            if (rand(0, 1) == 0) {
                $pet->health -= $sdf->effect;
                $pet->save();
                return response()->json([
                    'event name' => 'sdf encounter',
                    'message' => 'dommage il ta planté',
                    'changes' => [
                        'Santé avant' => $before,
                        'Santé après' => $pet->health,
                    ],
                    'pet' => $pet
                ], 200);
            } else  {
                $pet->mental += ($sdf->effect) / 2;
                $pet->save();
                return response()->json([
                    'event name' => 'sdf encounter',
                    'message' => 'tu la fumé respect',
                    'changes' => [
                        'Mental avant' => $before,
                        'Mental apres' => $pet->mental,
                    ],
                    'pet' => $pet
                ], 200);
            }
        } 

    private function love($pet)
    {
        $user = Auth::user();
        $pet = $user->pet;

        if (!$pet) {
            return response()->json(['message' => 'User does not have a pet'], 400);
        }

        $love = Event::where('name', 'crushEncounter')->first();
        if (!$love) {
            return response()->json(['message' => 'not found'], 400);
        }

        $before = $pet->mental;

            if (rand(0, 1) == 0) {
                $pet->mental -= $love->effect;
                $pet->save();
                return response()->json([
                    'event name' => 'crush encounter',
                    'message' => 'dommage big flop',
                    'changes' => [
                        'Mental avant' => $before,
                        'Mental après' => $pet->mental,
                    ],
                    'pet' => $pet
                ], 200);
            } else  {
                $pet->mental += $love->effect;
                $pet->save();
                return response()->json([
                    'event name' => 'crush encounter',
                    'message' => "gg elle t'a adressé la parole",
                    'changes' => [
                        'Mental avant' => $before,
                        'Mental apres' => $pet->mental,
                    ],
                    'pet' => $pet
                ], 200);
            }
        }
    

    private function pigeon($pet)
    {
        $user = Auth::user();
        $pet = $user->pet;

        if (!$pet) {
            return response()->json(['message' => 'User does not have a pet'], 400);
        }

        $pigeon = Event::where('name', 'pigeon')->first();
        if (!$pigeon) {
            return response()->json(['message' => 'not found'], 400);
        }

        $before = $pet->clean;
        $pet->clean -= $pigeon->effect;
        $pet->save();
        return response()->json([
            'event name' => 'pigeon encounter',
            'message' => 'un pigeon est passé au dessus',
                    'changes' => [
                        'Propreté avant' => $before,
                        'Propreté après' => $pet->clean,
                    ],
                    'pet' => $pet
                ], 200);
    }

    private function covid($pet)
    {
        $user = Auth::user();
        $pet = $user->pet;

        if (!$pet) {
            return response()->json(['message' => 'User does not have a pet'], 400);
        }

        $coco = Event::where('name', 'covid')->first();
        if (!$coco) {
            return response()->json(['message' => 'not found'], 400);
        }

        $before = $pet->health;
        $pet->health -= $coco->effect;
        $pet->save();
                return response()->json([
                    'event name' => 'lecher la barre du metro',
                    'message' => 'connard de virus',
                    'changes' => [
                        'Santé avant' => $before,
                        'Santé après' => $pet->health,
                    ],
                    'pet' => $pet
                ], 200);
    }

    private function dep($pet)
    {
        $user = Auth::user();
        $pet = $user->pet;

        if (!$pet) {
            return response()->json(['message' => 'User does not have a pet'], 400);
        }

        $sad = Event::where('name', 'depression')->first();
        if (!$sad) {
            return response()->json(['message' => 'not found'], 400);
        }

        $before = $pet->health;
        $before2 = $pet->mental;
        
        if (rand(0, 1) == 0) {
                $pet->mental -= $sad->effect;
                $pet->health -= ($sad->effect)/2;
                $pet->save();
                return response()->json([
                    'event name' => 'ptite depression ?',
                    'message' => 'coup dur grande depression nerveuse',
                    'changes' => [
                        'Mental avant' => $before2,
                        'Mental après' => $pet->mental,
                        'Santé avant' => $before,
                        'Santé après' => $pet->health,
                    ],
                    'pet' => $pet
                ], 200);
            } else  {
                $pet->mental -= ($sad->effect)/2;
                $pet->health -= ($sad->effect)/4;
                $pet->save();
                return response()->json([
                    'event name' => 'ptite depression ?',
                    'message' => 'oui oui ça va aller',
                    'changes' => [
                        'Mental avant' => $before2,
                        'Mental apres' => $pet->mental,
                        'Santé avant' => $before,
                        'Santé apres' => $pet->health,
                    ],
                    'pet' => $pet
                ], 200);
            }
        
    }

    // public function money(Request $request)
    // {
    //     $user = Auth::user();
    //     $pet = $user->pet;

    //     if (!$pet) {
    //         return response()->json(['message' => 'User does not have a pet'], 400);
    //     }

        
    // }

    private function best($pet)
    {
        $user = Auth::user();
        $pet = $user->pet;

        if (!$pet) {
            return response()->json(['message' => 'User does not have a pet'], 400);
        }

        $best = Event::where('name', 'bestVersion')->first();
        if (!$best) {
            return response()->json(['message' => 'not found'], 400);
        }
        $before = $pet->health;
        $before2 = $pet->mental;
        $before3 = $pet->iq;
        $before4 = $pet->clean;

        $pet->health += $best->effect;
        $pet->mental += $best->effect;
        $pet->iq += ($best->effect)/5;
        $pet->clean += $best->effect;

        $pet->save();
        return response()->json([
            'event name' => 'grand respect',
                    'message' => 'masterclass tu es la meilleure version de toi même',
                    'changes' => [
                        'Santé avant' => $before,
                        'Mental avant' => $before2,
                        'QI avant' => $before3,
                        'Propreté avant' => $before4,
                        'Santé après' => $pet->health,
                        'Mental après' => $pet->mental,
                        'QI après' => $pet->iq,
                        'Propreté après' => $pet->clean,
                    ],
                    'pet' => $pet
                ], 200);
}
}