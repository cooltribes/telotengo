<?php
$this->breadcrumbs=array(
	'Marcas'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Marca','url'=>array('index')),
	array('label'=>'Create Marca','url'=>array('create')),
	array('label'=>'Update Marca','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Marca','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Marca','url'=>array('admin')),
);
?>

<h1>View Marca #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
		'destacado',
	),
)); ?>
