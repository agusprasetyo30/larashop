<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PenyesuaianTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('users', function (Blueprint $table) {
        //     $table->string("username")->after("email")->unique();
        //     $table->string("roles")->after("password");
        //     $table->text("address")->after("roles");
        //     $table->string("phone")->after("address");
        //     $table->string("avatar")->after("phone");
        //     $table->enum("status", ["ACTIVE", "INACTIVE"])->after("avatar");

        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('users', function (Blueprint $table) {
        //     $table->dropColumn("username");
        //     $table->dropColumn("roles");
        //     $table->dropColumn("address");
        //     $table->dropColumn("phone");
        //     $table->dropColumn("avatar");
        //     $table->dropColumn("status");
        // });
    }
}
