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
        Schema::create('audit_projects', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string("name");
            $table->date("start_date");
            $table->date("finish_date");
            $table->string("jira_id");
            $table->string("slack_channel");
            $table->string("client");
            $table->text("description");
            $table->string("website");
            $table->enum("audit_type",['Solidity smart contracts','Rust Programs','PyTeal Smart Contracts','Reach Smart Contracts','DApp Security'])->default('Solidity smart contracts');
            $table->enum("audit_method",['WhiteBox','BlackBox'])->default('WhiteBox');
            $table->boolean("is_published")->default(false);
            $table->text("summary");
            $table->text("disclaimer");
            $table->text("findings");
            $table->text("conclusion");
            $table->enum('type', ['Private', 'Public'])->default('Private');

            $table->foreignId('status_id')->constrained('status');
            $table->foreignUuid('user_id')->constrained()->onDelete("cascade");

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
        Schema::dropIfExists('audit_projects');
    }
};
