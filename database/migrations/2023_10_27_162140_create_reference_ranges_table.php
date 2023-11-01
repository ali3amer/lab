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
        Schema::create('reference_ranges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sub_analysis_id');
            $table->foreign('sub_analysis_id')->references('id')->on('sub_analyses');
            $table->enum("gender", ['all', 'male', 'female']);
            $table->enum("age", ["all", "years", "months", "days", "hours"])->nullable();
            $table->enum("result_types", ["text_and_multable_choice", "multable_choice", "number", "text"]);
            $table->integer("age_from")->nullable();
            $table->integer("age_to")->nullable();
            $table->decimal("range_from", 10, 2)->nullable();
            $table->decimal("range_to", 10, 2)->nullable();
            $table->json("result_multable_choice")->nullable();
            $table->string("result_text")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reference_ranges');
    }
};
