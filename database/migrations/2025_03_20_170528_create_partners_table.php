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
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('title_vn', 100)->nullable()->comment('Title in Vietnamese');
            $table->string('title_en', 100)->nullable()->comment('Title in English');
            $table->boolean('is_show')->default(true)->nullable()->comment('0: hide, 1: show');
            $table->boolean('is_delete')->default(false)->nullable()->comment('0: not delete, 1: delete');
            $table->integer('priority')->default(0)->nullable()->comment('0: normal, 1: high');
            $table->unsignedBigInteger('created_by')->nullable()->comment('User ID created');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('User ID updated');
            $table->unsignedBigInteger('img_id')->comment('Image ID');
            $table->timestamps();

            // Foreign key
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('img_id')->references('id')->on('images')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
