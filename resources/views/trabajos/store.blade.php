@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{auth()->user()->nombre}} {{auth()->user()->apellido}} <br/>
                    DNI: {{auth()->user()->dni}}
                    Su trabajo a sido almacenado, guarde este documento como referencia: 
                    <div class="alert-info">
                        Trabajo: {{$trabajo->ID_TRABAJO}}<br/>
                        Título: {{$trabajo->titulo}}<br/>
                        Tutor: {{$trabajo->tutor}}<br/>
                        Ciclo: {{$trabajo->ciclo}}<br/>
                        Curso: {{$trabajo->curso}}<br/>
                        Fecha de entrega: {{$trabajo->entrega}}<br/>
                      
                    </div>
                    
                   
                    
              
                            
                            
                        </tbody>
                    </table> 
                    <a href="{{route('home')}}" class='btn btn-lg btn-info'>Volver</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
