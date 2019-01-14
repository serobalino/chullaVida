<?php

namespace App\Http\Controllers;

use App\Log;
use App\Regla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class GenerarReglasController extends Controller
{
    /**
     * devuelve la vista de reglas
    **/
    public function jugar(){
        return view('juego');
    }

    /**
     *
     * Genera Consulta y Registra reglas al azar por el nombre de jugadores ingresado
    **/
    public function generar(){
        $partida    =   Auth::user()->juego();
        if($partida){
            $anterior   =   Log::where('id_ju',$partida->id_ju)->latest()->first();//consulta cual fue la anterior regla echa
            $reglas     =   Regla::where('id_ti',$partida->id_ti)->where('id_re','!=',@$anterior->id_re)->get();//consulta la reglas posible diferentes a la ultima regla echa
            if(count($reglas))
                $regla  =   collect($reglas)->random(1)->first();//regla al azar del consulto posible
            else
                $regla  = Regla::where('id_ti',$partida->id_ti)->first();//misma regla si no existan mas

            $tomado =   collect($partida->jugadores)->random(1)->first();//toma el nombre de un jugador al azar
            $sobra  =   collect($partida->jugadores)->filter(function ($value) use($tomado){//quita el nombre del jugador tomado de la lista
                return $value['id_pa']!==$tomado->id_pa;
            });

            if(strpos($regla->detalle_re,'x'))//busca el parametro x en la regal
                $texto  =   str_replace('x',$tomado->nombre_pa,$regla->detalle_re);//si encuentra remplaza por el nombre del jugador tomado
            if(strpos($regla->detalle_re,'y')){//busca y en la regla
                $tomado =   collect($sobra)->random(1)->first();//si existe toma el nombre de un jugador
                $texto  =   str_replace('y',$tomado->nombre_pa,$texto);//remplaza por el nombre dle jugador
            }

            $nueva  =   new Log();//crea un registro
            $nueva->id_ju             =   $partida->id_ju;
            $nueva->id_re             =   $regla->id_re;
            $nueva->instruccion_re    =   $texto;
            $nueva->save();

            return response(['val'=>true,'regla'=>$nueva,'mensaje'=>'Se generó correctamente']);
        }else
            return response(['val'=>false,'mensaje'=>'No se puede generar Reglas porque no tiene un juego activo']);
    }

    /**
     * cambia el estado de un Juego a desactivado
     *
    **/
    public function parar(){
        $partida            =   Auth::user()->juego();
        $partida->estado_ju =   false;
        $partida->save();
        return (['val'=>true,'ruta'=>route('home')]);
    }
}
