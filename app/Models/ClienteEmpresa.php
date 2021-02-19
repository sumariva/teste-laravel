<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteEmpresa extends Model
{
    protected $table = 'clienteEmpresa';
    public $timestamps = false;
    protected $fillable = ['cnpj'];
    /**
     * Formatador para cnpj
     *
     * @param string $value
     * @return string
     */
    public function getCnpjAttribute( $value )
    {
        $val = preg_replace('/[^0-9]*/', '', $value);
        $parts = array();
        $parts[0] = str_pad( number_format( substr( $val, 0, -6 ), 0, '', '.'), 11, '0', STR_PAD_LEFT );
        $parts[1] = str_pad( number_format( substr( $val, -6 )/100, 2, '-'), 7, '0', STR_PAD_LEFT );
        //dd( $value, $parts ,$val, implode('/', $parts) );
        return implode('/', $parts);
    }
    /**
     * Modificador do atributo cnpj.
     *
     * @param  string  $value
     * @return void
     */
    public function setCnpjAttribute($value)
    {
        $this->attributes['cnpj'] = preg_replace( '/[^0-9]*/', '', $value);
    }
}
