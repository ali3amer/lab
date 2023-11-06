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
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->unsignedBigInteger('insurance_id')->nullable();
            $table->foreign('insurance_id')->references('id')->on('insurances');
            $table->string("insuranceNumber")->nullable();
            $table->decimal("amount", 10, 8)->nullable();
            $table->decimal("discount", 10, 8)->nullable();
            $table->decimal("total_amount", 10, 8)->nullable();
            $table->string("doctor")->nullable();
            $table->string("comment")->nullable();
            $table->decimal("patientEndurance", 8, 2);
            $table->date("visit_date");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
