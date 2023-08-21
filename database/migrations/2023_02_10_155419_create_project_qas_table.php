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
        Schema::create('project_qas', function (Blueprint $table) {
            $table->id();

            $table->string("name");
            $table->string("link");

            $table->enum('quality', [1, 2, 3]);

            $table->foreignUuid('project_id')->constrained('audit_projects');

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
        Schema::dropIfExists('project_qas');
    }
};
