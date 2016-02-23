<?php
/* @var $this InboundController */
/* @var $model Inbound */

$this->breadcrumbs=array(
	'Inbounds'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Inbound', 'url'=>array('index')),
	array('label'=>'Create Inbound', 'url'=>array('create')),
	array('label'=>'View Inbound', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Inbound', 'url'=>array('admin')),
);
?>

<h1>Update Inbound <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>