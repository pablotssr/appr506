<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    //
    public function createShop(Request $request){
        
        if(rand(0,1) == 0){
            $item1 = Item::where('name', 'Jouet Bien')->first();
        } else {
            $item1 = Item::where('name', 'Jouet Nul')->first();
        }
        if(rand(0,1) == 0){
            $item2 = Item::where('name', 'Nourriture Bonne')->first();
        } else {
            $item2 = Item::where('name', 'Nourriture Mauvaise')->first();
        }
        if(rand(0,1) == 0){
            $item3 = Item::where('name', 'Petit soin')->first();
        } else {
            $item3 = Item::where('name', 'Gros soin')->first();
        }
        return response()->json([
            'Item 1' => 'Jouet',
            'Secret type 1' => $item1->name,
            'prix item 1' => $item1->price,
            'Item 2' => 'Nourriture',
            'Secret type 2' => $item2->name,
            'prix item 2' => $item2->price,
            'Item 3' => 'Soin',
            'Secret type 3' => $item3->name,
            'prix item 3' => $item3->price,
        ], 200);
    }

}
