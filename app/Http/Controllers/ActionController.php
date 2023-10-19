<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Inventory;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\DiaryController;
use App\Http\Controllers\EventController;

class ActionController extends Controller
{
    //
    public function laver(Request $request)
    {
        $user = Auth::user();
        $pet = $user->pet;
        if (!$pet) {
            return response()->json(['message' => 'User does not have a pet'], 400);
        }

        $laver = Action::where('name', 'clean')->first();
        if (!$laver) {
            return response()->json(['message' => 'not found'], 400);
        }

        $before = $pet->clean;
        $event_id = null;

        if ($pet->clean == 100) {
            return response()->json(['message' => 'il est déjà hyper clean pas besoin', 'pet' => $pet], 200);
        }

        $actionDone = new DiaryController();
        $responseAction = $actionDone->actionDone($laver, $event_id, $request);

        if ($responseAction->getStatusCode() !== 200) {
            return $responseAction; 
        }

        $pet->clean += $laver->effect;
        $pet->save();

        $response = [
            'Message' => 'ptite douche c tt clean la',
            'Changes' => [
                'Propreté_avant' => $before,
                'Propreté_après' => $pet->clean
            ],
            'Pet' => $pet,
        ];
        
        return response()->json(['actionDone' => $responseAction,'laver' => $response], 200);
    }

    public function caresse(Request $request)
    {
        $user = Auth::user();
        $pet = $user->pet;
        if (!$pet) {
            return response()->json(['message' => 'User does not have a pet'], 400);
        }

        $caresse = Action::where('name', 'caresser')->first();
        if (!$caresse) {
            return response()->json(['message' => 'not found'], 400);
        }

        $before = $pet->mental;
        $event_id = null;

        if ($pet->mental == 100) {
            return response()->json(['message' => 'il est déjà o max pas besoin', 'pet' => $pet], 200);
        }

        $actionDone = new DiaryController();
        $responseAction = $actionDone->actionDone($caresse, $event_id, $request);

        if ($responseAction->getStatusCode() !== 200) {
            return $responseAction; 
        }

        $pet->mental += $caresse->effect;
        $pet->save();

        $response = [
                'Message' => 'ptite tape sur le front la',
                'Changes' => [
                    'Mental_avant' => $before,
                    'Mental_après' => $pet->mental
                ],
                'pet' => $pet,
            ];
        
        return response()->json(['actionDone' => $responseAction,'caresser' => $response], 200);

    }

    public function giveItem(Request $request)
    {
        $user = Auth::user();
        $pet = $user->pet;

        if (!$pet) {
            return response()->json(['message' => 'User does not have a pet'], 400);
        }
        
        $give = Action::where('name', 'give object')->first();
        if (!$give) {
            return response()->json(['message' => 'not found'], 400);
        }
        
        $event_id = null;

        $actionDone = new DiaryController();
        $responseAction = $actionDone->actionDone($give, $event_id,$request);

        if ($responseAction->getStatusCode() !== 200) {
            return $responseAction;
        }
        
        $donner = $request->input('give');
        $item = Inventory::find($donner);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $b = Item::where('id', $item->item_id)->first();

        if ($item->item_id == 1) {
            $before = $pet->mental;

            if ($pet->mental == 100) {
                return response()->json(['message' => 'il est déjà o max pas besoin', 'pet' => $pet], 200);
            }

            $pet->mental += $b->effect;
            $pet->save();
            $item->delete();

            $response = [
                    'tu_a_donné' => "{$b->name} à {$pet->name}",
                    'changes' => [
                        'Mental_avant' => $before,
                        'Mental_après' => $pet->mental
                    ],
                    'pet' => $pet,
                ];
                
            } elseif ($item->item_id == 2) {
            $before = $pet->mental;

            $pet->mental -= $b->effect;
            $pet->save();
            $item->delete();
            $responseb = [
                    'tu_a_donné' => "{$b->name} à {$pet->name}",
                    'changes' => [
                        'Mental_avant' => $before,
                        'Mental_après' => $pet->mental
                    ],
                    'pet' => $pet,
                ];
            } elseif ($item->item_id == 3) {
            $before = $pet->mental;
            $before2 = $pet->health;

            if ($pet->mental == 100 || $pet->health == 100) {
                return response()->json(['message' => 'il est déjà o max pas besoin', 'pet' => $pet], 200);
            }

            $pet->mental += $b->effect;
            $pet->health += ($b->effect) / 3;
            $pet->save();
            $item->delete();
            $response = [
                    'tu_a_donné' => "{$b->name} à {$pet->name}",
                    'changes' => [
                        'Mental_avant' => $before,
                        'Mental_après' => $pet->mental,
                        'Santé_avant' => $before2,
                        'Santé_après' => $pet->health
                    ],
                    'pet' => $pet,
                ];
            } elseif ($item->item_id == 4) {
            $before = $pet->mental;
            $before2 = $pet->health;

            $pet->mental -= $b->effect;
            $pet->health -= ($b->effect) / 2;
            $pet->save();
            $item->delete();
            $response = [
                    'tu_a_donné' => "{$b->name} à {$pet->name}",
                    'changes' => [
                        'Mental_avant' => $before,
                        'Mental_après' => $pet->mental,
                        'Santé_avant' => $before2,
                        'Santé_après' => $pet->health
                    ],
                    'pet' => $pet,
                ];
            } elseif ($item->item_id == 5) {
            $before = $pet->mental;
            $before2 = $pet->health;

            if ($pet->health == 100) {
                return response()->json(['message' => 'il est déjà o max pas besoin', 'pet' => $pet], 200);
            }

            $pet->mental += ($b->effect) / 2;
            $pet->health += $b->effect;
            $pet->save();
            $item->delete();
            $response = [
                    'tu_a_donné' => "{$b->name} à {$pet->name}",
                    'changes' => [
                        'Mental_avant' => $before,
                        'Mental_après' => $pet->mental,
                        'Santé_avant' => $before2,
                        'Santé_après' => $pet->health
                    ],
                    'pet' => $pet,
                ];
            } elseif ($item->item_id == 6) {
            $before = $pet->mental;
            $before2 = $pet->health;

            if ($pet->health == 100) {
                return response()->json(['message' => 'il est déjà o max pas besoin', 'pet' => $pet], 200);
            }

            $pet->mental += ($b->effect) / 2;
            $pet->health += $b->effect;
            $pet->save();
            $item->delete();

            $response = [
                    'tu_a_donné' => "{$b->name} à {$pet->name}",
                    'changes' => [
                        'Mental_avant' => $before,
                        'Mental_après' => $pet->mental,
                        'Santé_avant' => $before2,
                        'Santé_après' => $pet->health
                    ],
                    'pet' => $pet,
                ];
            } 

            return response()->json(['actionDone' => $responseAction,'giveitem' => $response], 200);
    }
        
    public function snake(Request $request)
    {
        $user = Auth::user();
        $pet = $user->pet;
        if (!$pet) {
            return response()->json(['message' => 'User does not have a pet'], 400);
        }

        $snake = Action::where('name', 'snake')->first();
        if (!$snake) {
            return response()->json(['message' => 'not found'], 400);
        }

        $score = rand(0, 40);
        $before = $pet->mental;
        $event_id = null;

        $actionDone = new DiaryController();
        $responseAction = $actionDone->actionDone($snake, $event_id,$request);

        if ($responseAction->getStatusCode() !== 200) {
            return $responseAction;
        }

        if ($score < 10) {
            $pet->mental -= $score;
            $pet->clean -= 10;
            $user->gold += $score;
            $user->save();
            $pet->save();

            $response = [
                    'Score' => $score,
                    'Argent_gagné' => $score,
                    'Argent_total' => $user->gold,
                    'Message' => 'pas fou la game',
                    'Changes' => [
                        'Mental_avant' => $before,
                        'Mental_après' => $pet->mental
                    ],
                    'Pet' => $pet,
                ];
            } else {
                $pet->mental += $score;
                $pet->clean -= 15;
                $user->gold += $score;
                $user->save();
                $pet->save();

                $response = [
                    'score' => $score,
                    'argent_gagné' => $score,
                    'Argent_total' => $user->gold,
                    'message' => 'respect',
                    'changes' => [
                        'Mental_avant' => $before,
                        'Mental_après' => $pet->mental

                    ],
                    'pet' => $pet
                ];
            }
            
            return response()->json(['actionDone' => $responseAction,'snake' => $response], 200);
    }

    public function run(Request $request)
    {
        $user = Auth::user();
        $pet = $user->pet;
        if (!$pet) {
            return response()->json(['message' => 'User does not have a pet'], 400);
        }

        $run = Action::where('name', 'run')->first();
        if (!$run) {
            return response()->json(['message' => 'not found'], 400);
        }

        $score = rand(0, 40);
        $before = $pet->mental;
        $event_id = null;

        $actionDone = new DiaryController();
        $responseAction = $actionDone->actionDone($run, $event_id,$request);

        if ($responseAction->getStatusCode() !== 200) {
            return $responseAction;
        }

        if ($score < 10) {
            $pet->mental -= $score;
            $pet->clean -= 10;
            $pet->save();
            
            $response = [
                    'Score' => $score,
                    'Message' => 'pas fou la game',
                    'Changes' => [
                        'Mental_avant' => $before,
                        'Mental_après' => $pet->mental
                    ],
                    'Pet' => $pet
                ];
            } else {
                $pet->mental += $score;
                $pet->clean -= 15;
                $pet->save();
                $response = [
                    'Score' => $score,
                    'Message' => 'gg',
                    'Changes' => [
                        'Mental_avant' => $before,
                        'Mental_après' => $pet->mental
                    ],
                    'Pet' => $pet
                ];
            } 
            return response()->json(['actionDone' => $responseAction,'run' => $response], 200);
    }
    public function maths(Request $request)
    {
        $user = Auth::user();
        $pet = $user->pet;

        if (!$pet) {
            return response()->json(['message' => 'User does not have a pet'], 400);
        }

        $maths = Action::where('name', 'math')->first();
        if (!$maths) {
            return response()->json(['message' => 'not found'], 400);
        }
        
        $score = rand(0, 10);
        $event_id = null;
        $before = $pet->mental;
        $before2 = $pet->iq;

        $actionDone = new DiaryController();
        $responseAction = $actionDone->actionDone($maths, $event_id,$request);

        if ($responseAction->getStatusCode() !== 200) {
            return $responseAction;
        }

        if ($score == 0 || $score == 1 || $score == 2) {
            $pet->mental -= 10;
            $pet->iq -= 15;
            $pet->save();
            $response = [
                    'Score' => $score,
                    'Message' => 'eh beh',
                    'Changes' => [
                        'Mental_avant' => $before,
                        'Mental_après' => $pet->mental,
                        'QI_avant' => $before2,
                        'QI_après' => $pet->iq,
                    ],
                    'pet' => $pet
                ];
            } elseif ($score == 3 || $score == 4 || $score == 5 || $score == 6 || $score == 7) {
            $pet->mental += $score;
            $pet->iq += $score * 2;
            $pet->save();
            $response = [
                    'score' => $score,
                    'message' => 'ok',
                    'changes' => [
                        'Mental_avant' => $before,
                        'Mental_après' => $pet->mental,
                        'QI_avant' => $before2,
                        'QI_après' => $pet->iq,
                    ],
                    'pet' => $pet
                ];
            } elseif ($score == 8 || $score == 9 || $score == 10) {
            $pet->mental += 15;
            $pet->iq += $score * 2;
            $pet->save();
            $response = [
                    'Score' => $score,
                    'Message' => 'gg',
                    'Changes' => [
                        'Mental_avant' => $before,
                        'Mental_après' => $pet->mental,
                        'QI_avant' => $before2,
                        'QI_après' => $pet->iq,
                    ],
                    'pet' => $pet
                ];
            } 
            
            return response()->json(['actionDone' => $responseAction,'maths' => $response], 200);
    }

}
