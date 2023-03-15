<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('receiver_name')->nullable();
            $table->string('receiver_phone')->nullable();
            $table->text('receiver_address');
            $table->string('receiver_city', 25)->nullable();
            $table->string('receiver_zipcode', 5)->nullable();
            $table->integer('courier_id');
            $table->text('description')->nullable();
            $table->string('booking_code')->nullable()->comment('Kode booking/no.resi otomatis');
            $table->double('delivery_cost');
            $table->string('courier_receipt')->nullable();

            $table->boolean('is_dropship')->nullable();
            $table->string('dropshiper_name')->nullable();
            $table->string('dropshiper_phone')->nullable();

            $table->integer('status')->default(1)->comment('1.Process, 2.Sent, 3.Cancel, 4.SiapDikirim');
            $table->boolean('use_points')->default(false);
            $table->timestamps();

            $table->boolean('is_cod')->default(false)->nullable();
            $table->double('cod_amount')->nullable();
            $table->boolean('is_paid')->default(false);
            $table->boolean('is_paid_confirm')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
