<?php
$this->breadcrumbs=array(
	'Direccion Facturacions'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List DireccionFacturacion','url'=>array('index')),
	array('label'=>'Create DireccionFacturacion','url'=>array('create')),
	array('label'=>'Update DireccionFacturacion','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete DireccionFacturacion','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DireccionFacturacion','url'=>array('admin')),
);
?>

<h1>View DireccionFacturacion #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'telefono',
		'direccion_1',
		'direccion_2',
		'users_id',
		'provincia_id',
		'ciudad_id',
	),
)); ?>
