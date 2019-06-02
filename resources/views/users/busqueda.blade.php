<form id='buscar' name='buscar' class="form-group" action="{{route('usuarios')}}" method='GET'>
    <div class="input-group">
        <input type="text" name='apellido' class="form-control col-lg-8" value="" placeholder="Apellido" />
        <span class='input-group-append'>
            <button type="submit" class="btn btn-sm btn-info">Buscar<span class="glyphicon-search"></span></button>
        </span>
    </div>
</form>
