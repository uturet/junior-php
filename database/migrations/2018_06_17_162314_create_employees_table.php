<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmployeesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('employees', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->date('created_at')->nullable();
			$table->date('updated_at')->nullable();
			$table->string('name', 45);
			$table->string('last_name', 45);
			$table->string('patronymic', 45);
			$table->integer('gender')->nullable();
			$table->date('burn_date')->nullable();
			$table->string('phone', 30)->nullable();
			$table->string('email', 45)->nullable();
			$table->string('photo_url', 90)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('employees');
	}

}
