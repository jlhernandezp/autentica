{!! Form::open(array('url'=>'users/consulta', 'method'=>'GET', 'autocomplete'=>off,'role'=>'search'))!!}

    <div class="input-group">
        <input type="text" name='apellido' class="form-control col-lg-8" value="" placeholder="Buscar" />
        <span class='input-group'>
            <button type="submit" class="btn btn-lg btn-info">Buscar<span class="glyphicon-search"></span></button>
        </span>
    </div>

{{Form::close()}}