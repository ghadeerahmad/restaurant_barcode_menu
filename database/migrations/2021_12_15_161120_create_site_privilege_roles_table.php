<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSitePrivilegeRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('site_privilege_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_privilege_id')->constrained('site_privileges')->cascadeOnDelete();
            $table->foreignId('site_role_id')->constrained('site_roles')->cascadeOnDelete();
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
        Schema::dropIfExists('site_privilege_roles');
    }
}
