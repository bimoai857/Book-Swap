<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    public $timestamps=false;

    public function userTo(){
        return $this->belongsTo(User::class,'to','id');
    }
    public function userFrom(){
        return $this->belongsTo(User::class,'from','id');
    }
    public function book(){
        return $this->belongsTo(Book::class,'swapbook_id','id');
    }
    public function bookList(){
        return $this->hasMany(BookList::class,'notification_id','id');
    }
    public function notBooks(){
        return $this->hasMany(BookList::class,'notification_id','not_from');
    }
    protected $guarded=['id'];
  
}
