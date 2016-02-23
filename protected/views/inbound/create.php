<?php
/* @var $this InboundController */
/* @var $model Inbound */

$this->breadcrumbs=array(
	'Inbounds'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Inbound', 'url'=>array('index')),
	array('label'=>'Manage Inbound', 'url'=>array('admin')),
);
?>

<h1>Create Inbound</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>