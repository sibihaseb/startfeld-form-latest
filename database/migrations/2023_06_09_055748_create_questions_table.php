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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->integer('step');
            $table->integer('sort_order');
            $table->json('title');
            $table->json('description')->nullable();
            $table->enum('answer_type', ['text', 'textarea', 'radio', 'dropdown', 'checkbox', 'number', 'key', 'title', 'file', 'date']);
            $table->json('options')->nullable();
            $table->boolean('is_hidden')->default(false);
            $table->boolean('is_mandatory')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
