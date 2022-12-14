<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('plan_id');
            $table->foreignId('store_id');
            $table->foreignId('payment_method_id');
            $table->tinyInteger('status')->default(0);
            $table->string('image')->nullable();
            $table->string('payment_number')->nullable();
            $table->integer('branche_count')->default(0);
            $table->double('total');
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
        Schema::dropIfExists('plan_orders');
    }
}
