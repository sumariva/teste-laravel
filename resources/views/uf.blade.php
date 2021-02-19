<html>
    <body>
        <h1>Lista de Uf</h1>
        <table>
          <th>Id</th>
          <th>Nome</th>
        @foreach ($estados as $estado)
          <tr>
    		<td>{{ $estado->id }}</td>
    		<td>{{ $estado->nome }}</td>
    	  </tr>
		@endforeach
		</table>
    </body>
</html>