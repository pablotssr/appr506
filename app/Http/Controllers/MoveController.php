<?php

namespace App\Http\Controllers;

use App\Models\Move;
use App\Models\Diary;
use App\Models\Action;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MoveController extends Controller
{
    //
    public function actionDone($actionId){
        $user = Auth::user();
        $pet = $user->pet;
        $diary = Diary::create(['pet_id' => $pet->id]);
        $moveData = [
            'user_id' => $user->id,
            'pet_id'=> $pet->id,
            'diary_id' => $diary->id
        ];
        
    }
}
