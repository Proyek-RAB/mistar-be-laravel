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
        Schema::create('infrastructures', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained();
            $table->string('name')->nullable();
            $table->string('type_id')->nullable();
            $table->string('type')->nullable();
            $table->unsignedInteger('sub_type_id')->nullable();
            $table->string('sub_type')->nullable();
            $table->json('image')->nullable();
            $table->string('status')->default(\App\Models\Infrastructure::STATUS_GOOD);
            $table->string('status_approval')->default("requested");
            $table->json('details')->nullable();
            $table->timestamps();

            $table->foreign('sub_type_id')->references('id')->on('infrastructure_sub_types');
            // $table->foreignUuid('fk_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infrastructures');
    }
};
