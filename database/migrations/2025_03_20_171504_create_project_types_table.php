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
        Schema::create('project_types', function (Blueprint $table) {
            $table->id();
            $table->string('name_vn', 200)->nullable()->comment('Project type name Vietnamese');
            $table->string('name_en', 200)->nullable()->comment('Project type name English');
            $table->unsignedBigInteger('created_by')->nullable()->comment('User ID created');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('User ID updated');
            $table->softDeletes(); // add column deleted_at to table
            $table->timestamps();

            // Foreign key
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_types');
    }
};
