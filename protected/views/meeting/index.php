<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<div id="calendar">

</div>

<div id="event" style="display: none;">
    <div id="start_date"></div><br />
    <div id="end_date"></div><br />

    <?= CHtml::label('Имя', 'title'); ?>
    <?= CHtml::textField('title', '', array('id' => 'title')); ?> <br />
    <?= CHtml::label('Место', 'place'); ?>
    <?= CHtml::textField('place', '', array('id' => 'place')); ?> <br />
    <?= CHtml::label('Тип', 'type'); ?>
    <?= CHtml::dropDownList('type', '', MeetingType::getAll(), array('id' => 'type')); ?> <br />
</div>
<?php Yii::app()->clientScript->registerScriptFile('//code.jquery.com/jquery-1.9.1.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile('//code.jquery.com/ui/1.10.3/jquery-ui.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerCssFile('//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css'); ?>
<?php Yii::app()->clientScript->registerScriptFile('//cdnjs.cloudflare.com/ajax/libs/fullcalendar/1.6.4/fullcalendar.min.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile('/js/pages/index.js', CClientScript::POS_END);