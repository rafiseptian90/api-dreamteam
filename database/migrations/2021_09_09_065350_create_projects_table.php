<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("owner_id");
            $table->foreign("owner_id")->references("id")->on("users")->onDelete("cascade")->onUpdate("cascade");
            $table->string("slug");
            $table->string("project_name");
            $table->string("link")->nullable();
            $table->string("logo")->default("projects/default.png");
            $table->text("description");
            $table->integer("viewed")->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
