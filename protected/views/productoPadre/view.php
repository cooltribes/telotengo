<?php
/* @var $this ProductoPadreController */
/* @var $model ProductoPadre */

$this->breadcrumbs=array(
	'Producto Padres'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ProductoPadre', 'url'=>array('index')),
	array('label'=>'Create ProductoPadre', 'url'=>array('create')),
	array('label'=>'Update ProductoPadre', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ProductoPadre', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProductoPadre', 'url'=>array('admin')),
);
?>

<h1>View ProductoPadre #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
		'id_marca',
	),
)); ?>
