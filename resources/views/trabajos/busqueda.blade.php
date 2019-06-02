<!--Módulo de búsquda de trabajos por título. -->
<form id='buscar' name='buscar' class="form-group" action="{{route('consulta')}}" method='GET'>
    <div class="input-group">
        <input type="text" name='titulo' class="form-control col-lg-8" value="" placeholder="Título" />
        <span class='input-group-append'>
            <button type="submit" class="btn btn-sm btn-info">Buscar<span class="glyphicon-search"></span></button>
        </span>
    </div>
</form>
