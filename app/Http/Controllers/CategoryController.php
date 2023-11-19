<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryFilterRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * @param CategoryFilterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategories(CategoryFilterRequest $request)
    {
        $categories = Category::query();
        $req = $request->validated();

        if (isset($req['name'])) {
            $categories->where('name', 'like', '%' . $req['name'] . '%');
        }

        $categories = $categories->paginate(20);

        return response()->json([
            'categories' => $categories,
        ]);
    }
}
