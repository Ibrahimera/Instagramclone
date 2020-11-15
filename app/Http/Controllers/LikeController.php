<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Like;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {   
        $likes=Like::where('post_id',$id)->pluck("user_id");

        
        $results=[];
        foreach ($likes as $like) {
            $user=User::where('id',$like)->first();
            $profile=$user->profile;
                $img=$profile->img;
                $username=$user->username;
                if(auth()->user()){
                    $authuser=auth()->user();
                    $isFollow=$profile->followers()->where(['user_id'=>$authuser->id,'profile_id'=>$profile->id])->exists()?1:0;
                 }else{$isFollow=0;}
                
                array_push($results, ['img'=>$img,'username'=>$username,'isFollow'=>$isFollow]);

        }
        return $results;
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
        
        $data=$request->validate(['pId'=>'required']);
        $pId=$request->pId;$id=auth()->user()->id;
        $post=Post::where('id',$pId)->first();
        $like=Like::where(["post_id"=>$pId,"user_id"=>$id])->first();
        if($like){
            $like->delete();
            $post->update(['like'=>$post->like - 1]);
            return 0;
        }else{
          Like::create(['user_id'=>$id,'post_id'=>$pId]);
          $post->update(['like'=>$post->like + 1]);
          return 1;
        }
        return "success";
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
