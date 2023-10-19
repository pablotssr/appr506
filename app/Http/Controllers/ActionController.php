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
        $event_id = null;
        $before = $pet->clean;

        if ($pet->clean == 100) {
            return response()->json(['message' => 'il est déjà hyper clean pas besoin', 'pet' => $pet], 200);
        }

        $pet->clean += $laver->effect;
        $pet->save();

        
        if (rand(1, 10) <= 3) {
            $eventController = new EventController();
            $eventResult = $eventController->triggerEvent($request);
            $eventContent = json_decode($eventResult->getContent(), true);
            $responseb = [
                'event' => $eventContent,
                'message' => 'ptite douche c tt clean la',
                'changes' => [
                    'Propreté avant' => $before,
                    'Propreté après' => $pet->clean
                ],
                'pet' => $pet,
            ];
            $event_id = $eventContent['id'];
        } else {
            $responseb = [
                'message' => 'ptite douche c tt clean la',
                'changes' => [
                    'Propreté_avant' => $before,
                    'Propreté_après' => $pet->clean
                ],
                'pet' => $pet
            ];
        }

        $actionDone = new DiaryController();
        $response = $actionDone->actionDone($laver,$event_id);

        if ($response->getStatusCode() !== 200) {
            return $response;
        }

        return response()->json($responseb, 200);

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

        if ($pet->mental == 100) {
            return response()->json(['message' => 'il est déjà o max pas besoin', 'pet' => $pet], 200);
        }
        $event_id = null;
        $pet->mental += $caresse->effect;
        $pet->save();
        if (rand(1, 10) <= 3) {
            $eventController = new EventController();
            $eventResult = $eventController->triggerEvent($request);
            $eventContent = json_decode($eventResult->getContent(), true);
            $responseb = [
                'event' => $eventContent,
                'message' => 'ptite tape sur le front la',
                'changes' => [
                    'Mental_avant' => $before,
                    'Mental_après' => $pet->mental
                ],
                'pet' => $pet,
            ];
            $event_id = $eventContent['id'];
        } else {
            $responseb = [
                'message' => 'ptite tape sur le front la',
                'changes' => [
                    'Mental_avant' => $before,
                    'Mental_après' => $pet->mental
                ],
                'pet' => $pet
            ];
        }
        $actionDone = new DiaryController();
        $response = $actionDone->actionDone($caresse, $event_id);

        if ($response->getStatusCode() !== 200) {
            return $response;
        }

        return response()->json($responseb, 200);

    }

    public function giveItem(Request $request)
    {
        $user = Auth::user();
        $pet = $user->pet;

        if (!$pet) {
            return response()->json(['message' => 'User does not have a pet'], 400);
        }
        $event_id = null;
        $give = Action::where('name', 'give object')->first();
        $actionDone = new DiaryController();
        $response = $actionDone->actionDone($give, $event_id);


        if ($response->getStatusCode() !== 200) {
            return $response;
        }
        if (!$give) {
            return response()->json(['message' => 'not found'], 400);
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
            if (rand(1, 10) <= 3) {
                $eventController = new EventController();
                $eventResult = $eventController->triggerEvent($request);
                $eventContent = json_decode($eventResult->getContent(), true);
                $responseb = [
                    'event' => $eventContent,
                    'tu a donné' => "{$b->name} à {$pet->name}",
                    'changes' => [
                        'Mental_avant' => $before,
                        'Mental_après' => $pet->mental
                    ],
                    'pet' => $pet,
                ];
                $event_id = $eventContent['id'];
            } else {
                $responseb = [
                    'tu a donné' => "{$b->name} à {$pet->name}",
                    'changes' => [
                        'Mental_avant' => $before,
                        'Mental_après' => $pet->mental
                    ],
                    'pet' => $pet
                ];
            }
            return response()->json($responseb, 200);

        }

        if ($item->item_id == 2) {
            $before = $pet->mental;

            $pet->mental -= $b->effect;
            $pet->save();
            $item->delete();
            if (rand(1, 10) <= 3) {
                $eventController = new EventController();
                $eventResult = $eventController->triggerEvent($request);
                $eventContent = json_decode($eventResult->getContent(), true);
                $responseb = [
                    'event' => $eventContent,
                    'tu a donné' => "{$b->name} à {$pet->name}",
                    'changes' => [
                        'Mental_avant' => $before,
                        'Mental_après' => $pet->mental
                    ],
                    'pet' => $pet,
                ];
                $event_id = $eventContent['id'];
            } else {
                $responseb = [
                    'tu a donné' => "{$b->name} à {$pet->name}",
                    'changes' => [
                        'Mental_avant' => $before,
                        'Mental_après' => $pet->mental
                    ],
                    'pet' => $pet
                ];
            }
            return response()->json($responseb, 200);
        }

        if ($item->item_id == 3) {
            $before = $pet->mental;
            $before2 = $pet->health;

            if ($pet->mental == 100 || $pet->health == 100) {
                return response()->json(['message' => 'il est déjà o max pas besoin', 'pet' => $pet], 200);
            }
            $pet->mental += $b->effect;
            $pet->health += ($b->effect) / 3;
            $pet->save();
            $item->delete();
            if (rand(1, 10) <= 3) {
                $eventController = new EventController();
                $eventResult = $eventController->triggerEvent($request);
                $eventContent = json_decode($eventResult->getContent(), true);
                $responseb = [
                    'event' => $eventContent,
                    'tu a donné' => "{$b->name} à {$pet->name}",
                    'changes' => [
                        'Mental_avant' => $before,
                        'Mental_après' => $pet->mental,
                        'Santé_avant' => $before2,
                        'Santé_après' => $pet->health
                    ],
                    'pet' => $pet,
                ];
                $event_id = $eventContent['id'];
            } else {
                $responseb = [
                    'tu a donné' => "{$b->name} à {$pet->name}",
                    'changes' => [
                        'Mental_avant' => $before,
                        'Mental_après' => $pet->mental,
                        'Santé_avant' => $before2,
                        'Santé_après' => $pet->health
                    ],
                    'pet' => $pet
                ];
            }
            return response()->json($responseb, 200);
        }

        if ($item->item_id == 4) {
            $before = $pet->mental;
            $before2 = $pet->health;


            $pet->mental -= $b->effect;
            $pet->health -= ($b->effect) / 2;
            $pet->save();
            $item->delete();
            if (rand(1, 10) <= 3) {
                $eventController = new EventController();
                $eventResult = $eventController->triggerEvent($request);
                $eventContent = json_decode($eventResult->getContent(), true);
                $responseb = [
                    'event' => $eventContent,
                    'tu a donné' => "{$b->name} à {$pet->name}",
                    'changes' => [
                        'Mental_avant' => $before,
                        'Mental_après' => $pet->mental,
                        'Santé_avant' => $before2,
                        'Santé_après' => $pet->health
                    ],
                    'pet' => $pet,
                ];
                $event_id = $eventContent['id'];
            } else {
                $responseb = [
                    'tu a donné' => "{$b->name} à {$pet->name}",
                    'changes' => [
                        'Mental_avant' => $before,
                        'Mental_après' => $pet->mental,
                        'Santé_avant' => $before2,
                        'Santé_après' => $pet->health
                    ],
                    'pet' => $pet
                ];
            }
            return response()->json($responseb, 200);
        }

        if ($item->item_id == 5) {
            $before = $pet->mental;
            $before2 = $pet->health;

            if ($pet->health == 100) {
                return response()->json(['message' => 'il est déjà o max pas besoin', 'pet' => $pet], 200);
            }
            $pet->mental += ($b->effect) / 2;
            $pet->health += $b->effect;
            $pet->save();
            $item->delete();
            if (rand(1, 10) <= 3) {
                $eventController = new EventController();
                $eventResult = $eventController->triggerEvent($request);
                $eventContent = json_decode($eventResult->getContent(), true);
                $responseb = [
                    'event' => $eventContent,
                    'tu a donné' => "{$b->name} à {$pet->name}",
                    'changes' => [
                        'Mental_avant' => $before,
                        'Mental_après' => $pet->mental,
                        'Santé_avant' => $before2,
                        'Santé_après' => $pet->health
                    ],
                    'pet' => $pet,
                ];
                $event_id = $eventContent['id'];
            } else {
                $responseb = [
                    'tu a donné' => "{$b->name} à {$pet->name}",
                    'changes' => [
                        'Mental_avant' => $before,
                        'Mental_après' => $pet->mental,
                        'Santé_avant' => $before2,
                        'Santé_après' => $pet->health
                    ],
                    'pet' => $pet
                ];
            }
            return response()->json($responseb, 200);
        }

        if ($item->item_id == 6) {
            $before = $pet->mental;
            $before2 = $pet->health;

            if ($pet->health == 100) {
                return response()->json(['message' => 'il est déjà o max pas besoin', 'pet' => $pet], 200);
            }
            $pet->mental += ($b->effect) / 2;
            $pet->health += $b->effect;
            $pet->save();
            $item->delete();
            if (rand(1, 10) <= 3) {
                $eventController = new EventController();
                $eventResult = $eventController->triggerEvent($request);
                $eventContent = json_decode($eventResult->getContent(), true);
                $responseb = [
                    'event' => $eventContent,
                    'tu a donné' => "{$b->name} à {$pet->name}",
                    'changes' => [
                        'Mental_avant' => $before,
                        'Mental_après' => $pet->mental,
                        'Santé_avant' => $before2,
                        'Santé_après' => $pet->health
                    ],
                    'pet' => $pet,
                ];
                $event_id = $eventContent['id'];
            } else {
                $responseb = [
                    'tu a donné' => "{$b->name} à {$pet->name}",
                    'changes' => [
                        'Mental_avant' => $before,
                        'Mental_après' => $pet->mental,
                        'Santé_avant' => $before2,
                        'Santé_après' => $pet->health
                    ],
                    'pet' => $pet
                ];
            }
            return response()->json($responseb, 200);
        }
    }
    public function snake(Request $request)
    {
        $user = Auth::user();
        $pet = $user->pet;
        $score = rand(0, 40);

        if (!$pet) {
            return response()->json(['message' => 'User does not have a pet'], 400);
        }

        $snake = Action::where('name', 'snake')->first();
        if (!$snake) {
            return response()->json(['message' => 'not found'], 400);
        }
        $event_id = null;
        $before = $pet->mental;
        $actionDone = new DiaryController();
        $response = $actionDone->actionDone($snake,$event_id);

        if ($response->getStatusCode() !== 200) {
            return $response;
        }
        if ($score < 10) {
            $pet->mental -= $score;
            $pet->clean -= 10;
            $user->gold += $score;
            $user->save();
            $pet->save();
            if (rand(1, 10) <= 3) {
                $eventController = new EventController();
                $eventResult = $eventController->triggerEvent($request);
                $eventContent = json_decode($eventResult->getContent(), true);
                $responseb = [
                    'event' => $eventContent,
                    'score' => $score,
                    'argent_gagné' => $score,
                    'Argent_total' => $user->gold,
                    'message' => 'pas fou la game',
                    'changes' => [
                        'Mental_avant' => $before,
                        'Mental_après' => $pet->mental
                    ],
                    'pet' => $pet,
                ];
                $event_id = $eventContent['id'];
            } else {
                $responseb = [
                    'score' => $score,
                    'argent_gagné' => $score,
                    'Argent_total' => $user->gold,
                    'message' => 'pas fou la game',
                    'changes' => [
                        'Mental_avant' => $before,
                        'Mental_après' => $pet->mental

                    ],
                    'pet' => $pet
                ];
            }
            return response()->json($responseb, 200);
        }
        if ($score >= 10) {
            $pet->mental += $score;
            $pet->clean -= 10;
            $user->gold += $score;
            $user->save();
            $pet->save();
            if (rand(1, 10) <= 3) {
                $eventController = new EventController();
                $eventResult = $eventController->triggerEvent($request);
                $eventContent = json_decode($eventResult->getContent(), true);
                $responseb = [
                    'event' => $eventContent,
                    'score' => $score,
                    'argent_gagné' => $score,
                    'Argent_total' => $user->gold,
                    'message' => 'gg champ',
                    'changes' => [
                        'Mental_avant' => $before,
                        'Mental_après' => $pet->mental
                    ],
                    'pet' => $pet,
                ];
                $event_id = $eventContent['id'];
            } else {
                $responseb = [
                    'score' => $score,
                    'argent gagné' => $score,
                    'Argent total' => $user->gold,
                    'message' => 'gg champ',
                    'changes' => [
                        'Mental_avant' => $before,
                        'Mental_après' => $pet->mental

                    ],
                    'pet' => $pet
                ];
            }
            return response()->json($responseb, 200);
        }
    }
    public function run(Request $request)
    {
        $user = Auth::user();
        $pet = $user->pet;
        $score = rand(0, 40);

        if (!$pet) {
            return response()->json(['message' => 'User does not have a pet'], 400);
        }

        $run = Action::where('name', 'run')->first();
        if (!$run) {
            return response()->json(['message' => 'not found'], 400);
        }
        $before = $pet->mental;
        $event_id = null;
        $actionDone = new DiaryController();
        $response = $actionDone->actionDone($run,$event_id);

        
        if ($score < 10) {
            $pet->mental -= $score;
            $pet->clean -= 10;
            $pet->save();
            if (rand(1, 10) <= 3) {
                $eventController = new EventController();
                $eventResult = $eventController->triggerEvent($request);
                $eventContent = json_decode($eventResult->getContent(), true);
                $responseb = [
                    'event' => $eventContent,
                    'score' => $score,
                'message' => 'pas fou la game',
                'changes' => [
                    'Mental_avant' => $before,
                    'Mental_après' => $pet->mental
                ],
                'pet' => $pet
                ];
                $event_id = $eventContent['id'];
            } else {
                $responseb = [
                    'score' => $score,
                'message' => 'pas fou la game',
                'changes' => [
                    'Mental_avant' => $before,
                    'Mental_après' => $pet->mental
                ],
                'pet' => $pet
                ];
            }
            return response()->json($responseb, 200);
        }
        if ($score >= 15) {
            $pet->mental += $score;
            $pet->clean -= 15;
            $pet->save();
            
            if (rand(1, 10) <= 3) {
                $eventController = new EventController();
                $eventResult = $eventController->triggerEvent($request);
                $eventContent = json_decode($eventResult->getContent(), true);
                $responseb = [
                    'event' => $eventContent,
                    'score' => $score,
                'message' => 'gg',
                'changes' => [
                    'Mental_avant' => $before,
                    'Mental_après' => $pet->mental
                ],
                'pet' => $pet
                ];
                $event_id = $eventContent['id'];
            } else {
                $responseb = [
                    'score' => $score,
                'message' => 'g',
                'changes' => [
                    'Mental_avant' => $before,
                    'Mental_après' => $pet->mental
                ],
                'pet' => $pet
                ];
            }
            return response()->json($responseb, 200);
        }
        if ($response->getStatusCode() !== 200) {
            return $response;
        }
    }
    public function maths(Request $request)
    {
        $user = Auth::user();
        $pet = $user->pet;
        $score = rand(0, 10);

        if (!$pet) {
            return response()->json(['message' => 'User does not have a pet'], 400);
        }

        $maths = Action::where('name', 'math')->first();
        if (!$maths) {
            return response()->json(['message' => 'not found'], 400);
        }
        $event_id = null;
        $before = $pet->mental;
        $before2 = $pet->iq;
        $actionDone = new DiaryController();
        $response = $actionDone->actionDone($maths,$event_id);

        if ($response->getStatusCode() !== 200) {
            return $response;
        }

        if ($score == 0 || $score == 1 || $score == 2) {
            $pet->mental -= 10;
            $pet->iq -= 15;
            $pet->save();
            if (rand(1, 10) <= 3) {
                $eventController = new EventController();
                $eventResult = $eventController->triggerEvent($request);
                $eventContent = json_decode($eventResult->getContent(), true);
                $responseb = [
                    'event' => $eventContent,
                    'score' => $score,
                'message' => 'eh beh',
                'changes' => [
                    'Mental_avant' => $before,
                    'Mental_après' => $pet->mental,
                    'QI_avant' => $before2,
                    'QI_après' => $pet->iq,
                ],
                'pet' => $pet
                ];
                $event_id = $eventContent['id'];
            } else {
                $responseb = [
                    'score' => $score,
                'message' => 'eh beh',
                'changes' => [
                    'Mental_avant' => $before,
                    'Mental_après' => $pet->mental,
                    'QI_avant' => $before2,
                    'QI_après' => $pet->iq,
                ],
                'pet' => $pet
                ];
            }
            return response()->json($responseb, 200);
        }

        if ($score == 3 || $score == 4 || $score == 5 || $score == 6 || $score == 7) {
            $pet->mental += $score;
            $pet->iq += $score * 2;
            $pet->save();
            if (rand(1, 10) <= 3) {
                $eventController = new EventController();
                $eventResult = $eventController->triggerEvent($request);
                $eventContent = json_decode($eventResult->getContent(), true);
                $responseb = [
                    'event' => $eventContent,
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
                $event_id = $eventContent['id'];
            } else {
                $responseb = [
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
            }
            return response()->json($responseb, 200);
        }

        if ($score == 8 || $score == 9 || $score == 10) {
            $pet->mental += 15;
            $pet->iq += $score * 2;
            $pet->save();
            if (rand(1, 10) <= 3) {
                $eventController = new EventController();
                $eventResult = $eventController->triggerEvent($request);
                $eventContent = json_decode($eventResult->getContent(), true);
                $responseb = [
                    'event' => $eventContent,
                    'score' => $score,
                'message' => 'gg',
                'changes' => [
                    'Mental_avant' => $before,
                    'Mental_après' => $pet->mental,
                    'QI_avant' => $before2,
                    'QI_après' => $pet->iq,
                ],
                'pet' => $pet
                ];
                $event_id = $eventContent['id'];
            } else {
                $responseb = [
                    'score' => $score,
                'message' => 'gg',
                'changes' => [
                    'Mental_avant' => $before,
                    'Mental_après' => $pet->mental,
                    'QI_avant' => $before2,
                    'QI_après' => $pet->iq,
                ],
                'pet' => $pet
                ];
            }
            return response()->json($responseb, 200);
        }

    }
}