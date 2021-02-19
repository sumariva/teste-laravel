@extends('layouts.app')
@section('title', 'Cadastro de Empresa')
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
        <div class="container-sm">
		<form class="needs-validation g-3" novalidate method="post" action="
		@if ($empresa) 
		  {{ route('empresa.update', $empresa) }}
		@else
		  {{ route('empresa.store') }}
		@endif
		">
		@csrf
		@isset($empresa)
		@method('PUT')
		@endisset
		<div class="mb-3">
		<label class="form-label" for="razao_social">Raz&atilde;o Social</label>
		<input class="form-control" value="{{ old('razao_social') ?? ( is_object( $empresa ) ? $empresa->razao_social : '' ) }}" required placeholder="Nome da empresa LTDA ou EIRELI" id="razao_social" type="text" name="razao_social"/>
		<div class="invalid-feedback">
            Informe a Razão Social.
        </div>
		</div>
		<div class="mb-3">
		<label class="form-label" for="cnpj">CNPJ</label>
		<input class="form-control" value="{{ old('cnpj') ?? ( is_object( $empresa ) ? $empresa->cnpj : '' ) }}" required placeholder="000.000.00/0001-10" id="cnpj" type="text" name="cnpj"/>
		<div class="invalid-feedback">
            Informe um CNPJ.
        </div>
		</div>
		<label class="form-label" for="uf">Estado</label>
		<select class="form-select form-select-lg" id="uf" name="uf" required>
		  <option selected disabled value="-1">Escolher...</option>
		@if ($empresa)
		  @include('ufCombo', ['estados' => $listaUf, 'selected' => $empresa->uf ])
		@else
		  @include('ufCombo', ['estados' => $listaUf, 'selected' => old('uf') ])
		@endif
		</select>
		<div class="invalid-feedback">
          Selecione uma sigla de Estado na lista
        </div>
		@if ($empresa)
		<input class="btn btn-primary" type="submit" value="Editar">
		@else
		<input class="btn btn-primary" type="submit" value="Adicionar">
		@endif
		</form>
		</div>
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
})()
@endpush