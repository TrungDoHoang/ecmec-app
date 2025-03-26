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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title_vn', 200)->nullable()->default('')->comment('Service name Vietnamese');
            $table->string('title_en', 200)->nullable()->default('')->comment('Service name English');
            $table->mediumText('description_vn')->nullable()->default('')->comment('Service description Vietnamese');
            $table->mediumText('description_en')->nullable()->default('')->comment('Service description English');
            $table->integer('priority')->nullable()->default(0)->comment('0: normal, 1: high');
            $table->boolean('is_show')->nullable()->default(true)->comment('0: hide, 1: show');
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
        Schema::dropIfExists('services');
    }
};
