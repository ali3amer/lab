<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->string("testName");
            $table->string("shortcut")->nullable();
            $table->decimal("price", 10, 2)->default(0);
            $table->string("unit")->nullable();
            $table->enum("result_type", ["number", "text", "multable_choice", "text_and_multable_choice"]);
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('test_id')->nullable();
            $table->foreign('test_id')->references('id')->on('tests')->onDelete('cascade')->onUpdate('cascade');
            $table->boolean("getAll")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tests');
    }
};
