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
        Schema::create('choice_ranges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('age_gender_group_id')->nullable();
            $table->foreign('age_gender_group_id')->references('id')->on('age_gender_groups')->onDelete('cascade')->onUpdate('cascade');
            $table->string("choiceName");
            $table->boolean("default")->default(false);
            $table->unsignedBigInteger('choice_range_id')->nullable();
            $table->foreign('choice_range_id')->references('id')->on('choice_ranges')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('choice_ranges');
    }
};
