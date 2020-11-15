<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class LoginController extends Controller
{

 public function index(){
    if(Auth::check()){
        $user = Auth::user();
        $img=$user->profile->img;
        return [$user->username,$img];
    }else{
        return ['',''];
    }
 }

 public function store(Request $request){
        $data=$request->validate(['email'=>'required|email','password'=>'required','remember'=>'required']);
        $email=$data['email'];
        $password=$data['password'];
        $remember=$data['remember'];
        if(Auth::attempt(['email' => $email, 'password' => $password],$remember)){
            $user = Auth::user();
            $img=$user->profile->img;
            return [$user->username,$img];
        }else{
           return response()->json(['error'=>'The credentail does not match'],401);
        }
 }


 public function logout(){
     
     Auth::logout();
 }


}
