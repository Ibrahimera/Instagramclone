<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
      if(auth()->user()){
        $data=$request->validate(['img'=>"required|image",'img_thumbnail'=>"",'caption'=>"string|max:2000"]);
       if($files=$request->file('img')){
            $extension = $files->getClientOriginalExtension();
            $Image = Image::make($files);
            $Image=$Image->fit(1200,1200);
            $limg= "storage/uploads/posts/".time().".".$extension;
            $Image->save($limg);
            $Image->fit(350,350);
            $simg= "storage/uploads/posts/thumbnail/".time().".".$extension;
            $Image->save($simg);
            $ImgPath=['img'=>"/".$limg,'img_thumbnail'=>"/".$simg,'like'=>0,'comment'=>0];

        }
        $newPost=auth()->user()->posts()->create(array_merge($data,$ImgPath ?? []));
        return $newPost;            
      }

  }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
