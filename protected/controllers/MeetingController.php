<?php

/**
 * Class MeetingController
 */
class MeetingController extends Controller
{
    public function actionIndex()
    {
        $this->layout = 'clear';
        $this->render('index');
    }

    /**
     * @param integer $start
     * @param integer $end
     */
    public function actionAll($start, $end)
    {
        if (Yii::app()->request->isAjaxRequest)
        {
            $result = array();

            if (is_numeric($start) && is_numeric($end))
                $result = Meeting::getByDate($start, $end);

            $this->responseJson($result);
            Yii::app()->end();
        }
        else
            $this->show503();
    }

    public function actionCreate()
    {
        // Ajax
        if (Yii::app()->request->isPostRequest)
            $this->saveModelPOST(new Meeting());
        else
            $this->show503();
    }

    /**
     * @param integer $id
     */
    public function actionUpdate($id)
    {
        // Ajax
        if (Yii::app()->request->isPostRequest)
            $this->saveModelPOST($this->loadModel($id));
        else
            $this->show503();
    }

    /**
     * @param integer $id
     */
    public function actionDelete($id)
    {
        // Ajax
        if (Yii::app()->request->isPostRequest)
        {
            $model = $this->loadModel($id);
            $this->responseJson(array('result' => $model->delete()));
        }
        else
            $this->show503();
    }

    public function actionXML()
    {
        $meetings = Meeting::model()->future()->findAll();
        $xml = new SimpleXMLElement('<meetings/>');

        foreach ($meetings as $meeting)
        {
            $node = $xml->addChild('meeting');
            foreach ($meeting->getAttributes() as $attr => $val)
                $node->addChild($attr, $val);
        }

        $this->responseXML($xml->asXML());
    }

    /**
     * @param integer $id
     * @return array|CActiveRecord|mixed|null
     */
    protected function loadModel($id)
    {
        return Meeting::model()->findByPkOr404($id);
    }

    /**
     * Use with ajax
     * @param Meeting $model
     * @return string
     */
    protected function saveModelPOST(Meeting $model)
    {
        if (!(isset($_POST['confirmed']) && $_POST['confirmed'] === 'true'))
            $model->setScenario(Meeting::SCENARIO_UNCONFIRMED);

        $model->setAttributes($_POST);

        $this->responseJson(array(
            'result'          => $model->save(),
            'modelAttributes' => $model->getAttributes(),
            'modelErrors'     => $model->getErrors(),
            'notConfirmed'    => ($model->getScenario() === Meeting::SCENARIO_UNCONFIRMED)
        ));

        Yii::app()->end();
    }
}