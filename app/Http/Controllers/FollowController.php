<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {  
        $param=$request->param;$profile=Profile::where('id',$param['id'])->first();
        $authId=auth()->user() ? auth()->user()->id:false;
        $authProfileId=auth()->user() ? auth()->user()->profile->id:false;
        
        
        if($param['text'] =="Following"){
            $following=$profile->user->following;
            $followingArray=[];
            foreach ($following as  $follow) {
                $prof=$follow->profile;
                $img=$prof->img;
                $username=$prof->user->username;
                if($authId){$isFollow=$prof->followers()->where(['user_id'=>$authId ,'profile_id'=>$prof->id])->exists()?1:0;}else{$isFollow=0;}
                
                array_push($followingArray, ['img'=>$img,'username'=>$username,'isFollow'=>$isFollow]);
            }
            return $followingArray;
        }else{
            $followers=$profile->followers;
            $followingArray=[];
            foreach ($followers as  $follow) {
                $user=$follow->user;
                $img=$user->profile->img;
                $username=$user->username;
                if($authId){$isFollow=$user->following()->where(['user_id'=>$user->id,'profile_id'=>$authProfileId])->exists()?1:0;}else{$isFollow=0;}
                
                array_push($followingArray, ['img'=>$img,'username'=>$username,'isFollow'=>$isFollow]);
            }
            return $followingArray;            
        }
        
        
        
        
        

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
     +
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user=User::where('username',$request->username)->first();
        $profile=$user->profile;
        $user_id=auth()->user()->id;
        $follow=Follow::where(['user_id'=>$user_id,"profile_id"=>$profile->id])->first();
        $profileFollower =Profile::where('user_id',$user_id)->first();
        if($follow){
            $follow->delete();
            $profileFollower->update(['following'=>$profileFollower->following - 1]);
            $profile->update(['follower'=>$profile->follower - 1]);
        }else{
          Follow::create(['user_id'=>$user_id,'profile_id'=>$profile->id]);
          $profileFollower->update(['following'=>$profileFollower->following + 1]);
          $profile->update(['follower'=>$profile->follower + 1]);
        }
         
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Follow  $follow
     * @return \Illuminate\Http\Response
     */
    public function show(Follow $follow)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Follow  $follow
     * @return \Illuminate\Http\Response
     */
    public function edit(Follow $follow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Follow  $follow
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Follow $follow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Follow  $follow
     * @return \Illuminate\Http\Response
     */
    public function destroy(Follow $follow)
    {
        //
    }
}
