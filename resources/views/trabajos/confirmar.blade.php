@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Depósito de TFCs</div>
                    <div class="card-subtitle"> 
                        Deposita: {{auth()->user()->nombre}} {{auth()->user()->apellido}} <br/>
                        DNI: {{auth()->user()->dni}}
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                  
                    
                  
                        <form name="deposito" class="form-group" action="{{route('store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label for="dni_autor" class="input-group">DNI:</label>
                            <input name="dni_autor" class="input-group" type="text"  value="{{auth()->user()->dni}}" readonly="readonly"/>
                            <label for="titulo" class="input-group">Título:</label>
                            <input name="titulo" class="input-group" type="text"  value="{{$trabajo->titulo}}" readonly="readonly"/>
                            <label for="tutor" class="input-group">Tutor:</label>
                            <input name="tutor" class="input-group" type="text" value="{{$trabajo->tutor}}" readonly="readonly"/>
                            <label for="ciclo" class="input-group">Ciclo:</label>
                            <input name="ciclo" class="input-group" type="text" value="{{$trabajo->ciclo}}" readonly="readonly"/>
                            <label for="curso" class="input-group">Curso:</label>
                            <input name="curso" class="input-group" type="text" value="{{$trabajo->curso}}" readonly="readonly"/>
                            <label for="archivo" class="input-group">Documento:</label>                    
                            <input name="archivo" class="input-group" type="text" value="{{$trabajo->fichero->getClientOriginalName()}}" readonly="readonly"/>
                            <div class="btn-group">
                               <button type="submit" class="btn btn-info">Confirmar</button> 

                               <a href="{{route('logout')}}" class='btn btn-info'>Salir</a>
                               <a href="{{route('home')}}" class='btn btn-info'>Cancelar</a>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
