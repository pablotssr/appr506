<?php

namespace App\Http\Controllers;

use App\Models\Action;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ActionController extends Controller
{
    //
     public function laver(Request $request){
        $user = Auth::user();
        $pet = $user->pet;

        if (!$pet) {
            return response()->json(['message' => 'User does not have a pet'], 400);
        }

        $laver = Action::where('name','clean')->first();
        if(!$laver){
            return response()->json(['message' => 'not found'], 400);
        }

        $before = $pet->clean;

        if ($pet->clean == 100) {
            return response()->json(['message' => 'il est déjà hyper clean pas besoin','pet' => $pet], 200);
        }

        $pet->clean += $laver->effect;
        $pet->save();

        return response()->json([
            'message' => 'ptite douche c tt clean la',
            'changes' => [
                'Propreté avant' => $before,
                'Propreté après' => $pet->clean
            ],
            'pet' => $pet], 200);
     }
     
     public function caresse(Request $request){
        $user = Auth::user();
        $pet = $user->pet;

        if (!$pet) {
            return response()->json(['message' => 'User does not have a pet'], 400);
        }

        $caresse = Action::where('name','caresser')->first();
        if(!$caresse){
            return response()->json(['message' => 'not found'], 400);
        }

        $before = $pet->mental;

        if ($pet->mental == 100) {
            return response()->json(['message' => 'il est déjà o max pas besoin','pet' => $pet], 200);
        }

        $pet->mental += $caresse->effect;
        $pet->save();

        return response()->json([
            'message' => 'ptite tape sur le front la',
            'changes' => [
                'Mental avant' => $before,
                'Mental après' => $pet->mental
            ],
            'pet' => $pet], 200);

     }

    // public function giveItem(Request $request){
        
    // }
 public function snake(Request $request){
        $user = Auth::user();
        $pet = $user->pet;
        $score = rand(0,40);

        if (!$pet) {
            return response()->json(['message' => 'User does not have a pet'], 400);
        }

        $snake = Action::where('name','snake')->first();
        if(!$snake){
            return response()->json(['message' => 'not found'], 400);
        }
        $before = $pet->mental;

        if($score < 10){
            $pet->mental += $score;
            $pet->save();
            return response()->json([
                'message' => 'pas fou la game',
                'changes' => [
                    'Mental avant' => $before,
                    'Mental après' => $pet->mental
                ],
                'pet' => $pet], 200);
        }
        if($score >= 10 && $score < 20){
            $pet->mental += $score;
            $pet->save();
            return response()->json([
                'message' => 'mouais',
                'changes' => [
                    'Mental avant' => $before,
                    'Mental après' => $pet->mental
                ],
                'pet' => $pet], 200);
        }
        if($score >= 20 && $score < 30){
            $pet->mental += $score;
            $pet->save();
            return response()->json([
                'message' => 'ok gg',
                'changes' => [
                    'Mental avant' => $before,
                    'Mental après' => $pet->mental
                ],
                'pet' => $pet], 200);
        }
        if($score >= 30 && $score <= 40){
            $pet->mental += $score;
            $pet->save();
            return response()->json([
                'message' => 'bravo champ',
                'changes' => [
                    'Mental avant' => $before,
                    'Mental après' => $pet->mental
                ],
                'pet' => $pet], 200);
        }
  }
    // public function run(Request $request){
        
    // }
    // public function math(Request $request){
        
    // }
}
