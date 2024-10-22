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
        Schema::create('text_ranges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('age_gender_group_id');
            $table->foreign('age_gender_group_id')->references('id')->on('age_gender_groups')->onDelete('cascade')->onUpdate('cascade');
            $table->string("text");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('text_ranges');
    }
};
