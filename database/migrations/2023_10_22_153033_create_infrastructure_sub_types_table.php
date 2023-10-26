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
        Schema::create('infrastructure_sub_types', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('type_id')->nullable();
            $table->string('name');
            $table->text('icon_url')->nullable();
            $table->timestamps();

            $table->foreign('type_id')->references('id')->on('infrastructure_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infrastructure_sub_types');
    }
};
