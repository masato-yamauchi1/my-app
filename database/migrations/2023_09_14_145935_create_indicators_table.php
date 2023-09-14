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
        Schema::create('indicators', function (Blueprint $table) {
            $table->comment('インジケーターの内容を保存する'); 

            $table->id('indicators_id')->comment('インジケータID');
            $table->string('indicator_name', 50)->comment('インジケータ名');
            $table->text('indicator_body')->nullable()->comment('インジケータの内容');
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
        Schema::dropIfExists('indicators');
    }
};
