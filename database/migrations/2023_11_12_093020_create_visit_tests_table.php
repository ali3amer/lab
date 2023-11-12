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
        Schema::create('visit_tests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('visit_id')->nullable();
            $table->foreign('visit_id')->references('id')->on('visits')->onDelete("cascade");
            $table->unsignedBigInteger('visit_test_id')->nullable();
            $table->foreign('visit_test_id')->references('id')->on('visit_tests')->onDelete("cascade");
            $table->unsignedBigInteger('test_id');
            $table->foreign('test_id')->references('id')->on('tests');
            $table->decimal("price", 10, 2)->nullable();
            $table->string("comment")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_tests');
    }
};
