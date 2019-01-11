<?php

namespace App\Http\Controllers;


use App\Tipo;
use Illuminate\Http\Request;

class ListasController extends Controller
{
    public function tipos(){
        return Tipo::all();
    }

    public function reglas($id){
        return @Tipo::find($id)->reglas;
    }
}
