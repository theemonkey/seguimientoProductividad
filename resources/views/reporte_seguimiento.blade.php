@extends('layout/plantilla')

@section('tituloPagina', 'Prueba')

@section('contenido')


<div class="max-w-6xl mx-auto p-4">

    <div class="bg-white shadow-xl rounded-xl overflow-hidden border border-gray-200">

        <div class="px-3 py-3 border-b border-gray-200 bg-gray-50 flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-lg font-black text-gray-800 uppercase tracking-wide">Reporte de Rendimiento Semanal</h2>
                <p class="text-sm text-gray-500">Semana 52</p>
            </div>

            <div class="flex gap-2">
                <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 shadow-sm">Exportar</button>
                <select class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm text-gray-700 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option>Todas las Operaciones</option>
                    <option>OP-105 (Cuellos)</option>
                    <option>OP-102 (Puños)</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-ls border-b-2 border-gray-300">
                    <tr>
                        <th class="px-6 py-3 text-center border-r">Operario</th>
                        <th class="px-6 py-3 text-center border-r">Opereración</th>
                        <th class="px-6 py-3 text-center border-r">Cantidad Prendas</th>
                        <th class="px-6 py-3 text-center border-r">Meta Esperada</th>
                        <th class="px-6 py-3 text-center border-r">Cumplimiento</th>
                        <th class="px-6 py-3 text-center border-r">Eficiencia Promedio</th>
                        <th class="px-6 py-3 text-center">Estado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr>
                        <td class="px-6 py-4 text-black">
                            <div class="flex items-center gap-1">
                                <div>
                                    <div class="text-black text-center">Juan Pérez</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-2 text-center">Confección cuello</td>
                        <td class="px-6 py-2 text-center">450</td>
                        <td class="px-6 py-2 text-center">400</td>
                        <td class="px-6 py-2 text-center">92%</td>
                        <td class="px-6 py-2 text-center">
                            <div class="flex flex-col items-center">
                                <span class="font-black text-green-600">92%</span>
                            </div>
                        </td>
                        <td class="px-6 py-2 text-center">
                            <span class="items-center gap-1 px-2.5 py-0.5 rounded-full font-medium">
                                <span class="w-1.5 h-1.5"></span> Excelente
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td class="px-6 py-4 text-black">
                            <div class="flex items-center gap-1">
                                <div>
                                    <div class="text-black text-center">María Lopez</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-2 text-center">Terminado camisa</td>
                        <td class="px-6 py-2 text-center">380</td>
                        <td class="px-6 py-2 text-center">400</td>
                        <td class="px-6 py-2 text-center">85%</td>
                        <td class="px-6 py-2 text-center">
                            <div class="flex flex-col items-center">
                                <span class="font-black text-yellow-600">85%</span>
                            </div>
                        </td>
                        <td class="px-6 py-2 text-center">
                            <span class="items-center gap-1 px-2.5 py-0.5 rounded-full font-medium">
                                <span class="w-1.5 h-1.5"></span> Bueno
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td class="px-6 py-4 text-black">
                            <div class="flex items-center gap-1">
                                <div>
                                    <div class="text-black text-center">Carlos Mendoza</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-2 text-center">Recorte tela</td>
                        <td class="px-6 py-2 text-center">200</td>
                        <td class="px-6 py-2 text-center">400</td>
                        <td class="px-6 py-2 text-center">45%</td>
                        <td class="px-6 py-2 text-center">
                            <div class="flex flex-col items-center">
                                <span class="font-black text-red-600">45%</span>
                            </div>
                        </td>
                        <td class="px-6 py-2 text-center">
                            <span class="items-center gap-1 px-2.5 py-0.5 rounded-full font-medium">
                                <span class="w-1.5 h-1.5"></span> Critico
                            </span>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection
