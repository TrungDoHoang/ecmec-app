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
        Schema::create('recruiment_posts', function (Blueprint $table) {
            $table->id();
            $table->mediumText('title_vn')->nullable()->default('')->comment('Title of post in Vietnamese');
            $table->mediumText('title_en')->nullable()->default('')->comment('Title of post in English');
            $table->mediumText('content_vn')->nullable()->default('')->comment('Content of post in Vietnamese');
            $table->mediumText('content_en')->nullable()->default('')->comment('Content of post in English');
            $table->mediumText(('address_vn'))->nullable()->default('')->comment('Address of post in Vietnamese');
            $table->mediumText(('address_en'))->nullable()->default('')->comment('Address of post in English');
            $table->bigInteger('salary')->nullable()->comment('Salary of post');
            $table->boolean('is_show')->nullable()->default(true)->comment('0: hide, 1: show');
            $table->integer('priority')->nullable()->default(0)->comment('0: normal, 1: high');
            $table->boolean('is_delete')->nullable()->default(false)->comment('0: not delete, 1: delete');
            $table->unsignedBigInteger('created_by')->nullable()->comment('User ID created');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('User ID updated');
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
        Schema::dropIfExists('recruiment_posts');
    }
};
