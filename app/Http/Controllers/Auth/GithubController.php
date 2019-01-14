<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GithubController extends Controller
{
    public function redirectToProvider(){
        return Socialite::driver('github')->redirect();
    }

    /**
     * @Socialite usa el driver de linkedin
     * el cual devuelve la informacion del usuario
     * verifica que la ID del usuario exista si existe solo actualiza la informacion si no existe crea un nuevo registro
     * y envia un email de bienvenida
     * y logea al usuario
     * al final retorna una redireccion a la pagina principal
     **/
    public function handleProviderCallback(){
        $user       =   Socialite::driver('github')->user();
        $usuario    =   User::where('github',$user->getId())->orWhere('email',$user->getEmail())->first();
        $a          =   false;
        if(!$usuario){
            $usuario            =   new User();
            $a                  =   true;
        }

        $usuario->name      =   $user->getName();
        $usuario->github    =   $user->getId();
        $usuario->email     =   $user->getEmail();
        $usuario->save();


        Auth::login($usuario,true);
        return redirect(route('home'));
    }
}
