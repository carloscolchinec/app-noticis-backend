<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('tb_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->foreign('post_id')->references('id_posts')->on('tb_posts')->onDelete('cascade');
            $table->string('user_name'); // Nombre de usuario aleatorio
            $table->text('message'); // Mensaje del comentario
            $table->timestamps(); // Fecha de creación y actualización del comentario
        });
    }

    public function down()
    {
        Schema::dropIfExists('tb_comments');
    }
}
