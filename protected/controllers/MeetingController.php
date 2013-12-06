<?php

class MeetingController extends Controller
{
    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionAll($start, $end, $_)
    {
        $result = array();
        if (is_numeric($start) && is_numeric($end))
            $result = Meeting::getByDate($start, $end);

        $this->responseJson($result);
        Yii::app()->end();
    }

    public function actionCreate()
    {
        // Ajax
        if (Yii::app()->request->isPostRequest)
            $this->saveModelPOST(new Meeting());
        else
            $this->show503();
    }

    public function actionUpdate($id)
    {
        // Ajax
        if (Yii::app()->request->isPostRequest)
            $this->saveModelPOST($this->loadModel($id));
        else
            $this->show503();
    }

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

    protected function loadModel($id)
    {
        $model = Meeting::model()->findByPk($id);
        if (null === $model)
            $this->show404();

        return $model;
    }

    protected function saveModelPOST(Meeting $model)
    {
        $model->setScenario((isset($_POST['confirmed']) && $_POST['confirmed'] === 'true') ? '' : Meeting::SCENARIO_UNCONFIRMED);

        $model->title       = $_POST['title'];
        $model->place       = $_POST['place'];
        $model->started_at  = $_POST['start'];
        $model->finished_at = $_POST['end'];
        $model->type        = isset($_POST['type']) ? $_POST['type'] : Meeting::TYPE_UNDEFINED;

        $this->responseJson(array(
            'result' => $model->save(),
            'modelAttributes' => $model->getAttributes(),
            'modelErrors' => $model->getErrors(),
            'notConfirmed' => ($model->getScenario() === Meeting::SCENARIO_UNCONFIRMED)
        ));

        Yii::app()->end();
    }
}