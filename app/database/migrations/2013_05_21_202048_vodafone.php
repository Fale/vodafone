<?php

use Illuminate\Database\Migrations\Migration;

class Vodafone extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vodafone', function($table)
		{
			$table->increments('id');
			$table->string('tipo');
			$table->string('destinazione');
			$table->string('numero');
			$table->timestamp('data');
			$table->time('durata');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('vodafone');
	}

}
