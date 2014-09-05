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
                $table->text('excerpt')->nullable();
                $table->string('type', 20)->default('page');
                $table->string('status', 20)->default('draft');
                $table->bigInteger('parent_id')->nullable();
                $table->integer('menu_order')->default(0);
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
