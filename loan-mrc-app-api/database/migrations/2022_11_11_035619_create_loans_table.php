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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->string('borrower');
            $table->string('necessity');
            $table->date('loan_date');
            $table->date('loan_duration');
            $table->string('return_goods')->default('belum');
            $table->date('return_date')->nullable();
            $table->string('receiver')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loans');
    }
};
