<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Unirest\Request as Consulta;

class ChatController extends Controller
{
    private  $url="http://sandbox.api.simsimi.com/request.p";

    /**
     * Consulta por GET a la api de SIM SIMI y lanza un numero aleatorio
     * de 3 a 25 segundo para q demore en responder el mensaje enviado
    **/
    public function enviarMsg(Request $datos){
        Consulta::verifyPeer(false);
        $response = Consulta::get($this->url,
            [
                "Accept" => "application/rest"
            ],[
                "key"   =>  config("services.simsimi.key"),
                "text"  =>  $datos->q,
                "lc"    =>  'es',
                "ft"    =>  '1.0'
            ]
        );
        $espera=rand (3,25);
        sleep($espera);
        return response()->json($response->body);
    }
}
