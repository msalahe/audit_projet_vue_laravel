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
        Schema::create('project_issues', function (Blueprint $table) {
            $table->id();

            $table->string("title");
            $table->string("code");

            $table->text("description");
            $table->text("attack_scenario")->nullable();
            $table->text("recommendation");
            $table->text("updates")->nullable();

            $table->enum('likelihood', [1, 2,3]);
            $table->enum('impact', [-1,0,1,2,3]);

            $table->enum('status', ['Not Fixed', 'Fixed','Mitigated','Acknowledged','Partially Fixed']);
            $table->enum('state', ['Draft', 'Approved','Pending','Duplicated','Not Approved','Fixes']);

            $table->foreignUuid('user_id')->constrained();
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
        Schema::dropIfExists('project_issues');
    }
};
