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
        Schema::create('project_best_practices', function (Blueprint $table) {
            $table->id();

            $table->string("title");
            $table->string("code");
            $table->text("description");


            $table->enum('status', ['Not Fixed', 'Fixed','Mitigated','Acknowledged','Partially Fixed'])->default('Not Fixed');
            $table->enum('state', ['Draft', 'Approved','Pending','Duplicated','Not Approved','Fixes'])->default('Draft');

            $table->foreignUuid('project_id')->constrained('audit_projects');
            $table->foreignUuid('user_id')->constrained();

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
        Schema::dropIfExists('project_best_practices');
    }
};
