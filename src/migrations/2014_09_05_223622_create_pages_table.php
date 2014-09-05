<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePagesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'pages',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('portal_id');
                $table->integer('user_id');
                $table->string('slug', 250);
                $table->string('title', 250);
                $table->text('content');
                $table->text('excerpt');
                $table->string('type', 20);
                $table->string('status', 20);
                $table->bigInteger('parent_id');
                $table->integer('menu_order');
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
        Schema::drop('pages');
    }

}
