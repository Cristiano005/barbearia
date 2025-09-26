<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('availabilities', function (Blueprint $table) {
            // Remove a chave única antiga
            $table->dropUnique('availabilities_schedule_time_unique');

            // Adiciona chave única composta
            $table->unique(['schedule_date', 'schedule_time'], 'availabilities_date_time_unique');
        });
    }

    public function down(): void
    {
        Schema::table('availabilities', function (Blueprint $table) {
            $table->dropUnique('availabilities_date_time_unique');
            $table->unique('schedule_time'); 
        });
    }
};
