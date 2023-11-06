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
        Schema::create('infrastructure_requests', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('infrastructure_id');
            $table->bigInteger('user_id')->constrained();
            $table->string('status_approval')->default('requested');
            $table->timestamps();

            // Foreign key constraints
            // $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infrastructure_requests');
    }
};
