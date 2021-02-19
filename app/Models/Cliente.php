<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Exception;
use DateTime;

/*
* Empresa;
* Nome;
* CPF ou CNPJ;
* Data/hora de cadastro;
* Telefone (Quantidade de telefones é variável);
* E-mail.
*/

/*
 * Modelo generico de cliente. Possue 2 especializações ClientePessoa e ClienteEmpresa.
 * Prove os atributos básicos compartilhados.
 */

class Cliente extends Model
{
    const FORMATO_DATA = 'd/m/Y';
    protected $table = 'cliente';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nome', 'email', 'empresa' ];
    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = self::FORMATO_DATA;
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:'.self::FORMATO_DATA,
    ];
    /**
     * Formatador para data de cadastro
     *
     * @param string $value
     * @return string
     */
    public function getCreatedAtAttribute( $value )
    {
        try {
            $data = new DateTime( $value );
            return $data->format( Cliente::FORMATO_DATA );
        } catch (Exception $e) {
            return $value;
        }
    }
    /**
     * Modificador do atributo nome.
     *
     * @param  string  $value
     * @return void
     */
    public function setNomeAttribute($value)
    {
        $this->attributes['nome'] = trim($value);
    }
    /**
     * Relação de empresas desse cliente
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function relEmpresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa', 'id');
    }
    /**
     * Obtem os números de telefone do cliente.
     * @return array[Telefone]
     */
    public function telefones()
    {
        return $this->hasMany( Telefone::class, 'cliente' );
    }
    /**
     * Obtem os atributos da pessoa se o cliente for Pessoa
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function pessoa(){
        return $this->hasOne( ClientePessoa::class, 'id' );
    }
    /**
     * Obtem os atributos da pessoa se o cliente for Pessoa
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function empresarial(){
        return $this->hasOne( ClienteEmpresa::class, 'id' );
    }
    /**
     * Exclui o usuario e suas dependências: telefones, dados pessoais, dados empresariais
     * 
     * {@inheritDoc}
     * @see \Illuminate\Database\Eloquent\Model::delete()
     */
    public function delete(){
        if (! $this->exists){
            return false;
        }
        DB::beginTransaction();
        $this->load(['telefones','pessoa', 'empresarial']);
        $this->telefones()->delete();
        if ( $this->pessoa ){
            $this->pessoa->delete();
        }
        if ( $this->empresarial ){
            $this->empresarial->delete();
        }
        parent::delete();
        DB::commit();
        return true;
    }
}
