<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('infrastructures', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedInteger('sub_type_id');
            $table->string('sub_type');
            $table->string('type');
            $table->string('image');
            $table->foreignUuid('user_id')->constrained();
            $table->string('name');
            $table->json('details');
            $table->string('status');
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
