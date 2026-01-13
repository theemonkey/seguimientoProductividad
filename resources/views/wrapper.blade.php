@extends('layout/plantilla')

@section('tituloPagina', 'Seguimiento de Operario')

@section('contenido')
    <div class="max-w-7xl mx-auto p-4">
        @livewire('operator-tracker', ['logId' => $logId])
    </div>
@endsection
