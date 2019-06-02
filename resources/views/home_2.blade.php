@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><p>Bienvenido  {{auth()->user()->nombre}}  {{auth()->user()->apellido}}</p></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <br/>
                    You are logged in!<br/>
                   
                        
                    <div class="btn-group">
                    
                        <button class="btn btn-lg btn-info">Usuarios<span class="caret"></span></button>
                   
                    
                        
                        <a href="{{route('register')}}" class='btn btn-lg btn-info'>Nuevos Usuarios<span class="glyphicon glyphicon-paperclip"></span></a>
                        <a href="{{route('usuarios')}}" class='btn btn-lg btn-info'>Consulta de Usuarios<span class="glyphicon glyphicon-paperclip"></span></a>                        <a href="{{route('consulta')}}" class='btn btn-lg btn-info'>Consulta TFCs<span class="glyphicon glyphicon-list-alt"></span></a>
                        <a href="{{route('consulta')}}" class='btn btn-lg btn-info'>Buscar TFCs<span class="glyphicon glyphicon-searh"></span></a>
                        <a href="{{route('logout')}}" class='btn btn-lg btn-info'>Salir<span class="glyphicon glyphicon-home"></span></a>
                    </div>
                </div>
                
                     <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Usuarios deplegable
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a href="{{route('register')}}" class=' dropdown-item'>Nuevos Usuarios<span class="glyphicon glyphicon-paperclip"></span></a>
                        <a href="{{route('usuarios')}}" class='dropdown-item'>Consulta de Usuarios<span class="glyphicon glyphicon-paperclip"></span></a> 
                      <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                  </div>
            </div>
        </div>
    </div>
</div>
@endsection
