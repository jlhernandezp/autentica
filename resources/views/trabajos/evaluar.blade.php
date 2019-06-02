@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
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
                        <!--    <th>Tutor</th>-->
                            <th>Ciclo</th>
                            <th>Nota</th>
                            <th>Depósito</th>
                            <th>Defensa</th>
                            <th>Descarga</th>
                            
                        </thead>
                        <tbody>
                            @foreach ($trabajos as $trabajo)
                        <form name="evaluacion" class="form-group" action="{{route('evaluar')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <tr>
                                <td><input name="id" type="hidden" value= "{{$trabajo->ID_TRABAJO}}" /></td>
                                <td>{{$trabajo->titulo}}</td>
                            <!--    <td>{{$trabajo->tutor}}</td>-->
                                <td>{{$trabajo->ciclo}}</td>
                                <td>
                                    <input name="nota" type="text" class="input-group-sm" value="{{$trabajo->nota}}" /></td>
                                <td>{{$trabajo->entrega}}</td>
                                <td> <input name="defensa" type="date" class="input-group-sm" value="{{date('Y-m-d',strtotime($trabajo->defensa))}}" /></td>
                                <td><a href="/trabajos/consulta/{{$trabajo->archivo}}" class="btn btn-info">Descargar</a></td>
                                <td><button type="submit" class="btn btn-info">Guardar</button></td>
                            </tr>
                        </form>
                            @endforeach
                            
                            
                        </tbody>
                    </table>
                    <div class="btn-group">
                        <a href="{{route('home')}}" class='btn btn-lg btn-info'>Volver</a>
                        <a href="{{route('logout')}}" class='btn btn-lg btn-info'>Salir</a>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
