<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use Exception;
use NumberFormatter;
use GuzzleHttp\Client;

class ClientePessoa extends Model
{
    protected $table = 'clientePessoa';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nascimento', 'rg', 'cpf'];
    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = Cliente::FORMATO_DATA;
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'nascimento' => 'datetime:'.Cliente::FORMATO_DATA,
    ];
    /**
     * Formatador para data de nascimento
     *
     * @param string $value
     * @return string
     */
    public function getNascimentoAttribute( $value )
    {
        try {
            $data = new DateTime( $value );
            return $data->format( Cliente::FORMATO_DATA );
        } catch (Exception $e) {
            return $value;
        }
    }
    /**
     * Formatador para cpf
     *
     * @param string $value
     * @return string
     */
    public function getCpfAttribute( $value )
    {
        $val = preg_replace('/[^0-9]/', '', $value);
        $val = str_pad( number_format($val/100, 2, '/', '.'), 14, '0', STR_PAD_LEFT );
        return $val;
    }
    /**
     * Modificador do atributo rg.
     *
     * @param  string  $value
     * @return void
     */
    public function setRgAttribute($value)
    {
        $this->attributes['rg'] = preg_replace( '/[^0-9]*/', '', $value);
    }
    /**
     * Modificador do atributo cpf.
     *
     * @param  string  $value
     * @return void
     */
    public function setCpfAttribute($value)
    {
        $this->attributes['cpf'] = preg_replace( '/[^0-9]*/', '', $value);
    }
}
