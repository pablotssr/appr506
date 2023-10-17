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
            $pet->mental -= $score;
            $user->gold += $score;
            $user->save();
            $pet->save();
            return response()->json([
                'score'=> $score,
                'argent gagné' => $score,
                'Argent total' => $user->gold,
                'message' => 'pas fou la game',
                'changes' => [
                    'Mental avant' => $before,
                    'Mental après' => $pet->mental
                ],
                'pet' => $pet], 200);
        }
        if($score >= 10 && $score < 20){
            $pet->mental += $score;
            $user->gold += $score;
            $user->save();
            $pet->save();
            return response()->json([
                'score'=> $score,
                'argent gagné' => $score,
                'Argent total' => $user->gold,
                'message' => 'mouais',
                'changes' => [
                    'Mental avant' => $before,
                    'Mental après' => $pet->mental
                ],
                'pet' => $pet], 200);
        }
        if($score >= 20 && $score < 30){
            $pet->mental += $score;
            $user->gold += $score;
            $user->save();
            $pet->save();
            return response()->json([
                'score'=> $score,
                'argent gagné' => $score,
                'Argent total' => $user->gold,
                'message' => 'ok gg',
                'changes' => [
                    'Mental avant' => $before,
                    'Mental après' => $pet->mental
                ],
                'pet' => $pet], 200);
        }
        if($score >= 30 && $score <= 40){
            $pet->mental += $score;
            $user->gold += $score;
            $user->save();
            $pet->save();
            return response()->json([
                'score'=> $score,
                'argent gagné' => $score,
                'Argent total' => $user->gold,
                'message' => 'bravo champ',
                'changes' => [
                    'Mental avant' => $before,
                    'Mental après' => $pet->mental
                ],
                'pet' => $pet], 200);
        }
  }
  public function run(Request $request){
    $user = Auth::user();
    $pet = $user->pet;
    $score = rand(0,40);

    if (!$pet) {
        return response()->json(['message' => 'User does not have a pet'], 400);
    }

    $run = Action::where('name','run')->first();
    if(!$run){
        return response()->json(['message' => 'not found'], 400);
    }
    $before = $pet->mental;

    if($score < 10){
        $pet->mental -= $score;
        $pet->save();
        return response()->json([
            'score'=> $score,
            'message' => 'pas fou la game',
            'changes' => [
                'Mental avant' => $before,
                'Mental après' => $pet->mental
            ],
            'pet' => $pet], 200);
    }
    if($score >= 10 && $score < 30){
        $pet->mental += 20;
        $pet->save();
        return response()->json([
            'score'=> $score,
            'message' => 'ok gg',
            'changes' => [
                'Mental avant' => $before,
                'Mental après' => $pet->mental
            ],
            'pet' => $pet], 200);
    }
    if($score >= 30){
        $pet->mental += 30;
        $pet->save();
        return response()->json([
            'score'=> $score,
            'message' => 'bravo champ',
            'changes' => [
                'Mental avant' => $before,
                'Mental après' => $pet->mental
            ],
            'pet' => $pet], 200);
    }
}
public function maths(Request $request){
    $user = Auth::user();
    $pet = $user->pet;
    $score = rand(0,10);

    if (!$pet) {
        return response()->json(['message' => 'User does not have a pet'], 400);
    }

    $maths = Action::where('name','math')->first();
    if(!$maths){
        return response()->json(['message' => 'not found'], 400);
    }
    $before = $pet->mental;
    $before2 = $pet->iq;

    if($score == 0 || $score == 1 || $score == 2){
        $pet->mental -= 10;
        $pet->iq -= 15;
        $pet->save();
        return response()->json([
            'score'=> $score,
            'message' => 'eh beh',
            'changes' => [
                'Mental avant' => $before,
                'Mental après' => $pet->mental,
                'QI avant' => $before2,
                'QI après' => $pet->iq,
            ],
            'pet' => $pet], 200);
    }

    if($score == 3 || $score == 4 || $score == 5 || $score == 6 || $score == 7 ){
        $pet->mental += $score;
        $pet->iq += $score*2;
        $pet->save();
        return response()->json([
            'score'=> $score,
            'message' => 'ok c correct',
            'changes' => [
                'Mental avant' => $before,
                'Mental après' => $pet->mental,
                'QI avant' => $before2,
                'QI après' => $pet->iq,
            ],
            'pet' => $pet], 200);
    }

    if($score == 8 || $score == 9 || $score == 10){
        $pet->mental += 15;
        $pet->iq += $score*2;
        $pet->save();
        return response()->json([
            'score'=> $score,
            'message' => 'respect mon gars',
            'changes' => [
                'Mental avant' => $before,
                'Mental après' => $pet->mental,
                'QI avant' => $before2,
                'QI après' => $pet->iq,
            ],
            'pet' => $pet], 200);
    }

}
}
