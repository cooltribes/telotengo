<?php
$this->breadcrumbs=array(
	'Telefono Almacens'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TelefonoAlmacen','url'=>array('index')),
	array('label'=>'Create TelefonoAlmacen','url'=>array('create')),
	array('label'=>'Update TelefonoAlmacen','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete TelefonoAlmacen','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TelefonoAlmacen','url'=>array('admin')),
);
?>

<h1>View TelefonoAlmacen #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'tbl_almacen_id',
		'valor',
		'estado',
	),
)); ?>
