<?php

/**
 * Class ActiveRecord
 */
class ActiveRecord extends CActiveRecord
{
    /**
     * @param $pk
     * @param string $condition
     * @param array $params
     * @return array|CActiveRecord|mixed|null
     * @throws CHttpException
     */
    public function findByPkOr404($pk, $condition = '', $params = array())
    {
        $model = $this->findByPk($pk, $condition, $params);
        if (null === $model)
            throw new CHttpException(404);

        return $model;
    }
}