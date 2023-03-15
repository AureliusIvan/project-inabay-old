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
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->string('no_ktp')->nullable();
            $table->string('address');
            $table->string('city');
            $table->string('zipcode', 5);
            $table->string('phone');
            $table->string('shop_name');
            $table->string('bank_name')->nullable();
            $table->string('bank_acc_name');
            $table->string('bank_acc_no');
            $table->double('balance')->default(0)->nullable();
            $table->double('points')->default(0)->nullable();
            $table->integer('role_id')->default(3)->comment('0:developer, 1:superadmin, 2:admin, 3:member, 4:vendor, 5:finance');
            $table->boolean('is_active')->default(false);

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
