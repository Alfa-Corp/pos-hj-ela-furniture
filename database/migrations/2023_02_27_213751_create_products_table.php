<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_of_measurement_id');
            $table->string('barcode')->unique();
            $table->string('title');
            $table->text('description');
            $table->bigInteger('buy_price');
            $table->bigInteger('sell_price_reseller');
            $table->bigInteger('sell_price_umum');
            $table->bigInteger('stock');
            $table->bigInteger('stock_minimal');
            $table->boolean('is_favorite');
            $table->timestamps();

            //relationship categories
            $table->foreign('unit_of_measurement_id')->references('id')->on('unit_of_measurements');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};