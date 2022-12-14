<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStoreSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('store_settings',function(Blueprint $table){
            $table->tinyInteger('is_delivery_enabled')->nullable();
            $table->tinyInteger('is_cash_enabled')->nullable();
            $table->tinyInteger('other_payment_enabled')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
