<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('invoice');
            $table->decimal('subtotal');
            $table->string('method');
            $table->string('status');
            $table->string('token');
            $table->json('payloads');
            $table->string('payment_type');
            $table->string('va_number');
            $table->string('vendor_name');
            $table->string('biller_code');
            $table->string('bill_key');
            $table->timestamps();

            $table->index('method');
            $table->index('token');
            $table->index('payment_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
