<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MemberTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('member_tbls', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name',100);
			$table->string('last_name',100);
			$table->integer('mobile')->length(9);
            $table->string('email',50);
            $table->enum('status', ['active', 'inactive'] );
			$table->integer('user_id')->length(9);
			$table->integer('level')->length(9);
			$table->integer('experience')->length(9);
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
        Schema::dropIfExists('member_tbl');
    }
}
