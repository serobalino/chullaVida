<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    protected $table        =       "tipo";
    protected $primaryKey   =       "id_ti";

    public function reglas(){
        return $this->hasMany(Regla::class,'id_ti','id_ti');
    }
}
