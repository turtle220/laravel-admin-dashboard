<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscribersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstName')->nullable();
            $table->string('lastName')->nullable();
            $table->string('email');
            $table->string('zipCode')->nullable();
            $table->string('countryName')->nullable();
            $table->string('countryCode')->nullable();
            $table->string('phoneNumber')->nullable();
            $table->integer('subscribeType')->default(1);

            $table->index(['email']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscribers');
    }
}
