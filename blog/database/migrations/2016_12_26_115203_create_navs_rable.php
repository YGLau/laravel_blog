<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNavsRable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('navs', function (Blueprint $table) {
            $table->engine = 'myISAM';
            $table->increments('nav_id')->comment('//自增id');
            $table->string('nav_name')->default('')->comment('//名称');
            $table->string('nav_title')->default('')->comment('//标题');
            $table->integer('nav_order')->default(0)->comment('//排序');
            $table->string('nav_url')->default('')->comment('//地址');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('navs');
    }
}
