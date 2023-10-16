<?php

namespace App\Http\Controllers;

use App\Models\Move;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MoveController extends Controller
{
    //
    public function firstAction(Request $request){
        $user = Auth::user();
        $pet = $user->pet;
        
    }
}
