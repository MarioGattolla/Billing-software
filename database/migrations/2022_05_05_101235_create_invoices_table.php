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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('progressive');
            $table->date('order_date');
            $table->date('invoice_date');
            $table->string('terms_conditions');
            $table->integer('total');
            $table->string('type');

        });
    }

};
