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
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("service_id");
            $table->time("scheduled")->nullable(false)->unique();
            $table->enum("status", [
                "success", "absent", "cancelled"
            ])->nullable(false);
            $table->timestamps();

            $table->foreign("user_id")->references("id")->on("users")->onUpdate("cascade")->onDelete("cascade");
            $table->foreign("service_id")->references("id")->on("services")->onUpdate("cascade")->onDelete("cascade");
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
