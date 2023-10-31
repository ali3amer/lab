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
        Schema::create('visit_analyses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('visit_id');
            $table->foreign('visit_id')->references('id')->on('visits');
            $table->unsignedBigInteger('sub_analysis_id');
            $table->foreign('sub_analysis_id')->references('id')->on('sub_analyses');
            $table->decimal("price", 10, 2);
            $table->string("result");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_analyses');
    }
};
