<?php

/**
 * This is the model class for table "{{meeting_types}}".
 *
 * The followings are the available columns in table '{{meeting_types}}':
 * @property integer $id
 * @property string $desc
 */
class MeetingType extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MeetingType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{meeting_types}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('desc', 'required'),
			array('desc', 'length', 'max'=>255),
			array('id, desc', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'desc' => 'Desc',
		);
	}

    /**
     * @return array
     */
    public static function getAll()
    {
        $result = array();
        $models = self::model()->findAll();
        foreach ($models as $model)
            $result[$model->id] = $model->desc;

        return $result;
    }
}