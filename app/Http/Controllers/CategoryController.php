<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Categories;
use App\Http\Resources\category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allCategories()
    {
        $cat = Categories::all();

        return category::collection($cat);
    }

    public function createCategories(Request $request)
    {
        $cat = Categories::create($request->all());
        $cat->save();
        return response()->json($cat);
    }

    public function updateCategory($id, Request $request)
    {
        $cat = Categories::where();
        $cat->save();
        return response()->json($cat);
    }

    public function deleteCategory(Request $request)
    {
        $cat = Categories::create($request->all());
        $cat->save();
        return response()->json($cat);
    }
}
