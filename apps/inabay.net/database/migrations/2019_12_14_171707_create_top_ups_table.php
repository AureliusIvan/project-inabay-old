<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopUpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('top_ups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('bank_name');
            $table->string('account_name');
            $table->string('account_no');
            $table->double('amount');
            $table->string('code')->unique()->comment('UID-DDMMYY-NUM');
            $table->boolean('is_confirm')->default(false);
            $table->boolean('is_cancel')->default(false);
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
        Schema::dropIfExists('top_ups');
    }
}
