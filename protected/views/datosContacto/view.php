<?php
$this->breadcrumbs=array(
	'Datos Contactos'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List DatosContacto','url'=>array('index')),
	array('label'=>'Create DatosContacto','url'=>array('create')),
	array('label'=>'Update DatosContacto','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete DatosContacto','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DatosContacto','url'=>array('admin')),
);
?>

<h1>View DatosContacto #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'empresa_id',
		'tipo_id',
		'valor',
		'estado',
	),
)); ?>
