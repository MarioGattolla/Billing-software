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
        Schema::create('ddt_raws', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('ddt_id')->references('id')->on('ddts');
            $table->foreignId('order_product_id')->references('id')->on('orders_products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ddt_raws');
    }
};
