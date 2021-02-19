@extends('layouts.app')
@section('title', 'Cadastro de cliente Pessoa')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<div class="container-sm">
		<form class="needs-validation g-3" novalidate method="post" action="{{ route('cliente.pessoa.empresa') }}">
		@csrf
{{-- campo nome da pessoa --}}	
		<div class="mb-3">
		<label class="form-label" for="nome_cliente">Nome</label>
		<input class="form-control" required placeholder="Nome do cliente" id="nome_cliente" type="text" name="nome"
		value="{{ old('nome') }}"
		/>
		<div class="invalid-feedback">
            Informe o nome do cliente.
        </div>
{{-- campo cpf da pessoa --}}
		<div class="mb-3">
		<label class="form-label" for="cpf_cliente">CPF</label>
		<input class="form-control" required placeholder="CPF do cliente" id="cpf_cliente" type="text" name="cpf"
		value="{{ old('cpf') }}"
		/>
		<div class="invalid-feedback">
            Informe o CPF do cliente.
        </div>
{{-- campo rg da pessoa --}}
		<div class="mb-3">
		<label class="form-label" for="rg_cliente">RG</label>
		<input class="form-control" required placeholder="RG do cliente" id="rg_cliente" type="text" name="rg"
		value="{{ old('rg') }}"
		/>
		<div class="invalid-feedback">
            Informe o RG do cliente.
        </div>
{{-- campo email da pessoa --}}
		<div class="mb-3">
		<label class="form-label" for="email_cliente">Email</label>
		<input class="form-control" required placeholder="Email do cliente" id="email_cliente" type="text" name="email"
		value="{{ old('email') }}"
		/>
		<div class="invalid-feedback">
            Informe o email do cliente.
        </div>
{{-- campo data nascimento da pessoa --}}
		<div class="mb-3">
		<label class="form-label" for="nascimento_cliente">Data de nascimento</label>
		<div class="input-group date datepicker" data-provide="datepicker" data-date-language="pt-BR" data-date-format="dd/mm/yyyy">
    		<input class="form-control" required placeholder="Data de nascimento do cliente" id="nascimento_cliente" type="text" name="nascimento"
    		value="{{ old('nascimento') }}"
    		/>
    		<div class="input-group-addon">
                <span class="glyphicon glyphicon-th"></span>
            </div>
        </div>
		<div class="invalid-feedback">
            Informe a data de nascimento do cliente.
        </div>
{{-- telefones --}}
<div class="mb-3">
<label class="form-label">Telefone</label>
@if ( old('telefone') == null )
  <input class="form-control" required placeholder="Telefone do cliente" type="text" name="telefone[]">
@else
@foreach ( old('telefone') as $telefone )
  <input class="form-control" required placeholder="Telefone do cliente" type="text" value="{{$telefone}}" name="telefone[]">
@endforeach 
@endif
<input class="btn btn-primary btn-sm" type="button" id="adicionar_telefone" value="Acrescentar...">
</div>
        <br/>
        <input class="btn btn-primary" type="submit" value="Avançar...">
@endsection
@push('jscode')
(function () {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
    })
  $( '#adicionar_telefone' ).click( function(){
  		$( '<input class="form-control" required placeholder="Telefone do cliente" type="text" name="telefone[]">' ).insertBefore( $( this ) );
    }
  );
})()
@endpush