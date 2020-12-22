<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('profile');
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
            $data=$request->validate(['img'=>"",'description'=>"string|max:255",'website'=>"string|max:255",'name'=>"string|max:100"]);
            $profileUpdate=Profile::where('id',$request->id)->first();
            if($profileUpdate->user->id==auth()->user()->id){
            if($files=$request->file('img')){
            $extension = $files->getClientOriginalExtension();
            $Image = Image::make($files);
            $Image=$Image->fit(150,150);
            $simg= "storage/uploads/profiles/".time().".".$extension;
            $Image->save($simg);

            $imageArray=['img'=>$simg];
            if($profileUpdate->img !='/storage/uploads/profiles/user.svg'){unlink(public_path($profileUpdate->img));}}
            
           $updated= $profileUpdate->update(array_merge($data,$imageArray ?? []));
            if(isset($simg)){return $simg;}else{return 0;}                
            }
            
        }
       
    }
    
 

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show($username)
    { 
        return view('profile',compact('username'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
