<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToEventsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('events', function(Blueprint $table)
		{
			$table->foreign('department_id', 'fk_events_departments1')->references('id')->on('departments')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('employee_id', 'fk_events_employees1')->references('id')->on('employees')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('position_id', 'fk_events_positions1')->references('id')->on('positions')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('events', function(Blueprint $table)
		{
			$table->dropForeign('fk_events_departments1');
			$table->dropForeign('fk_events_employees1');
			$table->dropForeign('fk_events_positions1');
		});
	}

}
