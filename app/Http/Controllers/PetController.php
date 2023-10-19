<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Event;
use App\Models\Action;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PetController extends Controller
{
    public function showOrCreate(Request $request)
    {
        $user = Auth::user();
        $pet = $user->pet;
        if (!$pet) {
            return response()->json(['message' => 'User does not have a pet'], 200);
        }
        return response()->json(['pet' => $pet]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->pet) {
            return response()->json(['message' => 'User already has a pet'], 400);
        }
        $petData = [
            'name' => $request->input('name'),
        ];
        $pet = $user->pet()->create($petData);
        return $pet;
    }

    public function kill(Request $request)
    {
        $user = Auth::user();
        $pet = $user->pet;

        if (!$pet) {
            return response()->json(['message' => 'User does not have a pet'], 400);
        }

        if ($request->input('confirmation') !== 'yes') {
            return response()->json(['message' => 'Confirmation not provided'], 400);
        }

        $pet->update(['health' => 0]);
        $pet->delete();

        return response()->json(['message' => 'Pet killed successfully'], 200);
    }

    public function createDiary(Request $request){
                $user = Auth::user();
                $pet = $user->pet;
            
                $entries = $pet->diary()
                    ->select('pet_age', 'action_id','event_id')
                    ->distinct()
                    ->get();
            
                $result = [];
            
                foreach ($entries as $entry) {
                    $age = $entry->pet_age;
                    $actionId = $entry->action_id;
                    $eventId = $entry->event_id;
            
                    if (!isset($result["jour {$age}"])) {
                        $result["jour {$age}"] = [];
                    }
            
                    $action = Action::find($actionId); 
                    $result["jour {$age}"][] = $action->name; 

                    if ($eventId) {
                        $event = Event::find($eventId); 
                        $result["jour {$age}"][] = "Event: {$event->name}"; 
                    }
                }
            
                return response()->json($result, 200);
            }
    
}