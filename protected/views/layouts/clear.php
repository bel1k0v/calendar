<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

    <?php Yii::app()->clientScript->registerCssFile('/css/bootstrap/bootstrap.css'); ?>
</head>

<body>

<div class="container-fluid" id="page">
    <div class="row">
        <?php echo $content; ?>
    </div>
</div><!-- page -->

</body>
</html>
