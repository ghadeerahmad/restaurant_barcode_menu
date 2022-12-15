<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorePrivilegeRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('store_privilege_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_privilege_id')->constrained('store_privileges')->cascadeOnDelete();
            $table->foreignId('store_role_id')->constrained('store_roles')->cascadeOnDelete();
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
        Schema::dropIfExists('store_privilege_roles');
    }
}
