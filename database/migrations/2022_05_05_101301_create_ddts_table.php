<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ddts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('progressive');
            $table->date('date');
            $table->string('causal');
            $table->string('type');
            $table->integer('year');
            $table->unique(['progressive', 'type', 'year']);
        });
    }
};
