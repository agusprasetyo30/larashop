<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_order', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_id')->unsigned();
            $table->bigInteger('book_id')->unsigned();
            $table->Integer('quantity')
                ->unsigned()->defaults(1);

            $table->timestamps();

            $table->foreign('order_id')->references('id')
                ->on('orders');
            $table->foreign('book_id')->references('id')
                ->on('books');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('book_order', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['book_id']);
        });

        Schema::dropIfExists('book_order');
    }
}
