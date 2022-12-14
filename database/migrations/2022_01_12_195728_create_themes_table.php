<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('store_id')->nullable();
            $table->string('information_class_background')->nullable();
            $table->string('information_class_color')->nullable();
            $table->string('info_product_class_background')->nullable();
            $table->string('info_product_class_color')->nullable();
            $table->string('background_image')->nullable();
            $table->string('intro_image')->nullable();
            $table->string('primary_color')->nullable();
            $table->string('secondary_color')->nullable();
            $table->string('price_back_color')->nullable();
            $table->string('price_font_color')->nullable();
            $table->string('font_color')->nullable();
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
        Schema::dropIfExists('themes');
    }
}
