<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmpresaController;
//use App\Http\Controllers\ClienteController;
use App\Models\Uf;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// adicionando as rotas para os modelos de dados da aplicacao e controladores

//cruds de rotas geradas

// rotas suplementares do controller
// infelizmente descobri que a ordem modifica as rotas, sendo necessário adicionar
// conforme notas da documentação
// as rotas customizadas primeiro, algum bug com a chamada de Route::resource e Route::resources
Route::get('cliente/empresa', [ClienteController::class, 'empresa'])->name('cliente.empresa');
Route::get('cliente/pessoa', [ClienteController::class, 'pessoa'])->name('cliente.pessoa');
Route::post('cliente/pessoa', [ClienteController::class, 'storePessoa'])->name('cliente.pessoa.store');
Route::post('cliente/pessoa/empresa', [ClienteController::class, 'pessoaEmpresa'])->name('cliente.pessoa.empresa');
Route::post('cliente/empresa/empresa', [ClienteController::class, 'empresaEmpresa'])->name('cliente.empresa.empresa');
Route::get('cliente/listaEmpresa', [ClienteController::class, 'listaEmpresa'])->name('cliente.pessoa.empresa.paginate');
//[modelo.index,modelo.create,modelo.store,modelo.show,modelo.edit,modelo.update,modelo.destroy]
Route::resource( 'cliente', ClienteController::class );

Route::resources(
    [ 
        'empresa' => EmpresaController::class,
    ]);

Route::get('/', function () {
    return view('layouts.app');
});


Route::get('/uf', function () {
    return view('uf', ['estados' => Uf::all() ] );
});


