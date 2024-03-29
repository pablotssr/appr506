<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\Pet;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Http;


class AuthController extends Controller
{


    use HasApiTokens;

    public function createUser(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ]
            );
            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();

        $existingUser = User::where('email', $user->getEmail())->first();
        $newUser = null;
        if ($existingUser) {
            $token = $existingUser->createToken("API TOKEN")->plainTextToken;
            return redirect('http://localhost:4200?apiToken=' . $token . '&user=' . $existingUser);
        } else {
            $newUser = User::create([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'password' => Hash::make(Str::random(24)),
            ]);
            $token = $newUser->createToken("API TOKEN")->plainTextToken;
            return redirect('http://localhost:4200?apiToken=' . $token . '&user=' . $newUser);
        }
    }

    public function infos(Request $request)
    {
        $user = Auth::user();
        $currPet = $user->pet;
        $pets = $user->allPets;
        $exPets = $user->deadPets;
        $sdfEncounters = 0;
        $sdfWin = 0;
        $sdfLoss = 0;

        $cocoEncounters = 0;
        $sadEncounters = 0;

        $current = 'pas de pets en ce moment';

        foreach ($pets as $pet) {
            $sdfEncounters += $pet->diary->whereIn('event_id', [1, 2])->count();
            $sdfWin += $pet->diary->where('event_id', 2)->count();
            $sdfLoss += $pet->diary->where('event_id', 1)->count();


            $cocoEncounters += $pet->diary->where('event_id', 6)->count();
            $sadEncounters += $pet->diary->whereIn('event_id', [7, 8])->count();

        }
        if ($currPet) {
            $current = [
                'nom' => $currPet->name,
                'age' => $currPet->age,
                'couleur' => $currPet->color,
            ];
        } else {
            $current = ['pet' => 'ti en a pas le sang'];
        }
        $dead = $exPets->where('user_id', $user->id)->count();

        $oldest = $pets->where('user_id', $user->id)->sortBy('age')->last();


        $color = $exPets->pluck('color');

        return response()->json([
            'user' => $user->name,
            'id' => $user->id,
            'argent' => $user->gold,
            'pet_actuel' => $current,

            'nb_de_pet_morts' => $dead,
            'pet_le_plus_vieux' => [
                'nom' => $oldest->name,
                'age' => $oldest->age
            ],
            'couleurs' => $color,
            'vous_avez_rencontre' => "{$sdfEncounters}",
            'victoires' => "{$sdfWin}",
            'defaites' => "{$sdfLoss}",
            'vous_avez_eu_le_covid' => "{$cocoEncounters}",
            'vous_avez_fait' => "{$sadEncounters}"

        ], 200);
    }
}