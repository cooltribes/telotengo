<?php
$this->breadcrumbs=array(
	'Preguntas'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Pregunta','url'=>array('index')),
	array('label'=>'Create Pregunta','url'=>array('create')),
	array('label'=>'Update Pregunta','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Pregunta','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Pregunta','url'=>array('admin')),
);
?>

<h1>View Pregunta #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'pregunta',
		'fecha',
		'producto_id',
		'users_id',
	),
)); ?>
