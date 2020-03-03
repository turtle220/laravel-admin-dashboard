<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('previews', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('amount');
            $table->float('price');
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('websiteMessage')->nullable();
            $table->boolean('subscribe')->default(0);
            $table->boolean('anonymous')->nullable(0);
            $table->boolean('gift')->nullable(0);
            $table->string('to')->nullable();
            $table->string('from')->nullable();
            $table->string('giftMessage')->nullable();
            $table->string('currency')->nullable();
            $table->string('icon')->nullable();
            $table->string('orderID');
            $table->string('payerID');
            $table->string('facilitatorAccessToken');
            $table->string('paymentStatus');
            $table->json('fullPayment');
            $table->string('paymentMethod');

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
        Schema::dropIfExists('previews');
    }
}
