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
        Schema::create('sender_ids', function (Blueprint $table) {
            $table->id();
            $table->string('sender_id');
            $table->integer('client_id')
                ->unsigned()
                ->index();
            $table->foreign('client_id')
                ->references('id')
                ->on('clients')
                ->cascadeOnDelete();
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
        Schema::dropIfExists('sender_ids');
    }
};
