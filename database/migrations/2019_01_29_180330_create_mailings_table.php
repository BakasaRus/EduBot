<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mailings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('text');
            $table->string('attachments')->nullable();
            $table->dateTime('send_at')->nullable();
            $table->integer('mailing_list_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

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
        Schema::table('mailings', function (Blueprint $table) {
            $table->dropForeign(['mailing_list_id']);
        });
        Schema::dropIfExists('mailings');
    }
}
