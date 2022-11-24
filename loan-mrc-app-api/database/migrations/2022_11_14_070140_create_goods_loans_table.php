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
        Schema::create('goods_loans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loan_id');
            $table->unsignedBigInteger('goods_id')->nullable();
            $table->string('goods_name');
            $table->string('goods_type')->nullable();
            $table->integer('quantity')->nullable();
            
            
            $table->foreign('loan_id')->references('id')->on('loans')->onDelete('cascade');
            $table->foreign('goods_id')->references('id')->on('goods')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods_loans');
    }
};
