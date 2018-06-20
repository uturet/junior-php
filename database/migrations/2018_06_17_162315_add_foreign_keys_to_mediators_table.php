<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToMediatorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('mediators', function(Blueprint $table)
		{
			$table->foreign('employee_id', 'fk_archive_employees_employees1')->references('id')->on('employees')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('department_id', 'fk_mediators_departments1')->references('id')->on('departments')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('recruitment_event_id', 'fk_mediators_events1')->references('id')->on('events')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('position_id', 'fk_mediators_positions1')->references('id')->on('positions')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('mediators', function(Blueprint $table)
		{
			$table->dropForeign('fk_archive_employees_employees1');
			$table->dropForeign('fk_mediators_departments1');
			$table->dropForeign('fk_mediators_events1');
			$table->dropForeign('fk_mediators_positions1');
		});
	}

}
