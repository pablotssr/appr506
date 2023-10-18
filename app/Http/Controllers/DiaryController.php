<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diary;
use Illuminate\Support\Facades\Auth;

class DiaryController extends Controller
{
    //
    public function actionDone($action){
        $user = Auth::user();
        $pet = $user->pet;
    
        $entriesCount = $pet->diary()->where('pet_age', $pet->age)->count();
        $actionPerformed = $pet->diary()->where('pet_age', $pet->age)->where('action_id', $action->id)->exists();

        if($entriesCount < 2 && !$actionPerformed){
            $dayData = [
                'user_id' => $user->id,
                'pet_id' => $pet->id,
                'pet_age' => $pet->age,
                'action_id' => $action->id,
            ];
            $day = Diary::create($dayData);
    
            return response()->json(['message' => 'Action successful.'], 200);
        } 
        elseif ($entriesCount == 2) {
            $pet->age += 1;
            $pet->save();
    
            $dayData = [
                'user_id' => $user->id,
                'pet_id' => $pet->id,
                'pet_age' => $pet->age,
                'action_id' => $action->id,
            ];
            $day = Diary::create($dayData);
    
            return response()->json(['message' => 'Action successful.'], 200);
        } 
        else {
            return response()->json(['message' => 'Action already performed at this age.'], 400);
        }}
}
