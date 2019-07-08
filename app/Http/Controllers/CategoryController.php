<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Categories;
use App\Http\Resources\category;

class CategoryController extends Controller
{
    public function __construct() {
        \Cloudinary::config(array(
            "cloud_name" => env("CLOUDINARY_NAME"),
            "api_key" => env("CLOUDINARY_API_KEY"),
            "api_secret" => env("CLOUDINARY_API_SECRET")
        ));
    }
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

    public function showCategory($category)
    {
        $cat = Categories::find($category);
        return response()->json($cat);
    }

    public function createCategories(Request $request)
    {
        $cat = Categories::create($request->all());
        $cat->category_poster = \Cloudinary\Uploader::upload($request->category_poster->getRealPath())['secure_url'];
        $cat->save();
        return response()->json($cat);
    }

    public function updateCategory($category, Request $request)
    {
        $cat = Categories::find($category)->update(($request->all()));
        // $cat->save();
        return response()->json($cat);
    }

    public function deleteCategory($id)
    {
        $cat = Categories::where('category_id',$id)->get();
        $cat->each->delete();
        return response()->json('Category deleted successfully!');
    }
}
