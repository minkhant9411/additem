<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;

class IndexController extends Controller
{
    public function getItem()
    {
        $items = Item::where('cat_id', request()->cat_id)->get();
        return response()->json([
            'items' => $items,
        ]);
    }
    public function index()
    {
        $categories = Category::orderBy('created_at', 'desc')->get();
        // $items = Item::where('cat_id', request()->cat_id)->get();
        $items = Item::orderBy('created_at', 'desc')->get();
        return view('welcome', [
            'categories' => $categories,
            'items' => $items,
        ]);
    }
}