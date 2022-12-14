<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar')->nullable();
            $table->string('name_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->foreignId('plan_id')->nullable();
            $table->date('sub_end')->nullable();
            $table->string('logo')->nullable();
            $table->double('latitude')->nullable();
            $table->double('longtude')->nullable();
            $table->text('address_ar')->nullable();
            $table->text('address_en')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->integer('max_branches')->default(0);
            $table->unsignedBigInteger('admin_id');
            $table->foreignId('currency_id');
            $table->string('lang_code')->nullable();
            $table->integer('delivery_distance')->nullable();
            $table->double('delivery_fees')->nullable();
            $table->string('tax_note')->nullable();
            $table->foreignId('country_code_id')->nullable();
            $table->string('email')->nullable();
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
        Schema::dropIfExists('stores');
    }
}
