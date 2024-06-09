<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('tb_posts', function (Blueprint $table) {
            $table->id('id_posts');
            $table->string('title');
            $table->string('image');
            $table->text('description');
            $table->timestamp('time_creation')->default(now());
            $table->unsignedInteger('likes')->default(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('tb_posts');
    }
}
