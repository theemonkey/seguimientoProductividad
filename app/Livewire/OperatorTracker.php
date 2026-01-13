<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SeguimientoPersonalizado;
use Carbon\Carbon;

class OperatorTracker extends Component
{
    public $logId; // ID del registro en base de datos
    public $isWorking = false; // Estado del cronómetro
    public $currentLogIndex = null; // Indice del array JSON actual

    // Datos visuales
    public $operatorName;
    public $operationCode;
    public $model;
    public $date;
    public $sam;
    public $baseGoal;

    // Contadores
    public $unitsAchieved = 0;
    public $efficiency = 0;

    // Historial para la tabla
    public $historyLogs = [];

    public function mount($logId)
    {
        $this->logId = $logId;
        $this->refreshData();
    }

    public function refreshData()
    {
        $record = SeguimientoPersonalizado::findOrFail($this->logId);

        // 1. Mapear datos estáticos
        $this->operatorName = $record->operator_name;
        $this->operationCode = $record->operation_code;
        $this->model = $record->model;
        $this->date = \Carbon\Carbon::parse($record->date)->format('d/m/Y');
        $this->sam = $record->sam;
        $this->baseGoal = $record->base_goal;

        // 2. Mapear datos dinámicos
        $this->unitsAchieved = $record->units_achieved;
        $this->efficiency = $record->efficiency;

        // 3. Cargar historial de logs (invertido para mostrar el más reciente primero)
        $logs = $record->time_logs ?? [];
        $this->historyLogs = collect($logs)->reverse()->toArray();

        // 4. Verificar si hay una tarea abierta (Sin fecha de fin)
        if (!empty($logs)) {
            $lastLog = end($logs);
            // Obtener la última clave del array original
            $lastKey = key($logs);

            if (!isset($lastLog['end'])) {
                $this->isWorking = true;
                $this->currentLogIndex = $lastKey;
            } else {
                $this->isWorking = false;
                $this->currentLogIndex = null;
            }
        }
    }

    public function startProcess()
    {
        $record = SeguimientoPersonalizado::findOrFail($this->logId);
        $logs = $record->time_logs ?? [];

        // Nuevo registro de tiempo
        $logs[] = [
            'start' => Carbon::now()->toDateTimeString(),
            // 'end' se queda vacío hasta terminar
        ];

        $record->time_logs = $logs;
        $record->status = 'running'; // Opcional: actualizar estado
        $record->save();

        $this->isWorking = true;
        $this->currentLogIndex = count($logs) - 1;

        // Refrescar la tabla visualmente
        $this->refreshData();
    }

    public function finishProcess()
    {
        $record = SeguimientoPersonalizado::findOrFail($this->logId);
        $logs = $record->time_logs;

        if ($this->currentLogIndex !== null && isset($logs[$this->currentLogIndex])) {

            // 1. Definir tiempos
            $now = Carbon::now();
            $startTime = Carbon::parse($logs[$this->currentLogIndex]['start']);

            // Cerramos el log en el array
            $logs[$this->currentLogIndex]['end'] = $now->toDateTimeString();

            // 2. Calculo de tiempo duración de prenda (en minutos)
            $durationMinutes = $now->floatDiffInMinutes($startTime);

            // 3. Actualizar contadores del registro (DB)
            $record->time_logs = $logs;
            $record->units_achieved += 1;
            $record->worked_minutes += $durationMinutes;  //Suma del acumulado semanal
            $record->produced_minutes = $record->units_achieved * $record->sam; //Recalcular produccion total

            // 4. Guardar y recalcular eficiencia (método del modelo)
            if ($record->worked_minutes > 0) {
                $record->efficiency = ($record->produced_minutes / $record->worked_minutes) * 100;
            } else {
                $record->efficiency = 0;
            }

            $record->status = 'paused'; // esperando siguiente prenda
            $record->save();

            // 5. Actualizar vista
            //$this->isWorking = false;
            $this->refreshData();
        }
    }

    public function render()
    {
        return view('livewire.operator-tracker');
    }
}
