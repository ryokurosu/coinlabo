<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code')->unique();
            $table->string('email')->unique();
            $table->string('google2fa_secret')->default('');
            $table->Integer('google2fa')->default(0);
            $table->string('password');
            $table->Integer('active')->default(1);
            $table->Integer('auth')->default(1);
            $table->string('email_token')->nullable(); 
            $table->tinyInteger('verified')->default(0); 
            $table->tinyInteger('status')->default(0); 
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
