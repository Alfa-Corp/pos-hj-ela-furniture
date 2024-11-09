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
        Schema::create('reseller_transaction_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reseller_transaction_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('price_per_qty');
            $table->integer('qty');
            $table->bigInteger('price');
            $table->timestamps();

            //relationship transactions
            $table->foreign('reseller_transaction_id')->references('id')->on('reseller_transactions');

            //relationship products
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reseller_transaction_details');
    }
};
