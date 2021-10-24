<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->string('price')->nullable();
            $table->string('discount')->nullable();
            $table->string('type')->nullable();
            $table->string('discription')->nullable();
            $table->boolean('isOffer')->nullable()->default(false);
            $table->bigInteger('boutique_id')->nullable()->default(12)->unsigned();
            $table->foreign('boutique_id')->references('id')->on('boutiques')->onDelete('cascade');
            $table->bigInteger('blogger_id')->nullable()->default(12)->unsigned();
            $table->foreign('blogger_id')->references('id')->on('bloggers')->onDelete('cascade');
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
        Schema::dropIfExists('products');
    }
}
