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
        Schema::create('infrastructure_requests_history', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('infra_request_id');
            $table->bigInteger('user_id')->constrained();
            $table->json('details');
            $table->timestamps();

            // Foreign key constraints
            // $table->foreignUuid('admin_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infrastructure_requests_history');
    }
};
