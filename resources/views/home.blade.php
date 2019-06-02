@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><p>Bienvenido  {{auth()->user()->nombre}} {{auth()->user()->apellido}}</p></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <br/>
                    You are logged in!<br/>
                    <div class="btn-group">
                        <a href="{{route('depositar')}}" class='btn btn-lg btn-info'>Depósito <span class="glyphicon glyphicon-paperclip"></span></a>
                        <a href="{{route('consulta')}}" class='btn btn-lg btn-info'>Consulta <span class="glyphicon glyphicon-list-alt"></span></a>
                        <a href="{{route('logout')}}" class='btn btn-lg btn-info'>Salir<span class="glyphicon glyphicon-home"></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
