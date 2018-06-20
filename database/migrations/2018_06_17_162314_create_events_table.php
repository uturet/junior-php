<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEventsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('events', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->date('created_at')->nullable();
			$table->date('updated_at')->nullable();
			$table->text('description', 65535);
			$table->integer('wage')->nullable();
			$table->integer('department_id')->nullable()->index('fk_events_departments1_idx');
			$table->integer('position_id')->nullable()->index('fk_events_positions1_idx');
			$table->integer('employee_id')->nullable()->index('fk_events_employees1_idx');
			$table->integer('is_archive')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('events');
	}

}
