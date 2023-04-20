<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * first name last name email mobile address country city state zipcode 
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('checkout', function (Blueprint $table) {
           $table->id();
    $table->string('first_name');
    $table->string('last_name');
    $table->string('email');
    $table->string('phone', 20); // Add a phone column with a maximum length of 20
    $table->string('address');
    $table->string('country');
    $table->string('city');
    $table->string('state');
    $table->integer('zipcode');
    // foreign key card id
    $table->integer('cart_id')->unsigned();
    $table->foreign('cart_id')->references('id')->on('cart');
    $table->integer('user_id')->unsigned();
    $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkout');
    }
};
