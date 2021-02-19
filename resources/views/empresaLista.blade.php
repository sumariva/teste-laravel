@extends('layouts.app')
@section('title', 'Lista de Empresas')
@section('content')
<table class="table listaEmpresa">
  <thead>
    <tr>
      <th scope="col">Ações</th>
      <th scope="col">Razão Social</th>
      <th scope="col">CNPJ</th>
      <th scope="col">UF</th>
    </tr>
  </thead>
  <tbody>
  	@foreach ($lista as $item)
      <tr>
		<td>
		  	<form action="{{ route('empresa.destroy', $item) }}" method="POST">
                @method('DELETE')
                @csrf
                <input class="btn btn-sm btn-danger" type="submit" value="Remover">
            </form>
            <a class="btn btn-sm btn-info" href="{{ route('empresa.edit', $item) }}">Editar</a>
		</td>
		<td>{{ $item->razao_social }}</td>
		<td>{{ $item->cnpj }}</td>
		<td>{{ $item->getUf()->nome }}</td>
	  </tr>
	@endforeach
  <tr>
  	<td colspan="2">
  	<a class="btn btn-primary btn-sm" href="{{ route('empresa.create') }}">Nova...</a>
  	</td>
  </tr>
  </tbody>
</table>  
@endsection