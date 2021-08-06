<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->unsignedSmallInteger('gender');
            $table->string('avatar')->default('default');
            $table->string('cover')->default('default');
            $table->string('about')->nullable();
            $table->string('status')->nullable();
            $table->unsignedMediumInteger('age')->default(18);
            $table->date('birthday');
            $table->unsignedSmallInteger('role')->default(1);
            $table->boolean('verified')->default(false);
            $table->timestamp('last_seen')->useCurrent();
            $table->string('google_id')->nullable();
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
