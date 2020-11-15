<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($pId)
    {
        $comments=Comment::where('post_id',$pId)->get();
        $rcomments=[];
        foreach ($comments as $comment) {
            $user=$comment->user;
            $username=$user->username;
            $img=$user->profile->img;
            $time=$comment->created_at->diffForHumans();
            $item=['id'=>$comment->id,'username'=>$username,'img'=>$img,'comment'=>$comment->comment,'time'=>$time];
            array_push($rcomments, $item);
        }
        return $rcomments;
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
        $data=$request->validate([
            'pId'=>'required',
             'msg'=>'required'
        ]);
        $pId=$request->pId;
        $msg=$request->msg;
        if(auth()->user()){
            $id=auth()->user()->id;
            $post=Post::where('id',$pId)->first();
            $post->update(['comment'=>$post->comment + 1]);
            $comment=Comment::create(['user_id'=>$id,'post_id'=>$pId,'comment'=>$msg]);
            
        }else{
            return "error";
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
