<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMediatorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mediators', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->date('created_at')->nullable();
			$table->date('updated_at')->nullable();
			$table->integer('department_id')->nullable()->index('fk_mediators_departments1_idx');
			$table->integer('employee_id')->index('fk_archive_employees_employees1_idx');
			$table->integer('position_id')->nullable()->index('fk_mediators_positions1_idx');
			$table->integer('wage')->nullable();
			$table->integer('is_archive')->default(0);
			$table->integer('recruitment_event_id')->index('fk_mediators_events1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('mediators');
	}

}
