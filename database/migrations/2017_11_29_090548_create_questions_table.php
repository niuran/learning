<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userid');
            $table->string('type')->default('radio')->comment('问题类型：1、单选；2、填空；3、多选；4、文章');
            $table->string('title')->comment('问题内容');
            $table->string('content')->nullable()->comment('选项内容，当单选、多选时才需要此字段');
            $table->string('answer')->comment('问题的答案：填空与选择为准确答案，文章为参考答案');
            $table->integer('sort')->default(100);
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
        Schema::dropIfExists('questions');
    }
}
