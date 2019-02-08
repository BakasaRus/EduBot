<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailingListsSubscribersPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mailing_list_subscriber', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('subscriber_id')->unsigned();
            $table->integer('mailing_list_id')->unsigned();
            $table->timestamps();

            $table->foreign('subscriber_id')
                ->references('id')
                ->on('subscribers')
                ->onDelete('cascade');

            $table->foreign('mailing_list_id')
                ->references('id')
                ->on('mailing_lists')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mailing_list_subscriber', function (Blueprint $table) {
            $table->dropForeign(['mailing_list_id']);
            $table->dropForeign(['subscriber_id']);
        });
        Schema::dropIfExists('mailing_list_subscriber');
    }
}
