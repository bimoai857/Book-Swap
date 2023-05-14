<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookList extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $guarded=['id'];
    public function book(){
        return $this->hasOne(Book::class,'id','book_id');
    }
}
