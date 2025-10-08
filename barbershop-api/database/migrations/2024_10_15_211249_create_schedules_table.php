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
            $table->unsignedBigInteger("payment_id");
            $table->date("date")->nullable(false);
            $table->time("time")->nullable(false);
            $table->string("status", 20)->nullable(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("service_id")->references("id")->on("services");
            $table->foreign("payment_id")->references("id")->on("payment_types");
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
