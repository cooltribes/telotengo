<?php
$this->breadcrumbs=array(
	'Inventarios'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Inventario','url'=>array('index')),
	array('label'=>'Create Inventario','url'=>array('create')),
	array('label'=>'Update Inventario','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Inventario','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Inventario','url'=>array('admin')),
);
?>

<h1>View Inventario #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'precio',
		'cantidad',
		'almacen_id',
		'producto_id',
	),
)); ?>
