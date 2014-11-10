<?php
$this->breadcrumbs=array(
	'Telefono Almacens'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TelefonoAlmacen','url'=>array('index')),
	array('label'=>'Manage TelefonoAlmacen','url'=>array('admin')),
);
?>

<h1>Create TelefonoAlmacen</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>