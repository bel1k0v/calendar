<?php

class m131206_084832_create_table_meeting_types extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{meeting_types}}', array(
            'id' => 'pk',
            'desc' => 'varchar(255) NOT NULL'
        ), 'ENGINE=MyISAM');
	}

	public function down()
	{
		$this->dropTable('{{meeting_types}}');
	}
}