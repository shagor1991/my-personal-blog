<?php

namespace App\Http\Controllers\Api;

use App\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts= Post::paginate(5);

        return response()->json([
            'posts' => $posts
        ],200);
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
            'category_id'   => 'required',
            'title'         => 'required',
            'body'          => 'required',
            'photo'         => 'required',
        ]);

        $post= new Post;
        $post->user_id      = 1;
        $post->category_id  = $request->category_id;
        $post->title        = $request->title;
        $post->body         = $request->body;
        $post->photo        = $request->photo;
        $post->source_code_link  = $request->source_code_link;
        $post->save();

        return response()->json([
            'post' => $post
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post= Post::find($id);

        return response()->json([
            'post' => $post
        ],200); 
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
            'category_id'   => 'required',
            'title'         => 'required',
            'body'          => 'required',
            'photo'         => 'required',
        ]);

        $post= Post::find($id);
        $post->user_id      = 1;
        $post->category_id  = $request->category_id;
        $post->title        = $request->title;
        $post->body         = $request->body;
        $post->photo        = $request->photo;
        $post->source_code_link  = $request->source_code_link;
        $post->save();

        return response()->json([
            'post' => $post
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post= Post::find($id);
        $post->delete();
        
        return response()->json([
            'post' => $post
        ],200);
    }
}
