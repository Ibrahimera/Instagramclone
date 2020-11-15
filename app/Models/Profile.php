<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function user(){
    	return $this->belongsTo(User::class);
    }
    public function posts(){
    	return $this->hasMany(Post::class);
    }
    public function followers(){
    	return $this->hasMany(Follow::class);
    }
}
