<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {

            $table->id();
            $table->unsignedSmallInteger("customer_id");
            $table->unsignedSmallInteger("service_id");
            $table->time("scheduled")->nullable(false);
            $table->enum("status", [
                "finished", "absent", "cancelled"
            ])->nullable(false)->unique();
            $table->timestamps();

            $table->foreign("customer_id")->references("id")->on("customers")->onUpdate("cascade")->onDelete("cascade");
            $table->foreign("service_id")->references("id")->on("services")->onUpdate("cascade")->onDelete("cascade");
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
