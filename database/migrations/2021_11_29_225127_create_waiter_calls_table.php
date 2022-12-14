<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaiterCallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waiter_calls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('table_id');
            $table->string('comment')->nullable();
            $table->foreignId('store_id');
            $table->tinyInteger('is_completed')->default(0);
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
        Schema::dropIfExists('waiter_calls');
    }
}
