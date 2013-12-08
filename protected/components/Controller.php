<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

    /**
     * @param $result bool
     * @param $data array
     * @param $errors array
     */
    public function responseJson($data = array())
    {
        header("Content-type: application/json; charset=utf-8");
        header("Cache-Control: no-store, no-cache, must-revalidate");

        echo CJSON::encode($data);
    }

    public function responseXML($xml)
    {
        header("Content-type: application/xml; charset=utf-8");
        header("Cache-Control: no-store, no-cache, must-revalidate");

        echo $xml;
    }

    /**
     * Additional checking for ajax requests
     * @param integer $_
     */
    public function checkAjaxJsTimestamp($_)
    {
        $ajaxTs = (int) ceil($_ / 1000);
        switch ($ajaxTs)
        {
            case time():
            case time() + 1:
            case time() - 1:
                return ;
            default:
                $this->show503();
        }
    }

    /**
     * @param string $message
     * @throws CHttpException
     */
    public function show404($message = '')
    {
        if (empty($message))
            $message = Yii::t('', 'Page not found.');
        throw new CHttpException(404, $message);
    }

    /**
     * @param string $message
     * @throws CHttpException
     */
    public function show503($message = '')
    {
        if (empty($message))
            $message = Yii::t('', 'Invalid request.');
        throw new CHttpException(503, $message);
    }
}