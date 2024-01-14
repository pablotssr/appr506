<?php

namespace App\Http\Controllers;
use App\Events\TestEvent;

use Illuminate\Http\Request;
use App\Models\Diary;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PetController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DiaryController extends Controller
{
    public function actionDone($action, $event_id = null, $score, $request)
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
                'action_score' => $score,
            ];

            $eventInfo = null;
            $eventName = null; 

            if (rand(1, 10) <= 3) {
                $eventController = new EventController();
                $eventResult = $eventController->triggerEvent($request);
                $eventContent = json_decode($eventResult->getContent(), true);
                if (isset($eventContent["id"])) {
                    $dayData['event_id'] = $eventContent["id"];
                    $eventInfo = $eventContent; 
                    $eventName = $eventContent['event_name'];
                    TestEvent::dispatch($eventName,$user->id);
                } else {
                    Log::error('prout pipicul');
                }
            }

            $day = Diary::create($dayData);
            return response()->json(['message' => 'Action successful.', 'event' => $eventInfo,'caca' => $dayData], 200);

        } elseif ($entriesCount == 2) {
            $pet->age += 1;
            $pet->save();
            $shopController = new ItemController();
            $newShop = $shopController->createShop($request);

            $dayData = [
                'user_id' => $user->id,
                'pet_id' => $pet->id,
                'pet_age' => $pet->age,
                'action_id' => $action->id,
                'event_id' => $event_id,
                'action_score' => $score,
            ];

            $eventInfo = null;
            $eventName = null; 

            if (rand(1, 10) <= 3) {
                $eventController = new EventController();
                $eventResult = $eventController->triggerEvent($request);
                $eventContent = json_decode($eventResult->getContent(), true);
                if (isset($eventContent["id"])) {
                    $dayData['event_id'] = $eventContent["id"];
                    $eventInfo = $eventContent; 
                    $eventName = $eventContent['event_name'];
                    TestEvent::dispatch($eventName,$user->id);
                } else {
                    Log::error('prout caca');
                }
            } 

            $day = Diary::create($dayData);
            $petController = new PetController();
            $newDiary = $petController->createDiary($request);
            return response()->json(['message' => 'Action successful.', 'event' => $eventInfo,'caca' => $dayData], 200);
        }
        else {
            return response()->json(['message' => 'Action already performed at this age.'], 400);
        }

    }

    public function dailyAction()
{
    $user = Auth::user();
    $pet = $user->pet;

    $actionsPerformed = $pet->diary()
        ->where('pet_age', $pet->age)
        ->pluck('action_id')
        ->toArray();

    return response()->json(['actionsPerformed' => $actionsPerformed], 200);
}
}