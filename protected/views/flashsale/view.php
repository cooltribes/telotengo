<?php
/* @var $this FlashsaleController */
/* @var $model Flashsale */

$this->breadcrumbs=array( 
	'Flashsales'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Flashsale', 'url'=>array('index')),
	array('label'=>'Create Flashsale', 'url'=>array('create')),
	array('label'=>'Update Flashsale', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Flashsale', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Flashsale', 'url'=>array('admin')),
);
?> 

<h1>View Flashsale #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'cantidad',
		'descuento',
		'fecha_inicio',
		'fecha_fin',
		'estado',
		'inventario_id',
	),
)); ?>
