<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateMkPlanoAcessosTable.
 */
class CreateMkPlanoAcessosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mk_plano_acessos', function(Blueprint $table) {
            $table->increments('id');

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
		Schema::drop('mk_plano_acessos');
	}
}
