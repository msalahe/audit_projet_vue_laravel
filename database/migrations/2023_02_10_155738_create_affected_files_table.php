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
        Schema::create('affected_files', function (Blueprint $table) {
            $table->id();

            $table->integer('root_id');
            $table->enum('type',[1,2,3,4]);
            $table->integer('order');
            $table->string('file_name');
            $table->integer('start_line');
            $table->text('code');

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
        Schema::dropIfExists('affected_files');
    }
};
