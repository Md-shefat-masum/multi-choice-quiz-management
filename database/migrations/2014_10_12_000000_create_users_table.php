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
            $table->id();
            $table->tinyInteger('role_id')->default(2); // admin: 1, user: 2
            $table->string('name',100)->nullable();
            $table->string('email',155)->unique();
            $table->string('phone',30)->unique();
            $table->text('cv_link')->nullable();
            $table->text('submission_link')->nullable();
            $table->text('live_link')->nullable();
            $table->string('status',30)->default('pending');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
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
