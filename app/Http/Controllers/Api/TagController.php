<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TagCollection;
use App\Http\Resources\TagResource;
use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = new TagCollection(Tag::latest()->paginate(10));
        return $tags;
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
            'name'  => 'required'
        ]);

        $tag= new Tag;
        $tag->name= $request->name;
        $tag->save();

        return new TagResource($tag);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new TagResource(Tag::find($id));
    }


    /**
     * Display the search result listing.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search($field,$query)
    {
        return new TagCollection(Tag::Where($field, 'LIKE', "%$query%")->latest()->paginate(10));
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
            'name'  => 'required'
        ]);

        $tag= Tag::find($id);
        $tag->name= $request->name;
        $tag->save();

        return new TagResource($tag);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag= Tag::find($id);
        $tag->delete();

        return new TagResource($tag);
    }
}
