<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

/*
 * Modelo da empresa. Composto inicialmente por 3 atributos abaixo:
 * razaoSocial string
 * cnpj string(14) 14 caracteres
 * uf nome da unidade federativa sede integer
 */
class Empresa extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'empresa';
    public $timestamps = false;
    /**
     * Obtem a UF da Empresa
     * @return Model
     */
    public function getUf()
    {
        return Uf::find( $this->uf );
        
    }
    /**
     * Define um acesso para a relação.
     * Usando o nome do modelo da relação e o atributo na tabela da relacao e o atributo local
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function uf() {
        return $this->hasOne(Uf::class, 'id', 'uf');
    }
    /**
     * Relação de clientes dessa empresa
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clientes()
    {
        return $this->belongsToMany(Cliente::class);
    }
}
