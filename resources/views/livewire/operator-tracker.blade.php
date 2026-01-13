<div class="space-y-6"> <div class="max-w-6xl mx-auto bg-white shadow-xl rounded-xl overflow-hidden border border-gray-200">

        <div class="border-b mt-2 border-gray-200 bg-gray-100 px-4 py-2">
            <h2 class="text-sm font-bold uppercase">Ficha Tecnica de Seguimiento Personalizado</h2>
        </div>

        <div class="overflow-x-auto w-full">
            <table class="w-full text-ls text-left text-gray-600 min-w-[600px]">
                <thead class="text-xs text-black-500 bg-white border-b">
                    <tr>
                        <th class="px-4 py-3 border-r text-center whitespace-nowrap">Fecha</th>
                        <th class="px-4 py-3 border-r text-center whitespace-nowrap">Operario</th>
                        <th class="px-4 py-3 border-r text-center whitespace-nowrap">Modelo</th>
                        <th class="px-4 py-3 border-r text-center whitespace-nowrap">Operación</th>
                        <th class="px-4 py-3 border-r text-center whitespace-nowrap">SAM (Meta por unidad)</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Meta Turno (Base)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-4 py-3 border-r text-center whitespace-nowrap">{{ $date }}</td>
                        <td class="px-4 py-3 border-r text-center whitespace-nowrap">{{ $operatorName }}</td>
                        <td class="px-4 py-3 border-r text-center whitespace-nowrap">{{ $model }}</td>
                        <td class="px-4 py-3 border-r text-center whitespace-nowrap">{{ $operationCode }}</td>
                        <td class="px-4 py-3 border-r text-center whitespace-nowrap">{{ $sam }}</td>
                        <td class="px-4 py-3 border-r text-center whitespace-nowrap">{{ $baseGoal }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-gray-100 bg-white border-b border-gray-200">
            <div class="p-6 flex flex-col items-center justify-center">
                <p class="text-xs text-gray-400 uppercase tracking-widest mb-2">Progreso</p>
                <div class="flex items-baseline gap-1">
                    <span class="text-5xl font-black text-gray-800">{{ $unitsAchieved }}</span>
                    <span class="text-lg text-gray-400 font-medium">/ {{ $baseGoal }}</span>
                </div>
                <div class="w-32 mx-auto bg-gray-200 h-1.5 mt-2 rounded-full overflow-hidden">
                    <div class="bg-gray-800 h-full" style="width: {{ min(($unitsAchieved / ($baseGoal ?: 1)) * 100, 100) }}%"></div>
                </div>
            </div>

            <div class="p-6 flex flex-col items-center justify-center bg-gray-50/50">
                @if(!$isWorking)
                    <button wire:click="startProcess" class="w-48 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded shadow transition flex flex-col items-center justify-center gap-1 group">
                        <span class="text-lg tracking-wide">Iniciar</span>
                    </button>
                @else
                    <button wire:click="finishProcess" class="w-48 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded shadow transition flex flex-col items-center justify-center gap-1">
                        <span class="text-lg tracking-wide">Terminar</span>
                    </button>
                @endif
            </div>

            <div class="p-6 flex flex-col items-center justify-center">
                <p class="text-xs text-gray-400 uppercase tracking-widest mb-2">Eficiencia</p>
                <div class="text-5xl font-bold {{ $efficiency >= 100 ? 'text-green-600' : ($efficiency >= 80 ? 'text-yellow-600' : 'text-red-600')}}">
                    {{ number_format($efficiency, 1) }}%
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto bg-white shadow-xl rounded-xl overflow-hidden border border-gray-200">
        <div class="px-6 py-3 bg-gray-100 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-xs font-bold text-gray-700">HISTORIAL (Últimos 5 registros)</h3>
            <span class="text-[10px] md:text-xs text-gray-500">Mostrando datos en tiempo real</span>
        </div>

        <div class="overflow-x-auto w-full">
            <table class="w-full text-sm text-left text-gray-500 min-w-[600px]">
                <thead class="text-xs text-gray-700 bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 w-1/5">Número Prendas</th>
                        <th class="px-6 py-3 w-1/5">Hora Inicio</th>
                        <th class="px-6 py-3 w-1/5">Hora Fin</th>
                        <th class="px-6 py-3 w-1/5">Tiempo Real</th>
                        <th class="px-6 py-3 w-1/5 text-center">Estado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($historyLogs as $key => $log)
                        @php
                            // Calcular fechas y duración
                            $start = \Carbon\Carbon::parse($log['start']);
                            $end = isset($log['end']) ? \Carbon\Carbon::parse($log['end']) : null;

                            // Lógica del cronómetro visual
                            $duration = $end
                                ? $start->diff($end)->format('%Hh %Im %Ss')
                                : 'En proceso';
                        @endphp

                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-2 font-medium text-gray-900">
                                #{{ count($historyLogs) - $key }}
                            </td>
                            <td class="px-6 py-2">
                                {{ $start->format('g:i:s A') }}
                            </td>
                            <td class="px-6 py-2">
                                @if($end)
                                    {{ $end->format('g:i:s A') }}
                                @else
                                    <span class="text-gray-400">--:--:--</span>
                                @endif
                            </td>
                            <td class="px-6 py-2 text-gray-700">
                                {{ $duration }}
                            </td>
                            <td class="px-6 py-2 text-center">
                                @if($end)
                                    <span class="text-xs font-bold text-green-600 px-2 py-1">
                                        Completado
                                    </span>
                                @else
                                    <span class="text-xs font-bold text-blue-600 px-2 py-1">
                                        Procesando
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-400 italic">
                                No hay registros de historial disponibles.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
