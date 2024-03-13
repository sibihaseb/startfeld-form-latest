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
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->string('token');
            $table->string('surname');
            $table->string('firstname');
            $table->string('address');
            $table->string('zip');
            $table->string('city');
            $table->string('email');
            $table->string('title')->nullable();
            $table->string('phone');
            $table->string('training')->nullable();
            $table->enum('current_status', ['employed', 'self-employed', 'unemployed', 'other']);
            $table->string('current_status_other')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
