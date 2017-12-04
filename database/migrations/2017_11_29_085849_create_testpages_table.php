<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestpagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('testpages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userid')->comment('测试所属用户id');
            $table->string('name')->comment('测试的试卷名字');
            $table->string('comment')->nullable()->comment('备注');
            $table->string('questions')->nullable()->comment('该测试所包含的所有问题ID数组，json表示');
            $table->integer('sort')->nullable()->default(100);
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
        Schema::dropIfExists('testpages');
    }
}
