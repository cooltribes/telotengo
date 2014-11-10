<?php
$this->breadcrumbs=array(
	'Direccion Envios'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List DireccionEnvio','url'=>array('index')),
	array('label'=>'Create DireccionEnvio','url'=>array('create')),
	array('label'=>'Update DireccionEnvio','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete DireccionEnvio','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DireccionEnvio','url'=>array('admin')),
);
?>

<h1>View DireccionEnvio #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'telefono',
		'direccion_1',
		'direccion_2',
		'ciudad_id',
		'provincia_id',
		'users_id',
	),
)); ?>
