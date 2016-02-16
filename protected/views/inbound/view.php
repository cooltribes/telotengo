<?php
/* @var $this InboundController */
/* @var $model Inbound */

$this->breadcrumbs=array(
	'Inbounds'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Inbound', 'url'=>array('index')),
	array('label'=>'Create Inbound', 'url'=>array('create')),
	array('label'=>'Update Inbound', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Inbound', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Inbound', 'url'=>array('admin')),
);
?>

<h1>View Inbound #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'fecha_carga',
		'total_productos',
		'total_cantidad',
	),
)); ?>
