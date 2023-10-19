<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diary;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Auth;

class DiaryController extends Controller
{
    //
    public function actionDone($action, $event_id = null, $request)
    {
        $user = Auth::user();
        $pet = $user->pet;

        $entriesCount = $pet->diary()->where('pet_age', $pet->age)->count();
        $actionPerformed = $pet->diary()->where('pet_age', $pet->age)->where('action_id', $action->id)->exists();

        if ($entriesCount < 2 && !$actionPerformed) {

            $dayData = [
                'user_id' => $user->id,
                'pet_id' => $pet->id,
                'pet_age' => $pet->age,
                'action_id' => $action->id,
                'event_id' => $event_id,
            ];

            $eventInfo = null;

            if (rand(1, 10) <= 9) {
                $eventController = new EventController();
                $eventResult = $eventController->triggerEvent($request);
                $eventContent = json_decode($eventResult->getContent(), true);
                $dayData['event_id'] = $eventContent['id'];
                $eventInfo = $eventContent; 
            }

            $day = Diary::create($dayData);
            return response()->json(['message' => 'Action successful.', 'event' => $eventInfo], 200);

        } elseif ($entriesCount == 2 && !$actionPerformed) {
            $pet->age += 1;
            $pet->save();

            $dayData = [
                'user_id' => $user->id,
                'pet_id' => $pet->id,
                'pet_age' => $pet->age,
                'action_id' => $action->id,
                'event_id' => $event_id,
            ];

            $eventInfo = null;

            if (rand(1, 10) <= 3) {
                $eventController = new EventController();
                $eventResult = $eventController->triggerEvent($request);
                $eventContent = json_decode($eventResult->getContent(), true);
                $dayData['event_id'] = $eventContent['id'];
                $eventInfo = $eventContent;   
            } 

            $day = Diary::create($dayData);
            return response()->json(['message' => 'Action successful.', 'event' => $eventInfo], 200);
        }
        else {
            return response()->json(['message' => 'Action already performed at this age.'], 400);
        }

    }
}