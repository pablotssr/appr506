<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
class PetController extends Controller
{
    public function showOrCreate()
    {
        $user = Auth::user();
        $pet = $user->pet;

        if (!$pet) {
            return view('createPet');
        }

        return view('showPet', compact('pet'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
    
        $petData = [
            'name' => $request->input('name'),
            // Add other fields here
        ];
    
        $user->pet()->create($petData);
    
        return redirect('/pets');
    }
    
}
