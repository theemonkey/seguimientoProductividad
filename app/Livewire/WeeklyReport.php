<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SeguimientoPersonalizado;

class WeeklyReport extends Component
{
    public $selectedOperation = 'all';
    public $weekNumber = 52;

    public function render()
    {
        $reports = SeguimientoPersonalizado::query()
            ->when($this->selectedOperation !== 'all', function($query) {
                $query->where('operation_code', $this->selectedOperation);
            })
            ->get()
            ->map(function($record) {
                return [
                    'operator_name' => $record->operator_name,
                    'operation_code' => $record->operation_code,
                    'units_achieved' => $record->units_achieved,
                    'base_goal' => $record->base_goal,
                    'efficiency' => $record->efficiency,
                    'completion' => ($record->units_achieved / $record->base_goal) * 100,
                ];
            });

        return view('livewire.weekly-report', ['reports' => $reports]);
    }
}
