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
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_Id')->foreign('invoice_Id')->references('id')->on('invoice_master');
            $table->unsignedBigInteger('product_id')->foreign('product_id')->references('id')->on('product_master');
            $table->integer('rate')->nullable();
            $table->string('unit')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('disc_percentage')->nullable();
            $table->integer('net_amount')->nullable();
            $table->integer('total_amount')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_details');
    }
};
