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
        Schema::create('generate_histories', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('user_ip_address');
            $table->foreignUuid('cv_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('analysis_type');
            $table->string('job_position')->nullable();
            $table->text('job_description')->nullable();
            $table->json('result');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generate_histories');
    }
};
