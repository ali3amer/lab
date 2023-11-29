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
            $table->unsignedBigInteger('test_id');
            $table->foreign('test_id')->references('id')->on('tests')->onDelete("cascade");
            $table->enum("gender", ['all', 'male', 'female']);
            $table->enum("age", ["all", "year", "month", "day", "hour"]);
            $table->enum("result_type", ["number", "multable_choice", "text_and_multable_choice"]);
            $table->integer("min_age")->nullable();
            $table->integer("max_age")->nullable();
            $table->decimal("min_value", 10, 2)->nullable();
            $table->decimal("max_value", 10, 2)->nullable();
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
