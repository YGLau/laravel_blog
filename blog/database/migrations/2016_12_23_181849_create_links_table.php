<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->engine = 'myISAM';
            $table->increments('link_id')->comment('//自增id');
            $table->string('link_name')->default('')->comment('//名称');
            $table->string('link_title')->default('')->comment('//标题');
            $table->integer('link_order')->default(0)->comment('//排序');
            $table->string('link_url')->default('')->comment('//地址');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('links');
    }
}
