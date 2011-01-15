<?php

namespace Fuel\Migrations;

class Create_venues {

	function up()
	{
		\DBUtil::create_table('venues', array(
			'id' => array('type' => 'int', 'auto_increment' => true),
			'title' => array('type' => 'text'),
			'' => array('type' => '', 'constraint' => ),
			'source' => array('type' => 'varchar', 'constraint' => 12),

		), array('id'));
	}

	function down()
	{
		\DBUtil::drop_table('venues');
	}
}