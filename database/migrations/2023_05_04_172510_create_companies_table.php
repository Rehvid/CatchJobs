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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('location_id')->nullable();
            $table->foreignId('industry_id')->nullable();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->unsignedBigInteger('vat_number')->unique();
            $table->unsignedInteger('status')->default(0);
            $table->text('description')->nullable();
            $table->string('employees')->nullable();
            $table->unsignedInteger('foundation_year')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
