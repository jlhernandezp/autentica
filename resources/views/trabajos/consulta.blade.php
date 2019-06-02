@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('trabajos.busqueda')
            <div class="card">
                <div class="page-header"><h2>{{auth()->user()->nombre}} {{auth()->user()->apellido}} <br/>
                    DNI: {{auth()->user()->dni}}</h2></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    
                    
                    <table class="table table-bordered">
                        <thead>
                            
                            <th>ID</th>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Tutor</th>
                            <th>Ciclo</th>
                            <th>Curso</th>
                            <th>Nota</th>
                            <th>Depósito</th>
                            <th>Defensa</th>
                            <th>Descarga</th>
                            <th>Archivo</th>
                            
                        </thead>
                        <tbody>
                            @foreach ($trabajos as $trabajo)
                            <tr>
                                <td>{{$trabajo->ID_TRABAJO}}</td>
                                <td>{{$trabajo->titulo}}</td>
                                <td>{{$trabajo->apellido}} {{$trabajo->nombre}}</td>
                                <td>{{$trabajo->tutor}}</td>
                                <td>{{$trabajo->ciclo}}</td>
                                <td>{{$trabajo->curso}}</td>
                                <td>{{$trabajo->nota}}</td>
                                <td>{{$trabajo->entrega}}</td>
                                <td>{{$trabajo->defensa}}</td>
                                <td>{{$trabajo->archivo}}</td>

                                @if (auth()->user()->rol!=0)
                                
                                    <td><a href="/trabajos/eliminar/{{$trabajo->ID_TRABAJO}}" class="btn btn-info">Borrar</a></td>
                                @endif
                                <td><a href="/trabajos/consulta/{{$trabajo->ciclo}}/{{$trabajo->curso}}/{{$trabajo->archivo}}" class="btn btn-info">Descargar</a></td>
                                
                            </tr>
                            @endforeach
                            
                            
                        </tbody>
                    </table>
                    <div class="card-group  justify-content-between align-items-center">
                        <div class="btn-group">
                            <a href="{{route('home')}}" class='btn btn-lg btn-info'>Volver</a>
                            <a href="{{route('logout')}}" class='btn btn-lg btn-info'>Salir</a>
                        </div>
                        {{$trabajos->render()}} 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
