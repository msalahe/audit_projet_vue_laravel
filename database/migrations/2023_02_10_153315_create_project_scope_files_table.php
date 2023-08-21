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
        Schema::create('project_scope_files', function (Blueprint $table) {
            $table->id();

            $table->string("file_path");
            $table->string("hash");


            $table->foreignUuid('project_id')->constrained('audit_projects');
            $table->foreignid('status_id')->constrained('status');

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
        Schema::dropIfExists('project_scope_files');
    }
};
