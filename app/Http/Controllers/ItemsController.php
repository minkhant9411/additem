<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;

class ItemsController extends Controller
{

    public function add()
    {
        $item_name = request()->item_name;
        $cat_id = request()->cat_id;
        $item = new Item;
        $item->name = $item_name;
        $item->cat_id = $cat_id;
        $item->save();
        $cat = Category::find($cat_id);
        // $cat_name = $cat->name;
        return response()->json([
            'item_name' => $item_name,
            'cat_id' => $cat_id,
            'cat_name' => $cat->name,
            'code' => 1,
        ]);
    }
}
