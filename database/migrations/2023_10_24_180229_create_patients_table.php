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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('patientName');
            $table->decimal('age', '8', '2');
            $table->enum('gender', ['male', 'female']);
            $table->enum('duration', ['years', 'months', 'weeks', 'days', 'hours']);
            $table->integer('phone');
            $table->date('firstVisitDate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
