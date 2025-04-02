<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getAllCategoryName()
    {
        $categories  = Category::select('id', 'name')->where('status', 'Active')->orderBy('created_at', 'desc')->get();

        return response()->json([
            'code' => 200,
            'data' => $categories
        ]);
    }

    public function getAllCategory(Request $request)
    {
        $categories = Category::where('status', 'Active')->paginate(12);
        return response()->json([
            'code' => 200,
            'data' => $categories
        ]);
    }

    public function getProductByCategoryId($categoryId)
    {
        $products = Category::find($categoryId)->products()->where('status', 'Active')->paginate(12);
        return response()->json([
            'code' => 200,
            'data' => $products
        ]);
    }
}
