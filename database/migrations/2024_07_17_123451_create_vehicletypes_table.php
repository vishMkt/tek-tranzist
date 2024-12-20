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
        Schema::create('vehicletypes', function (Blueprint $table) {
            $table->id();
            $table->string('vtype');
            $table->string('capacity');
            $table->string('fare');
            $table->string('pricekm');
            $table->string('pricemin');
            $table->string('taxpercetage');
            $table->string('admnicomission');
            $table->string('image_id');
            $table->tinyInteger('status');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicletypes');
    }
};
