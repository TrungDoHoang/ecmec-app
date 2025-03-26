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
        Schema::table('users', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('img_id')->nullable()->comment('Image ID');
            $table->string('phone', 12)->nullable()->comment('Phone number');
            $table->softDeletes(); // add column deleted_at to table

            // Foreign key
            $table->foreign('img_id')->references('id')->on('images')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
