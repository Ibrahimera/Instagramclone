<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Follow;
use App\Models\Post;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authuser=auth()->user();
        $id=$authuser->id;
        $postIds=Post::where('user_id',$id)->pluck('id');
        $likes=Like::whereIn('post_id', $postIds)->whereDate('created_at', Carbon::today())->get();
        $comments=Comment::whereIn('post_id', $postIds)->whereDate('created_at', Carbon::today())->get();
        $followers=Follow::where('profile_id', $authuser->profile->id)->whereDate('created_at', Carbon::today())->get();

         $likepost=$this->createData($likes,' Liked your post');
         $commentpost=$this->createData($comments,' commented on your post');
         $todayfollowers=$this->createData($followers,' started following you');
         $all=array_merge($likepost,$commentpost,$todayfollowers);


        return $all;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     private  function createData($datas,$msg)
    {
        $todayData=[];
        foreach ($datas as $data) {
            $user=$data->user;
            array_push($todayData, ['username'=>$user->username,'img'=>$user->profile->img,'msg'=>$msg]);
        }
        return $todayData;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
