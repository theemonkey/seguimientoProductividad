<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;

class SeguimientoPersonalizado extends Model
{
    protected $table = 'seguimiento_personalizado';
    protected $guarded = [];

    protected $casts = [
        'time_logs' => 'array',  // Casteo automático a array PHP
        'date' => 'date',
    ];

    protected $fillable = [
        'operator_name',
        'operation_code',
        'model',
        'date',
        'sam',
        'base_goal',
        'units_achieved',
        'produced_minutes',
        'worked_minutes',
        'time_logs',
        'efficiency',
        'status'
    ];

    /**
     * Calcula y actualiza la eficiencia basada en los logs actuales
     */
    public function calculateEfficiency()
    {
        if ($this->units_achieved == 0 || empty($this->time_logs)) {
            $this->efficiency = 0;
            return;
        }

        // 1. Calcular el tiempo real invertido (sumando los rangos en el JSON)
        $totalActualMinutes = 0;
        foreach ($this->time_logs as $log) {
            if (isset($log['end'])) {
                // Asumimos que guardamos timestamps UNIX o objetos Carbon
                $start = \Carbon\Carbon::parse($log['start']);
                $end = \Carbon\Carbon::parse($log['end']);
                $totalActualMinutes += $end->diffInMinutes($start, true); // true = float
            }
        }

        // Evitar división por cero
        if ($totalActualMinutes <= 0) {
            $this->efficiency = 0;
            return;
        }

        // 2. Calcular tiempo Estándar (tardanza según SAM)
        $standardTime = $this->units_achieved * $this->sam;

        // 3. Cálculo final
        $this->efficiency = ($standardTime / $totalActualMinutes) * 100;

        $this->save();
    }
}
