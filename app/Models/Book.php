<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    public $timestamps=false;

    protected $guarded=['id'];
    public function notification(){
        return $this->hasOne(notification::class,'swapbook_id','id');
    }
    public function User(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
