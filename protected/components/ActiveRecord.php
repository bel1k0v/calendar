<?php

class ActiveRecord extends CActiveRecord
{
    public function findByPkOr404($pk, $condition = '', $params = array())
    {
        $model = $this->findByPk($pk, $condition, $params);
        if (null === $model)
            throw new CHttpException(404);

        return $model;
    }
}