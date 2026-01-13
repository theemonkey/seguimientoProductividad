<div>
    <div class="bg-white shadow-xl rounded-xl overflow-hidden border border-gray-200">

        <div class="px-3 py-3 border-b border-gray-200 bg-gray-50 flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-sm font-bold uppercase tracking-wide">Reporte de Rendimiento Semanal</h2>
                <p class="text-sm text-gray-500">Semana {{ $weekNumber }}</p>
            </div>

            <div class="flex gap-2">
                <button wire:click="exportReport" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 shadow-sm">
                    Exportar
                </button>
                <select wire:model.live="selectedOperation" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm text-gray-700 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="all">Todas las Operaciones</option>
                    <option value="OP-001">OP-001 (Camisa Polo)</option>
                    <option value="OP-002">OP-002 (Pantalón Jean)</option>
                    <option value="OP-003">OP-003 (Blusa)</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-ls border-b-2 border-gray-300">
                    <tr>
                        <th class="px-6 py-3 text-center border-r">Operario</th>
                        <th class="px-6 py-3 text-center border-r">Operación</th>
                        <th class="px-6 py-3 text-center border-r">Cantidad Prendas</th>
                        <th class="px-6 py-3 text-center border-r">Meta Esperada</th>
                        <th class="px-6 py-3 text-center border-r">Cumplimiento</th>
                        <th class="px-6 py-3 text-center border-r">Eficiencia Promedio</th>
                        <th class="px-6 py-3 text-center">Estado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($reports as $report)
                        <tr>
                            <td class="px-6 py-4 text-black text-center">{{ $report['operator_name'] }}</td>
                            <td class="px-6 py-2 text-center">{{ $report['operation_code'] }}</td>
                            <td class="px-6 py-2 text-center">{{ $report['units_achieved'] }}</td>
                            <td class="px-6 py-2 text-center">{{ $report['base_goal'] }}</td>
                            <td class="px-6 py-2 text-center">{{ number_format($report['completion'], 0) }}%</td>
                            <td class="px-6 py-2 text-center">
                                <span class="font-black {{ $report['efficiency'] >= 90 ? 'text-green-600' : ($report['efficiency'] >= 70 ? 'text-yellow-600' : 'text-red-600') }}">
                                    {{ number_format($report['efficiency'], 0) }}%
                                </span>
                            </td>
                            <td class="px-6 py-2 text-center">
                                @if($report['efficiency'] >= 90)
                                    <span class="text-green-600">Excelente</span>
                                @elseif($report['efficiency'] >= 70)
                                    <span class="text-yellow-600">Bueno</span>
                                @else
                                    <span class="text-red-600">Crítico</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-400">No hay datos disponibles</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
