<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('model', 45);
            $table->string('code', 45)->nullable();
            $table->text('description')->nullable();
            $table->double('price');
            $table->double('discount')->nullable();
            $table->integer('stock')->nullable();
            $table->string('photo')->nullable();
            $table->boolean('is_gift')->default(false)->nullable();
            $table->boolean('is_sale')->default(false)->nullable();
            $table->boolean('is_archive')->nullable();
            $table->integer('vendor_id')->default(1);
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
