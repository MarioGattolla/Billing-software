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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table-> string('business_name')->nullable();
            $table-> string('contact_name')->nullable();
            $table-> string('country');
            $table->string('address');
            $table->string('email');
            $table->string('phone');
            $table->string('vat_number')->nullable();
            $table->timestamps();
        });
    }

};
