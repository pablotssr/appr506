<?php

namespace App\Http\Controllers;

use App\Models\Pet;
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

}