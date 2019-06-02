@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Depósito de TFCs</h2>
                    <div class="card-subtitle">
                        Deposita:
                        {{auth()->user()->nombre}} {{auth()->user()->apellido}} <br/>
                        DNI: {{auth()->user()->dni}}
                    
                    </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                </div>
                    <form name="deposito" class="form-group" action="{{route('confirmar')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <label for="titulo" class="input-group">Título:</label>
                        <input name="titulo" class="input-group" type="text" />
                        <label for="tutor" class="input-group">Tutor:</label>
                     <!--   <input name="tutor" class="input-group" type="text" />-->
                        <select name="tutor" class="input-group">
                            @foreach ($tutores as $tutor)
                                <option value="{{$tutor->nombre}} {{$tutor->apellido}}"> {{$tutor->nombre}} {{$tutor->apellido}}</option>
                            @endforeach
                        </select>
                        <label for="ciclo" class="input-group">Ciclo:</label>
                        <input name="ciclo" class="input-group" type="text" />
                        <label for="curso" class="input-group">Curso:</label>
                     <!--   <input name="curso" class="input-group" type="text" />-->
                        <select name="curso" class="input-group">
                            <option value="{{ date('Y')-1 }}{{ date('Y') }}">{{ date('Y')-1 }}/{{ date('Y') }}</option> 
                            <option value="{{ date('Y') }}{{ date('Y')+1 }}">{{ date('Y') }}/{{ date('Y')+1 }}</option> 
                        </select>
                        <label for="fichero" class="input-group">Documento:</label>
                        <input name="fichero" class="input-group" type="file" />
                        
                       <div class="btn-group"> 
                        <button type="submit" class="btn btn-info">Depositar</button> 
                        
                        <a href="{{route('logout')}}" class='btn btn-lg btn-info'>Salir</a>
                        <a href="{{route('home')}}" class='btn btn-lg btn-info'>Cancelar</a>
                    </div>
                        <!-- 
                        Estudiar la posibilidad de cambiar la propiedad readonly
                        de los input con jscript para evitar la vista 
                        confirmar.blade.php
                        -->
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
