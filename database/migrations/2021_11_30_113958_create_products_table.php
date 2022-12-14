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
            $table->string('name_ar')->nullable();
            $table->string('name_en')->nullable();
            $table->double('price');
            $table->double('discount')->nullable();
            $table->enum('discount_type',['PERCENT','AMOUNT'])->default('AMOUNT');
            $table->foreignId('store_id');
            $table->foreignId('product_category_id');
            $table->tinyInteger('is_active')->default(1);
            $table->tinyInteger('is_recommended')->default(1);
            $table->text('description_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->double('cooking_time');
            $table->string('image')->nullable();
            $table->string('size')->nullable();
            $table->double('tax')->nullable();
            $table->enum('tax_type',['PERCENT','AMOUNT'])->default('AMOUNT');
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
