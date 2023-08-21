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
        Schema::create('project_total_coverages', function (Blueprint $table) {
            $table->id();

            $table->float("statements");
            $table->float("branches");
            $table->float("functions");
            $table->float("lines");

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
        Schema::dropIfExists('project_total_coverages');
    }
};
