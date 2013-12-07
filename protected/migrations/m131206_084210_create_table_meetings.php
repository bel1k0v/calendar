<?php

class m131206_084210_create_table_meetings extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{meetings}}', array(
            'id' => 'pk',
            'title' => 'varchar(200) NOT NULL',
            'type' => 'int(11) NOT NULL',
            'place' => 'text DEFAULT NULL',
            'start' => 'int(11) NOT NULL',
            'end' => 'int(11) NOT NULL',
        ), 'ENGINE=InnoDB');
	}

	public function down()
	{
		$this->dropTable('{{meetings}}');
	}
}