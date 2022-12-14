<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id');
            $table->string('primary_color')->nullable();
            $table->string('secondary_color')->nullable();
            $table->string('text_color')->nullable();
            $table->string('background_image')->nullable();
            $table->string('fav_icon')->nullable();
            $table->string('googleApiKey')->nullable();
            $table->string('paypalApiKey')->nullable();
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
        Schema::dropIfExists('store_settings');
    }
}
