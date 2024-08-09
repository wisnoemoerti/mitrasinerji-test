<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('kode', 15);
            $table->date('tgl');
            $table->unsignedBigInteger('cust_id');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('diskon', 10, 2);
            $table->decimal('ongkir', 10, 2)->default(0);
            $table->decimal('total_bayar', 10, 2);
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
        Schema::dropIfExists('sales');
    }
}
