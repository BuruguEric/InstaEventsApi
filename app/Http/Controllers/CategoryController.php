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

        return response()->json($cat);
    }

    
}
