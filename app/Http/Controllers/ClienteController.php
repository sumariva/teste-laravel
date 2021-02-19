<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Empresa;
use App\Models\Uf;
use App\Models\ClienteEmpresa;

class ClienteController extends Controller
{
    const MENOR_IDADE = 18;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clientes = Cliente::with( ['pessoa', 'telefones', 'relEmpresa'] );
        $request->flash();
        //fazer a junção dos query strings para o form do filtro e paginador
        //dd($request->old());
        // aplica os filtros de dados
        if ( $request->has('filtro') ){
            if ( $request->has('nome') and $request->get('nome') ){
                $clientes->where('nome', 'ilike', '%'.$request->get('nome').'%');
            }
            if ( $request->has('cpf') and $request->get('cpf') ){
                $clientes->whereHas('pessoa', function(Builder $query ){
                        global $request;
                        return $query->where('cpf','ilike', '%'.$request->get('cpf').'%');
                    }
                );
            } elseif ( $request->has('cnpj') and $request->get('cnpj') ){
                $clientes->whereHas('empresarial', function(Builder $query ){
                        global $request;
                        return $query->where('cnpj','ilike', '%'.$request->get('cnpj').'%');
                    }
                );
            }
        }
        // evita duplicacao do atributo page usado pelo paginador
        $paginator = $clientes->paginate(4)->appends($request->except('page'));
        
        return view('clienteListar', ['lista' => $paginator, 'page' => $request->get('page', '0') ] );
    }
    /**
     * Exibe as opções de cliente
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clienteCriar', ['empresas' => Empresa::count() ] );
    }
    /**
     * Exibe o formulário de cliente Empresa
     *
     * @return \Illuminate\Http\Response
     */
    public function empresa()
    {
        return view('clienteCriarEmpresa', [
            
        ] );
    }
    /**
     * Exibe o formulário de cliente Pessoa
     *
     * @return \Illuminate\Http\Response
     */
    public function pessoa()
    {
        return view('clienteCriarPessoa', [
            'cliente' => null,
        ] );
    }
    /**
     * Exibe o formulário de cliente Pessoa para seleção da empresa.
     * Salva os valores do formulario anterior em campos.
     * Exibe a lista de empresas para seleção.
     * Exibe aviso das empresas do Paraná caso idade seja menor de 18 anos.
     * @return \Illuminate\Http\Response
     */
    public function pessoaEmpresa(Request $request)
    {
        $request->validate([
            'nome' => 'required|max:255',
            'cpf' => 'required|unique:App\Models\ClientePessoa,cpf',
            'rg' => 'required',
            'email' => 'required|email|unique:'.Cliente::class.',email',
            'nascimento' => 'required|date_format:'.Cliente::FORMATO_DATA,
        ]);
        $request->flash();
        $agora = new \DateTime();
        $nascimento = \DateTime::createFromFormat( Cliente::FORMATO_DATA, $request->input('nascimento') );
        if ( $agora < $nascimento ){
            // data invalida
        }
        //$uf = Uf::where('nome', '!=', Uf::PR)->get();
        //dd( $uf );
        $maiorIdade = $agora->diff( $nascimento );
        $avisoParana = $maiorIdade->y < self::MENOR_IDADE;
        $lista = Empresa::with( 'uf' );
        if ( $avisoParana ){
            $lista->whereHas( 'uf',
                function(Builder $query ){
                    return $query->where('nome', '!=', Uf::PR);
                }
            );
        }
        $lista = $lista->paginate(20);
        //tentei enviar para a mesma url com GET mas gerou loop de request,
        //redirecionando para outra acao do controller
        $lista->withPath('/cliente/listaEmpresa');
        
        return view('clientePessoaEscolherEmpresa', [
            'parana' => $avisoParana,
            'idade' => self::MENOR_IDADE,
            'lista' => $lista,
            'rotaFormulario' => route('cliente.pessoa.store'),
        ] );
    }
    /**
     * Exibe o formulário de cliente Empresa para seleção da empresa.
     * Salva os valores do formulario anterior em campos.
     * Exibe a lista de empresas para seleção.
     * Exibe aviso das empresas do Paraná caso idade seja menor de 18 anos.
     * @return \Illuminate\Http\Response
     */
    public function empresaEmpresa(Request $request)
    {
        $lista = Empresa::with( 'uf' )->paginate(20)->withPath('/cliente/listaEmpresa');
        $request->validate([
            'nome' => 'required|max:255',
            'cnpj' => 'required|unique:'.ClienteEmpresa::class.',cnpj',
            'email' => 'required|email|unique:'.Cliente::class.',email',
        ]);
        $request->flash();
        return view('clientePessoaEscolherEmpresa', [
            'parana' => false,
            'idade' => self::MENOR_IDADE,
            'lista' => $lista,
            'rotaFormulario' => route('cliente.store'),
        ] );
    }
    /**
     * Prove os dados para a listagem de empresas enquanto mantem os dados do formulario
     * na sessao de cadastro do cliente
     * @param Request $request
     */
    public function listaEmpresa( Request $request ){
        // tentando redirect para a outra acao
        $request->merge( $request->session()->getOldInput() );
        //dd( 'teste', $request->all(), $request->session()->getOldInput(), $request->old() );
        return $this->pessoaEmpresa( $request );
    }
    /**
     * Armazena um cliente pessoa com suas relações.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storePessoa(Request $request)
    {
        $inputs = array_replace( $request->old(), $request->all() );
        
        $request->merge( $request->session()->getOldInput() );
        // TODO verificar se problema no laravel, pois a juncao de parametros não alterou o valor
        // o valor da sessao nao sobreescreveu variavel do metodo GET
        
        //dd( $inputs, $request->all(), $request->get('empresa') );
        $request->flash();
        $request->validate([
            'empresa' => 'exists:'.Empresa::class.',id', //TODO ver se existe acessor para PK
        ]);
                
        DB::beginTransaction();
        $cliente = Cliente::create( $inputs );
        $cliente->pessoa()->create( $inputs );
        //dd( $cliente->getKey(), $cliente->getKeyName() );
        // preparar telefone para insercao
        $telefones = array();
        foreach ( $inputs['telefone'] as $t ){
            $telefones[] = array( 'numero' => $t );
        }
        
        //dd( $telefones );
        $cliente->telefones()->createMany( $telefones );
        DB::commit();
        
        $request->flush();
        return view( 'clientePessoaSalvo' );
    }
    /**
     * Armazena um cliente empresa com suas relações.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //obtem todas entradas das diferentes etapas 
        $inputs = array_replace( $request->old(), $request->all() );
        // fundir as entradas para validações finais caso exista dependencias a resolver
        $request->merge( $request->session()->getOldInput() );
        // manter os dados na sessao ate o salvamento
        $request->flash();
        //validacoes finais
        $request->validate([
            'empresa' => 'exists:'.Empresa::class.',id', //TODO ver se existe acessor para PK
        ]);
        // preparar telefone para insercao
        $telefones = array();
        foreach ( $inputs['telefone'] as $t ){
            $telefones[] = array( 'numero' => $t );
        }
        //dd( $telefones );
        // persistir as dependencias no sistema
        DB::beginTransaction();
        $cliente = Cliente::create( $inputs );
        $cliente->empresarial()->create( $inputs );
        $cliente->telefones()->createMany( $telefones );
        DB::commit();
        // limpar os dados coletados da sessao
        $request->flush();
        return view( 'clientePessoaSalvo' );
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return view('clienteRemovido');
    }
}
