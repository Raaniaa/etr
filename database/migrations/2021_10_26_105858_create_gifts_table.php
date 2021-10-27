<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gifts', function (Blueprint $table) {
            $table->id();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->string('message')->nullable();
            $table->string('quantity')->nullable();
            $table->string('address')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('price')->nullable();
            $table->bigInteger('box_id')->nullable()->default(12)->unsigned();
            $table->foreign('box_id')->references('id')->on('boxes')->onDelete('cascade');
            $table->bigInteger('product_id')->nullable()->default(12)->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->bigInteger('extra_id')->nullable()->default(12)->unsigned();
            $table->foreign('extra_id')->references('id')->on('extras')->onDelete('cascade');
            $table->bigInteger('user_id')->nullable()->default(12)->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('gifts');
    }
}
