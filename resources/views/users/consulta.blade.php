@extends('layouts.app')

@section('content')



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('users.busqueda')
           
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
                            
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>DNI</th>
                            <th>Expediente</th>
                            <th>Email</th>
                            <th>Rol</th>
                            
                        </thead>
                        <tbody>
                            @foreach ($usuarios as $usuario)
                            <tr>
                                <td>{{$usuario->nombre}}</td>
                                <td>{{$usuario->apellido}}</td>
                                <td>{{$usuario->dni}}</td>
                                <td>{{$usuario->expediente}}</td>
                                <td>{{$usuario->email}}</td>
                                <td>
                                    @if ($usuario->rol == 0){{'alumno'}}
                                        @elseif ($usuario->rol == 1){{'tutor'}}
                                        @elseif ($usuario->rol==2){{'administrador'}}
                                    @endif
                                </td>
                                <td><a href="infoUsuario/{{$usuario->dni}}" class="btn btn-info">Borrar</a></td>
                                <td><a href="/usuarios/consulta/{{$usuario->dni}}" class="btn btn-info">Modificar</a></td>
                                
                            </tr>
                            @endforeach
                            
                            
                        </tbody>
                    </table>
                    
                </div>
                <div class="card-group  justify-content-between align-items-center">
                
                
                    <div class="btn-group align-items-center">
                        <a href="{{route('home')}}" class='btn btn-md btn-info'>Volver</a>
                        <a href="{{route('logout')}}" class='btn btn-md btn-info'>Salir</a>
                    </div>
                     {{$usuarios->render()}}   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
