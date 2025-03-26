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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->mediumText('title_vn')->nullable()->default('')->comment('Project name Vietnamese');
            $table->mediumText('title_en')->nullable()->default('')->comment('Project name English');
            $table->mediumText('description_vn')->nullable()->default('')->comment('Project description Vietnamese');
            $table->mediumText('description_en')->nullable()->default('')->comment('Project description English');
            $table->string('address_vn', 200)->nullable()->default('')->comment('Project address Vietnamese');
            $table->string('address_en', 200)->nullable()->default('')->comment('Project address English');
            $table->string('investor_vn', 200)->nullable()->default('')->comment('Investor name Vietnamese');
            $table->string('investor_en', 200)->nullable()->default('')->comment('Investor name English');
            $table->string('main_contractor_vn', 500)->nullable()->default('')->comment('Main contractor name Vietnamese');
            $table->string('main_contractor_en', 500)->nullable()->default('')->comment('Main contractor name English');
            $table->integer('status')->nullable()->default(0)->comment('0: not started, 1: in progress, 2: completed');
            $table->bigInteger('area')->comment('Project area (m2)');
            $table->integer('duration')->comment('Project duration (months)');
            $table->dateTime('start_date')->comment('Project start date');
            $table->integer('priority')->nullable()->default(0)->comment('0: normal, 1: high');
            $table->boolean('is_show')->nullable()->default(true)->comment('0: hide, 1: show');
            $table->unsignedBigInteger('created_by')->nullable()->comment('User ID created');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('User ID updated');
            $table->unsignedBigInteger('project_type_id')->comment('Project type ID');
            $table->softDeletes(); // add column deleted_at to table
            $table->timestamps();

            // Foreign key
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('project_type_id')->references('id')->on('project_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
