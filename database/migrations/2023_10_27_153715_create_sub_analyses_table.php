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
        Schema::create('sub_analyses', function (Blueprint $table) {
            $table->id();
            $table->string("subAnalysisName");
            $table->string("unit")->nullable();
            $table->unsignedBigInteger('analysis_id');
            $table->foreign('analysis_id')->references('id')->on('analyses');
            $table->decimal("price", 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_analyses');
    }
};
