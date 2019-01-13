<?php

namespace App\Http\Controllers;

use App\Log;
use App\Regla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class GenerarReglasController extends Controller
{
    public function jugar(){
        return view('juego');
    }


    public function generar(){
        $partida    =   Auth::user()->juego();
        if($partida){
            $anterior   =   Log::where('id_ju',$partida->id_ju)->latest()->first();
            $regla      =   collect(Regla::where('id_ti',$partida->id_ti)->where('id_re','!=',@$anterior->id_re)->get())->random(1)->first();
            if(!$regla)
                $regla  = Regla::where('id_ti',$partida->id_ti)->first();

            $tomado =   collect($partida->jugadores)->random(1)->first();
            $sobra  =   collect($partida->jugadores)->filter(function ($value) use($tomado){
                return $value['id_pa']!==$tomado->id_pa;
            });

            if(strpos($regla->detalle_re,'x'))
                $texto  =   str_replace('x',$tomado->nombre_pa,$regla->detalle_re);
            if(strpos($regla->detalle_re,'y')){
                $tomado =   collect($sobra)->random(1)->first();
                $texto  =   str_replace('y',$tomado->nombre_pa,$texto);
            }

            $nueva  =   new Log();

            $nueva->id_ju             =   $partida->id_ju;
            $nueva->id_re             =   $regla->id_re;
            $nueva->instruccion_re    =   $texto;
            $nueva->save();

            return response(['val'=>true,'regla'=>$nueva,'mensaje'=>'Se generó correctamente']);
        }else
            return response(['val'=>false,'mensaje'=>'No se puede generar Reglas porque no tiene un juego activo']);
    }

    public function parar(){
        $partida            =   Auth::user()->juego();
        $partida->estado_ju =   false;
        $partida->save();
        return (['val'=>true]);
    }
}
