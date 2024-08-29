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
        Schema::create('range_choices', function (Blueprint $table) {
            $table->id();
            $table->string("choiceName");
            $table->boolean("default")->default(false);
            $table->unsignedBigInteger('choice_id')->nullable();
            $table->foreign('choice_id')->references('id')->on('range_choices')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('range_id')->nullable();
            $table->foreign('range_id')->references('id')->on('reference_ranges')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('range_choices');
    }
};
