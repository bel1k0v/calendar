<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<div id="calendar"></div>

<?php Yii::app()->clientScript->registerCssFile('/css/fullcalendar/fullcalendar.css'); ?>
<?php Yii::app()->clientScript->registerCssFile('/css/fullcalendar/fullcalendar.print.css'); ?>

<?php Yii::app()->clientScript->registerScriptFile('/js/jquery/jquery.min.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile('/js/moment/moment.min.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile('/js/fullcalendar/fullcalendar.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile('/js/bootstrap/bootstrap.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile('/js/bootstrap/bootstrap-modal-popover.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile('/js/controllers/meeting/index.js', CClientScript::POS_END);