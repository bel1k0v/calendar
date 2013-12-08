<?php
// change the following paths if necessary
$yii=dirname(__FILE__).'/vendor/yiisoft/yii/framework/yii.php';
if (!file_exists($yii)
    die('Plese make composer install or change Yii directory manualy in index.php and ./protected/yiic.php');

$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();
