<?php
$this->breadcrumbs=array(
	'Empresases'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Empresas','url'=>array('index')),
	array('label'=>'Create Empresas','url'=>array('create')),
	array('label'=>'Update Empresas','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Empresas','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Empresas','url'=>array('admin')),
);
?>

<h1>View Empresas #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
		'mail',
		'razon_social',
		'rif',
		'direccion',
		'telefono',
		'web',
		'estado',
		'destacado',
	),
)); ?>
