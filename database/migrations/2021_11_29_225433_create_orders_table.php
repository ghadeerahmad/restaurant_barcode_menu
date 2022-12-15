<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_unique_id')->unique();
            $table->foreignId('store_id')->constrained('stores')->cascadeOnDelete();
            $table->foreignId('table_id')->nullable()->constrained('tables')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();
            $table->double('discount')->nullable();
            $table->double('tax')->nullable();
            $table->boolean('is_delivery_enabled')->default(0);
            $table->double('delivery_charge')->nullable();
            $table->string('order_type');
            $table->boolean('status')->default(0);
            $table->text('comments')->nullable();
            $table->tinyInteger('payment_status')->default(0);
            $table->text('address')->nullable();
            $table->double('latitude')->nullable();
            $table->double('longtude')->nullable();
            $table->string('payment_type')->default('cash');
            $table->boolean('call_waiter_enabled')->default(0);
            $table->string('coupon_code')->nullable();
            $table->double('total');
            $table->string('user_key')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
