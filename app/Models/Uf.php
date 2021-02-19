<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
 * Modelo representando a unidade federativa. Composto inicialmente por 2 atributos abaixo:
 * id serial integer
 * uf nome da unidade federativa string
 */
class Uf extends Model
{
    /**
     * Constante especial para o Estado a ser filtrado
     * @final string
     */
    const PR = 'PR';
    var $table = 'uf';
    var $timestamps = false;
}
