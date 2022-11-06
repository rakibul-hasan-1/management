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
        Schema::create('supplier_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->string('type');
            $table->double('total')->default(0);
            $table->double('paid')->default(0);
            $table->double('due')->default(0);
            $table->string('status')->default('Pending');
            $table->timestamps();
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supplier_transactions');
    }
};
