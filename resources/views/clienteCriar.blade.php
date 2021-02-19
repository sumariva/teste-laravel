@extends('layouts.app')
@section('title', 'Cadastro de clientes')

@section('content')
{{-- Vamos por etapas, etapa 1 PF ou CNPJ --}}
@if ( $empresas == 0 )
      <h1>Sem empresas no cadastro!</h1>
      <a href="{{ route('empresa.create') }}">Adicionar empresa...</a>
@else
<div class="container">
	Esse cliente é...
	<br/>
    <a class="btn btn-primary btn-sm" href="{{ route('cliente.empresa') }}">Empresa...</a>
    <a class="btn btn-primary btn-sm" href="{{ route('cliente.pessoa') }}">Pessoa...</a>
</div>
@endif
	
@endsection
