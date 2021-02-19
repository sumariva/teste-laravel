
        @foreach ($estados as $estado)
        
		<option {{ $estado->id === $selected ? 'selected="selected"' : '' }} value="{{ $estado->id }}">
            {{ $estado->nome }}
        </option>
		
		@endforeach
