@extends('layout/plantilla')

@section('tituloPagina', 'Dashboard de Seguimiento de Operarios')

@section('contenido')

<div class="max-w-7xl mx-auto p-4 space-y-6">

    {{-- Componente Livewire: Tracker del Operador --}}
    <div>
        @livewire('operator-tracker', ['logId' => 1])
    </div>

    {{-- Componente Livewire: Reporte Semanal --}}
    <div>
        @livewire('weekly-report')
    </div>

</div>

@endsection
