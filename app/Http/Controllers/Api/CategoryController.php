<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Menu;

class CategoryController extends Controller
{
    // GET /api/categories
    public function index()
    {
        try {
            $categories = Category::all(['id', 'name']);
            return response()->json($categories, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch categories',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getByName($name)
{
    $category = Category::where('name', $name)->first();

    if (!$category) {
        return response()->json(['message' => 'Category not found'], 404);
    }

    return response()->json($category);
}

public function getByCategory($id)
    {
        // Fetch menus where category_id = $id
        $menus = Menu::where('category_id', $id)->get();

        return response()->json($menus);
    }
}
