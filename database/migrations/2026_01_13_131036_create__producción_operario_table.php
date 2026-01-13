<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('seguimiento_personalizado', function (Blueprint $table) {
            $table->id();
            // -->> 1. IDENTIFICACION <<--
            // Datos del operario y Tarea
            $table->string('operator_name')->index();
            $table->char('operation_code', 10)->index(); // Identificador operación
            $table->string('model'); // Caracteristica prenda
            $table->date('date')->index();

            // -->> 2. CONFIGURACION DE LA META <<--
            $table->decimal('sam', 8, 4); // Tiempo estándar por unidad (minutos)
            $table->integer('base_goal'); // Meta base del turno (cantidad para 100% eficiencia)

            // -->> 3. SEGUIMIENTO EN TIEMPO REAL <<--
            $table->integer('units_achieved')->default(0); // UDS seguimiento

            // Minutos producidos: (Unidades hechas * SAM)
            $table->decimal('produced_minutes', 10, 2)->default(0);

            // Minutos reales trabajados (sumatoria de intervalos de tiempo)
            $table->decimal('worked_minutes', 10, 2)->default(0);

            $table->json('time_logs')->nullable(); // Detalle exacto de tiempo (inicio, fin)

            // -->> 4. RESULTADOS Y ESTADO <<--
            $table->decimal('efficiency', 5, 2)->default(0); // Porcentaje final

            // Estado del registro para saber si está en proceso o finalizado el turno
            $table->enum('status', ['running', 'paused', 'completed'])->default('running');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('seguimiento_personalizado');
    }
};
