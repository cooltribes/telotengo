<?php
$this->breadcrumbs=array(
	'Telefono Almacens'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TelefonoAlmacen','url'=>array('index')),
	array('label'=>'Create TelefonoAlmacen','url'=>array('create')),
	array('label'=>'View TelefonoAlmacen','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage TelefonoAlmacen','url'=>array('admin')),
);
?>

<h1>Update TelefonoAlmacen <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>