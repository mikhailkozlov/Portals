<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFilesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'files',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('user_id');
                $table->integer('downloads')->default(0);
                $table->string('title', 250);
                $table->text('description');
                $table->text('permissions')->nullable(); // we should be able to store multiple permissions
                $table->integer('group_id');
                $table->text('keywords');
                $table->string('filename', 250);
                $table->string('extension', 50);
                $table->string('type', 50);
                $table->integer('size');
                $table->timestamps();
                $table->softDeletes();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('files');
    }

}
