<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id');
            $table->string('username', 100)->unique();
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->string('token')->nullable();
            $table->string('role')->default('2');
            $table->boolean('active')->default(0); // Account not active till email is confirmed
            $table->string('code')->nullable(); // Used for email confirmation
           
            $table->string('name');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('provider_id')->nullable();
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
