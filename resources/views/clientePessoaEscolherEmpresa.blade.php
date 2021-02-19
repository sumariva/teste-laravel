@extends('layouts.app')
@section('title', 'Cadastro de clientes')

@section('content')
{{-- informar a regra de clientes do paraná --}}
@if ( $parana )
      	<div class="alert alert-info">
            <ul>
              Atenção: empresas do Paraná não permitem clientes menores de {{ $idade }} como
              clientes. Estas empresas estão excluídas da lista abaixo.
            </ul>
        </div>
@endif
<div class="container">
<form action="{{ $rotaFormulario }}" method="post">
@csrf
{{ $lista->links() }}
<table class="table listaEmpresa">
  <thead>
    <tr>
      <th scope="col">Selecionar</th>
      <th scope="col">Razão Social</th>
      <th scope="col">CNPJ</th>
      <th scope="col">UF</th>
    </tr>
  </thead>
  <tbody>
  	@foreach ($lista as $item)
      <tr>
		<td>
			<input class="form-check-input" type="radio" name="empresa" value="{{ $item->id }}"/>
		</td>
		<td>{{ $item->razao_social }}</td>
		<td>{{ $item->cnpj }}</td>
		<td>{{ $item->getUf()->nome }}</td>
	  </tr>
	@endforeach
  <tr>
  	<td colspan="2">
  	<input id="enviar" class="btn btn-primary btn-sm" name="salvar" value="Salvar novo cliente" type="submit" disabled>
  	</td>
  </tr>
  </tbody>
</table>
</form>
</div>
@endsection
@push('jscode')
$('.form-check-input').change( function(){
  $('#enviar').prop( "disabled", false );
}
);
@endpush