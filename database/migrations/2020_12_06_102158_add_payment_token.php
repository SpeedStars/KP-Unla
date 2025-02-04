<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentToken extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
				$table->string('payment_token')->after('status_order_id')->nullable();
				$table->string('payment_url')->after('payment_token')->nullable();

				$table->index('payment_token');
			}
		);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
				$table->dropColumn('payment_token');
				$table->dropColumn('payment_url');
            }
		);
    }
}
