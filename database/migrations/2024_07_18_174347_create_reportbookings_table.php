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
        Schema::create('reportbookings', function (Blueprint $table) {
            $table->id();
            $table->string('bookingstatus');
            $table->string('source');
            $table->string('destination');
            $table->string('customer');
            $table->string('driver');
            $table->string('bookingdate');
            $table->string('distance');
            $table->string('duration');
            $table->string('paymentmode');            
            $table->string('basefare');            
            $table->string('distancefare');            
            $table->string('timefare');            
            $table->string('admincomission');            
            $table->string('driverearning');            
            $table->string('amount');                        
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportbookings');
    }
};
