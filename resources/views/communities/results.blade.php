{{-- @if ($communities == null)
    <p>No se han encontrado resultados</p>
@endif --}}
{{-- @else --}}
<p> Hello. Esta es la comunidad {{ $communities }}.  </p>
@foreach ($communities as $com)
<p>Este es el nombre: {{ $com->name }} </p>
@endforeach