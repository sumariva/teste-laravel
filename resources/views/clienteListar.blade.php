@extends('layouts.app')
@section('title', 'Cadastro de clientes')

@section('content')
    @if ( count( $lista ) == 0 and ( null == old('filtro') ) )
      <h1>Sem clientes no cadastro!</h1>
      <a href="{{ route('cliente.create') }}">Adicionar cliente...</a>
    @else
<div class="filtroCliente">
<form name="filtroCliente" method="get">
@csrf
<input type="hidden" name="page" value="{{$page}}">
<h3>Filtros</h3>
<div class="input-group mb-3">
  <span class="input-group-text" id="basic-addon3">Nome</span>
  <input type="text" value="{{old('nome')}}" class="form-control" name="nome" id="basic-url" aria-describedby="basic-addon3">
</div>
<div class="input-group mb-3">
  <div class="input-group-text">
    CPF
  </div>
  <input type="text" value="{{old('cpf')}}" class="form-control" name="cpf" aria-label="Entrada de texto para filtro de nome">
  <div class="input-group-text">
    CNPJ
</div>
  <input type="text" value="{{old('cnpj')}}" class="form-control" name="cnpj" aria-label="Entrada de texto para filtro de CNPJ">
</div>
<div class="col-12">
    <button type="submit" name="filtro" value="cliente" class="btn btn-primary">Filtrar</button>
</div>
</form>
</div>
      {{ $lista->links() }}
      <table class="table listaCliente">
      <thead>
        <tr>
          <th scope="col">Ações</th>
          <th scope="col">Nome</th>
          <th scope="col">CNPJ CPF</th>
          <th scope="col">Email</th>
          <th scope="col">Telefone</th>
          <th scope="col">RG</th>
          <th scope="col">Data de Nascimento</th>
          <th scope="col">Data do cadastro</th>
          <th scope="col">Empresa</th>
        </tr>
      </thead>
      <tbody>
      	@foreach ($lista as $item)
          <tr>
    		<td>
    		  	<form action="{{ route('cliente.destroy', $item) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <input class="btn btn-sm btn-danger" type="submit" value="Remover">
                </form>
                {{-- <a class="btn btn-sm btn-info" href="{{ route('cliente.edit', $item) }}">Editar</a> --}}
    		</td>
    		<td>{{ $item->nome }}</td>
    		<td>{{ $item->pessoa ? $item->pessoa->cpf : $item->empresarial->cnpj }}</td>
    		<td>{{ $item->email }}</td>
    		<td>
    		@foreach ( $item->telefones as $telefone )
    		{{ $telefone->numero }}<br/>
    		@endforeach
    		</td>
    		<td>{{ $item->pessoa ? $item->pessoa->rg : '' }}</td>
    		<td>{{ $item->pessoa ? $item->pessoa->nascimento : '' }}</td>
    		<td>{{ $item->created_at }}</td>
    		<td>{{ $item->relEmpresa->razao_social }}</td>
    	  </tr>
    	@endforeach
      <tr>
      	<td colspan="2">
      	<a class="btn btn-primary btn-sm" href="{{ route('cliente.create') }}">Novo cliente...</a>
      	</td>
      </tr>
      </tbody>
      </table>
	@endif
	
@endsection
