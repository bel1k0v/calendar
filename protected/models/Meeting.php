<?php

/**
 * This is the model class for table "{{meetings}}".
 *
 * The followings are the available columns in table '{{meetings}}':
 * @property integer $id
 * @property string $title
 * @property integer $type
 * @property string $place
 * @property integer $started_at
 * @property integer $finished_at
 */
class Meeting extends CActiveRecord
{
    const SCENARIO_UNCONFIRMED = 'unconfirmed';
    const TYPE_UNDEFINED = 0;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Meeting the static model class
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
		return '{{meetings}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('title, started_at', 'required'),
            array('title', 'match', 'pattern' => '/^[^(\,|\.|\:|\;|\!|\?|\'|\"|\@|\&|\%|\#|\*|\)|\(|\]|\[|\{|\}|\-|\+|\~|\\|\/)](.*)/', 'message' => 'Punctuation prohibited'),
            array('title', 'length', 'min' => 3, 'max' => 200),
			array('type, started_at, finished_at', 'numerical', 'integerOnly'=>true),
            array('type', 'exist', 'allowEmpty' => true /* Default 0 */, 'className' => 'MeetingType', 'attributeName' => 'id'),
            array('type', 'checkForIntersections', 'on' => self::SCENARIO_UNCONFIRMED),
			array('place', 'match', 'pattern' => '/^[A-я\s]+$/i', 'allowEmpty' => true),
			array('id, title, type, place, started_at, finished_at', 'safe', 'on'=>'search'),
		);
	}

    /**
     * @param string$attribute
     * @param array $params
     */
    public function checkForIntersections($attribute, $params)
    {
        $criteria = new CDbCriteria();
        $cond = '`t`.`type` = ' . $this->type;
        $cond .= !$this->getIsNewRecord() ? ' AND `t`.`id` NOT IN (' . $this->id . ')' : '';

        $criteria->addCondition($cond);
        $meetings = $this->findAll($criteria);

        $result = true;
        foreach ($meetings as $meeting)
        {
            if (($this->started_at > $meeting->started_at) && ($this->started_at < $meeting->finished_at))
            {
                $result = false; break;
            }
            elseif (($this->finished_at > $meeting->started_at) && ($this->finished_at < $meeting->finished_at))
            {
                $result = false; break;
            }
            elseif (($this->finished_at == $meeting->started_at) && ($this->finished_at == $meeting->finished_at))
            {
                $result = false; break;
            }
            else
                continue;
        }

        if (!$result)
            $this->addError($attribute, 'У вас у назначено на эту дату.');
    }



	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
            'type' => array(self::HAS_ONE, 'MeetingType', 'type')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'type' => 'Type',
			'place' => 'Place',
			'started_at' => 'Started At',
			'finished_at' => 'Finished At',
		);
	}

    public function scopes()
    {
        return array(
            'future' => array(
                'condition' => '`t`.`started_at` >= ' . time(),
                'limit' => 10
            ),
        );
    }

    /**
     * @param integer $start
     * @param integer $end
     * @return array
     */
    public static function getByDate($start, $end)
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition('`t`.`started_at` >= :start');
        $criteria->addCondition('`t`.`finished_at` <= :end');
        $criteria->params = array(
            ':start' => $start,
            ':end' => $end,
        );

        $result = array();
        $models = self::model()->findAll($criteria);
        if (empty($models))
            return $result;

        foreach ($models as $model)
        {
            $result[] = array(
                'id' => $model->id,
                'title' => $model->title,
                'type' => $model->type,
                'place' => $model->place,
                'start' => $model->started_at,
                'end' => $model->finished_at
            );
        }

        return $result;
    }
}