<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function add()
    {
        $cat_name = request()->category_name;
        $category = new Category;
        $category->name = $cat_name;
        $category->save();
        return response()->json([
            'cat_name' => $cat_name,
            'code' => 1,
            'cat_id' => $category->id,
        ]);
    }
}
