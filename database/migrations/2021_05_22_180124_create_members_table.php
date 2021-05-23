<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('status',255)->nullable();
            $table->string('position', 255)->nullable();
            $table->string('id_sso')->nullable();
            $table->string('user_type')->nullable();
            $table->string('name')->nullable();
            $table->string('picture')->nullable();
            $table->string('phone')->nullable();
            $table->string('birthday')->nullable();
            $table->string('gender')->nullable();
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
        Schema::dropIfExists('members');
    }
}
