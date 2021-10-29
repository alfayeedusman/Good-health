<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDownlinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('downlinestbl', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
			$table->nestedSet();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('downlinestbl', function (Blueprint $table) {
			$table->dropNestedSet();
		});
    }
}
