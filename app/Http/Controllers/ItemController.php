<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Shop;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;


class ItemController extends Controller
{
    
    public function createShop(Request $request){
        Shop::truncate();

        if(rand(0,1) == 0){
            $item1 = Item::where('id', '1')->first();
        } else {
            $item1 = Item::where('id', '2')->first();
        }
        if(rand(0,1) == 0){
            $item2 = Item::where('id', '3')->first();
        } else {
            $item2 = Item::where('id', '4')->first();
        }
        if(rand(0,1) == 0){
            $item3 = Item::where('id', '5')->first();
        } else {
            $item3 = Item::where('id', '6')->first();
        }
        $shopData = [
            'item1' => $item1->id,
            'item2' => $item2->id,
            'item3' => $item3->id,
        ];

        $shop = Shop::create($shopData);
        return response()->json([
            'Item 1' => $item1->name,
            'prix item 1' => $item1->price,
            'Item 2' => $item2->name,
            'prix item 2' => $item2->price,
            'Item 3' => $item3->name,
            'prix item 3' => $item3->price,
        ], 200);
    }

    public function achat(Request $request){
        $user = Auth::user();
        $buy = $request->input('item'); 

        $column = "item{$buy}";

        $item = Shop::where($column, '<>', null)->pluck($column)->first();
        $a = Shop::where($column, '<>', null)->first();

        if (!$item ) {
        return response()->json(['message' => 'Item not found or not available'], 404);
        }

        $specItem = Item::where('id',$item)->first();
        
        if (!$specItem) {
            return response()->json(['message' => 'Item not found in the items table'], 404);
        }

        if ($user->gold < $specItem->price) {
            return response()->json(['message' => 'Insufficient funds'], 400);
        }

        $user->gold-=$specItem->price;
        $user->save();
        $inventoryData = [
            'user_id' => $user->id,
            'item_id' => $specItem->id,
        ];

        $inventory = Inventory::create($inventoryData);
        $a->$column = null;
        $a->save();
        
        $userInventory = Inventory::where('user_id', $user->id)->get();
        return response()->json([
            'message' => 'achat réussi',
            'item bought' => "item {$buy}",
            'gold_balance' => $user->gold,
        ], 200);
    }

    public function viewShop() {
        $shop = Shop::latest()->first();
    
        if (!$shop) {
            return response()->json(['message' => 'No shop found'], 404);
        }
    
        $item1 = $shop->item1 ? Item::find($shop->item1) : null;
        $item2 = $shop->item2 ? Item::find($shop->item2) : null;
        $item3 = $shop->item3 ? Item::find($shop->item3) : null;
    
        $response = [];
    
        if ($item1) {
            $response += [
                'Item1' => $item1->name,
                'Price1' => $item1->price,
            ];
        } else {
            $response += [
                'Item1' => '',
                'Price1' => 'X',
            ];
        }
    
        if ($item2) {
            $response += [
                'Item2' => $item2->name,
                'Price2' => $item2->price,
            ];
        } else {
            $response += [
                'Item2' => '',
                'Price2' => 'X',
            ];
        }
    
        if ($item3) {
            $response += [
                'Item3' => $item3->name,
                'Price3' => $item3->price,
            ];
        }else {
            $response += [
                'Item3' => '',
                'Price3' => 'X',
            ];
        }
    
        return response()->json($response, 200);
    }

    public function viewInventory(){
     
        $user = Auth::user();
        $inventory = Inventory::where('user_id', $user->id)->get();
        
        $transformedInventory = $inventory->map(function($item) {
            $itemName = Item::find($item->item_id)->name;
            return [
                'id' => $item->id,
                'user_id' => $item->user_id,
                'item_id' => $item->item_id,
                'item_name' => $itemName, 
            ];
        });
        
        return response()->json(['inventaire' => $transformedInventory], 200);
    }
}
