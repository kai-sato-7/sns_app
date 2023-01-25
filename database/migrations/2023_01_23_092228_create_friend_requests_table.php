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
        Schema::create('friend_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('outgoing_user_id')->unsigned();
            $table->foreign('outgoing_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('ingoing_user_id')->unsigned();
            $table->foreign('ingoing_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['outgoing_user_id', 'ingoing_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('friend_requests');
    }
};
