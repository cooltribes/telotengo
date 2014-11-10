<?php
$this->breadcrumbs=array(
	'Tipo Pagos'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TipoPago','url'=>array('index')),
	array('label'=>'Create TipoPago','url'=>array('create')),
	array('label'=>'Update TipoPago','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete TipoPago','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TipoPago','url'=>array('admin')),
);
?>

<h1>View TipoPago #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
	),
)); ?>
