<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePortalsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'portals',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('slug', 250);
                $table->string('title', 250);
                $table->integer('user_id')->nullable();
                $table->bigInteger('page_id')->nullable();
                $table->text('keywords');
                $table->text('description');
                $table->string('status', 20)->default('draft');
                $table->integer('menu_depth')->default(0);
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
        Schema::drop('portals');
    }

}
