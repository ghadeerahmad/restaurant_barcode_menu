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
        Schema::disableForeignKeyConstraints();
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
            $table->string('address_ar')->nullable();
            $table->string('address_en')->nullable();
            $table->boolean('status')->default(0);
            $table->integer('max_branches')->default(0);
            $table->foreignId('parent_id')->nullable()->constrained('stores')->cascadeOnDelete();
            $table->foreignId('admin_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('currency_id')->nullable()->constrained('currencies')->nullOnDelete();
            $table->foreignId('country_code_id')->nullable()->constrained('country_codes')->nullOnDelete();
            $table->foreignId('active_theme_id')->nullable()->constrained('themes')->nullOnDelete();
            $table->string('lang_code')->nullable();
            $table->integer('delivery_distance')->nullable();
            $table->double('delivery_fees')->nullable();
            $table->string('tax_note')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('twitter')->nullable();
            $table->string('telegram')->nullable();
            $table->string('opening_time')->nullable();
            $table->string('closing_time')->nullable();
            $table->text('maps_url')->nullable();
            $table->double('min_delivery')->nullable();
            $table->string('work_days_note')->nullable();
            $table->double('tax')->nullable();
            $table->enum('tax_type', ['AMOUNT', 'PERCENT'])->default('PERCENT');
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
