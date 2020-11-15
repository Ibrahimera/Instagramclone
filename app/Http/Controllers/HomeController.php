<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Profile;
use App\Models\Follow;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('layouts.app');
    }

    public function store()
    {
        $posts=Post::orderBy('created_at','desc')->limit(8)->select('user_id','img','caption')->get();
        $users=User::orderBy('created_at','desc')->limit(20)->select('id','username')->get();
        $usersHome=[];
        foreach ($users as $u) {
          $p=Profile::where('user_id',$u['id'])->first();
            if(auth()->user()){
             $isFollow=Follow::where(['user_id'=>auth()->user()->id,'profile_id'=>$p->profile_id])->exists()?1:0;
            }else{$isFollow=0;}
            array_push($usersHome, ['img'=>$p->img,'username'=>$u->username,'isFollow'=>$isFollow]);
        }
        $userPosts=[];
        $postsArray=[];
        if(auth()->user()){
           $user=auth()->user();
           $authuser=[$user->username,$user->profile->img];
           $following=$user->following;
           
           foreach ($following as $follow) {
               $userPost=$follow->user;
               $post=$userPost->posts()->whereDate('created_at', Carbon::today())->select('user_id','img','caption')->first();
               
               if($post){array_push($postsArray, $post);
                $username=$userPost->name;
               $img=$userPost->profile->img;
               array_push($userPosts, ["username"=>$username,"img"=>$img]);}
             if(count($postsArray) >=8){break;}
           }
           
         }

         $index=0;
           while (count($postsArray) < 8) {
               $post1=$posts[$index];
               $u1=User::where('id',$post1['user_id'])->select('id','username')->first();
               $p1=Profile::where('user_id',$u1['id'])->first();
               array_push($userPosts, ["username"=>$u1->username,"img"=>$p1->img]);
               array_push($postsArray, $post1);
               $index++;
           }
         return response()->json(['posts'=>$postsArray,'users'=>$usersHome,'usersPost'=>$userPosts,'authuser'=>$authuser ?? ['','']]);
    }
}
