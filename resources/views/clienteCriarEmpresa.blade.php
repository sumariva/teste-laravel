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
		<form class="needs-validation g-3" novalidate method="post" action="{{ route('cliente.empresa.empresa') }}">
		@csrf
{{-- campo nome da empresa --}}	
		<div class="mb-3">
		<label class="form-label" for="nome_cliente">Razão Social</label>
		<input class="form-control" required placeholder="Razão social do cliente" id="nome_cliente" type="text" name="nome"
		value="{{ old('nome') }}"
		/>
		<div class="invalid-feedback">
            Informe a razão social do cliente.
        </div>
{{-- campo cnpj do cliente --}}
		<div class="mb-3">
		<label class="form-label" for="cnpj_cliente">CNPJ</label>
		<input class="form-control" required placeholder="CNPJ do cliente" id="cnpj_cliente" type="text" name="cnpj"
		value="{{ old('cnpj') }}"
		/>
		<div class="invalid-feedback">
            Informe o CNPJ do cliente.
        </div>
{{-- campo email do cliente --}}
		<div class="mb-3">
		<label class="form-label" for="email_cliente">Email</label>
		<input class="form-control" required placeholder="Email do cliente" id="email_cliente" type="text" name="email"
		value="{{ old('email') }}"
		/>
		<div class="invalid-feedback">
            Informe o email do cliente.
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