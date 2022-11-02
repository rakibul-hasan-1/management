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
        Schema::create('variants', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('color_code')->unique()->nullable();
            $table->biginteger('volume');
            $table->biginteger('cartoon');
            $table->double('price');
            $table->unsignedBigInteger('rack_id');
            $table->timestamps();
            $table->foreign('rack_id')->references('id')->on('racks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('variants');
    }
};
