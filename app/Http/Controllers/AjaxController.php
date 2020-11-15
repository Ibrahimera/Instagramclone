<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;


class AjaxController extends Controller
{
    /**$object->updated_at->diffForHumans();
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   $username=$request->username;
        $user=User::where('username',$username)->firstOrfail();
        $posts=$user->posts;$liked=[];
        if(auth()->user()){
            $authUser=auth()->user();
            $id=$authUser->id;
            $authuser=[$authUser->username,$authUser->profile->img];
            $authprofile=Profile::where('user_id',$id)->first();
            $isFollow=$user->profile->followers()->where(['user_id'=>$id,'profile_id'=>$user->profile->id])->exists()?1:0;

        }else{
            $authuser=['',''];
            $isFollow=0;
            $id='';
        }
            $postArray=[];
            foreach ($posts as $post) {
                $time=$post->created_at->diffForHumans();
                $item=['id'=>$post->id,'caption'=>$post->caption,'like'=>$post->like,'comment'=>$post->comment,'img'=>$post->img,'img_thumbnail'=>$post->img_thumbnail,'user_id'=>$post->user_id,'time'=>$time];
                   array_push($postArray,$item);
                        $likecontent=0;
                        foreach ($post->likes as  $like) {
                            if(auth()->user()){
                              if($like->user->id==$id){$likecontent=1;} 
                            }
                        }
                        array_push($liked, $likecontent);
                    } 
        return ["user"=>$user,"profile"=>$user->profile,"posts"=>$postArray,'isFollow'=>$isFollow,'liked'=>$liked,'authuser'=>$authuser];
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
