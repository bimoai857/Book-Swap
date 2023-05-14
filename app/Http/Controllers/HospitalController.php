<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hospital;
class HospitalController extends Controller
{
    //
    public function create(){
        $data=['username'=>'Ajuj','password'=>'ajuj'];
        Hospital::create($data);
    }
    public function get(){
        return Hospital::first()['username'];
    }
    public function delete(){
        return Hospital::find(3)->delete();
    }

    public function update(){
        $data=['username=>Jack','password'=>'jack'];
        Hospital::find(2)->update($data);
      
    }

    public function uoc(){
        $data=['username'=>'Naruto','password'=>'uzumaki'];
        Hospital::updateOrCreate(['id'=>1],$data);
    }
}
