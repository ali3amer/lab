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
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('visit_test_id');
            $table->foreign('visit_test_id')->references('id')->on('visit_tests')->onDelete('cascade')->onUpdate('cascade');
            $table->string("result")->nullable();
            $table->unsignedBigInteger('result_choice')->nullable();
            $table->foreign('result_choice')->references('id')->on('range_choices')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('test_id');
            $table->foreign('test_id')->references('id')->on('tests')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal("price", 10, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
