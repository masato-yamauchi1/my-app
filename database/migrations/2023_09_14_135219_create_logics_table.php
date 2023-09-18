<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logics', function (Blueprint $table) {
            $table->comment('各ロジックの内容を保存する'); 

            $table->id('id')->comment('ロジックID');
            $table->string('title', 50)->comment('ロジックのタイトル');
            $table->string('graph_img_name', 50)->comment('グラフイメージファイルの名前');
            $table->string('result_img_name', 50)->comment('バックテストの結果イメージファイルの名前');
            $table->integer('main_indicator_id')->nullable()->comment('使用しているメインインジケーター');;
            $table->integer('sub_indicator_id')->nullable()->comment('使用しているサブインジケーター');;
            $table->text('logics_body')->nullable()->comment('ロジックの内容');
            $table->string('last_user', 50)->comment('最終更新、登録者');
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
        Schema::dropIfExists('logics');
    }
};
