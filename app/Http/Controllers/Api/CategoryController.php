<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories= Category::latest()->paginate(10);
        return CategoryResource::collection($categories);

    }

    /**
     * Display a search listing.
     *
     * @return \Illuminate\Http\Response
     */
    public function search($field, $query)
    {
        $categories= Category::where($field, 'LIKE', "%$query%")->latest()->paginate(10);
        return CategoryResource::collection($categories);

    }

    /**
     * Display a search listing.
     *
     * @return \Illuminate\Http\Response
     */
    public function parent_category()
    {
        $categories= Category::where('parent_id',0)->latest()->get();
        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required'
        ]);

        $category= new Category;

        if($request->parent_id !=''){
            $category->parent_id    = $request->parent_id;
        }        
        $category->name         = $request->name;
        $category->save();

        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category= Category::find($id);
        return new CategoryResource($category);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'parent_id' => 'required',
            'name'      => 'required'
        ]);

        $category= Category::find($id);
        $category->parent_id    = $request->parent_id;
        $category->name         = $request->name;
        $category->save();

        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category= Category::find($id);
        $category->delete();

        return new CategoryResource($category);
    }
}
