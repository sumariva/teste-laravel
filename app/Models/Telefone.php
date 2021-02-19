<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
 * Modelo representando número de telefone. Composto inicialmente por 2 atributos abaixo:
 * cliente serial integer
 * numero string
 */
class Telefone extends Model
{
    protected $table = 'telefone';
    protected $primaryKey = 'cliente';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['numero'];
}
