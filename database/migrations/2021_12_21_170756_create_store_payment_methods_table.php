<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorePaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id');
            $table->string('title_ar')->nullable();
            $table->string('title_en')->nullable();
            $table->string('description_ar')->nullable();
            $table->string('description_en')->nullable();
            $table->string('image')->nullable();
            $table->string('account_number')->nullable();
            $table->tinyInteger('is_active')->default(1);
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
        Schema::dropIfExists('store_payment_methods');
    }
}
