<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use App\Models\Uf;
use Illuminate\Support\Facades\Redirect;

use Symfony\Component\HttpFoundation\RedirectResponse;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('empresaLista', ['lista' => Empresa::all() ] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('empresaCriar', [
            'listaUf' => Uf::all(),
            'empresa' => null,
        ] );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'razao_social' => 'required|max:255', //unique|
            'cnpj' => 'required|unique:App\Models\Empresa,cnpj',
            'uf' => 'required',
        ]);
        $model = new Empresa;
        $model->razao_social = $request->razao_social;
        $model->cnpj = $request->cnpj;
        $model->uf = $request->uf;
        $model->save();
        return redirect()->route('empresa.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function show(Empresa $empresa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function edit(Empresa $empresa)
    {
        return view('empresaCriar', [
            'listaUf' => Uf::all(),
            'empresa' => $empresa,
        ] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Empresa $empresa)
    {
        $request->validate([
            'razao_social' => 'required|max:255',
            'cnpj' => 'required',
            'uf' => 'required',
        ]);
        /*
         * Fazer segunda validação se houve alteração no numero do CNPJ
         */
        if ( $empresa->cnpj != $request->cnpj ){
            $request->validate([ 
                'cnpj' => 'unique:App\Models\Empresa,cnpj',
                
            ]);
        }
        $empresa->razao_social = $request->razao_social;
        $empresa->cnpj = $request->cnpj;
        $empresa->uf = $request->uf;
        $empresa->save();
        return redirect()->route('empresa.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empresa $empresa)
    {
        $empresa->delete();
        return redirect()->route('empresa.index');
    }
}
