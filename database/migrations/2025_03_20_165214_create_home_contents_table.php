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
        Schema::create('home_contents', function (Blueprint $table) {
            $table->id();
            $table->mediumText('title_vn')->nullable()->comment('Title Vietnamese');
            $table->mediumText('title_en')->nullable()->comment('Title English');
            $table->mediumText('content_vn')->nullable()->comment('Content Vietnamese');
            $table->mediumText('content_en')->nullable()->comment('Content English');
            $table->unsignedBigInteger('created_by')->nullable()->comment('User ID created');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('User ID updated');
            $table->unsignedBigInteger('img_id')->comment('Image ID');
            $table->integer('priority')->default(0)->nullable()->comment('0: normal, 1: high');
            $table->boolean('is_show')->default(true)->nullable()->comment('0: hide, 1: show');
            $table->softDeletes(); // add column deleted_at to table
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
        Schema::dropIfExists('home_contents');
    }
};
