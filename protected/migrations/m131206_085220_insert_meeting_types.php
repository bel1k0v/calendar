<?php

class m131206_085220_insert_meeting_types extends CDbMigration
{
	public function safeUp()
	{
        $desc = array(
            'Собеседование',
            'Совещание',
            'Конференция',
            'Пьянка'
        );

        $sql = 'INSERT INTO {{meeting_types}} (`desc`) VALUES ("'. implode('"),("', $desc).'");';
        $this->dbConnection->createCommand($sql)->execute();
	}

	public function safeDown()
	{
        $this->dbConnection->createCommand('TRUNCATE {{meeting_types}}');
	}
}