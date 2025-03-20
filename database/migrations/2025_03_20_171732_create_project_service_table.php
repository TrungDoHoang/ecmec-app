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
        Schema::create('project_service', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id')->comment('Project ID');
            $table->unsignedBigInteger('service_id')->comment('Service ID');
            $table->timestamps();

            // Foreign key
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_service');
    }
};
