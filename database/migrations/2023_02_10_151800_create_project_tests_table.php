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
        Schema::create('project_tests', function (Blueprint $table) {
            $table->id();

            $table->text("introduction")->nullable();
            $table->text("conclusion")->nullable();

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
        Schema::dropIfExists('project_tests');
    }
};
