<?php
$this->breadcrumbs=array(
	'Inventarios'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Inventario','url'=>array('index')),
	array('label'=>'Manage Inventario','url'=>array('admin')),
);
?>

<h1>Create Inventario</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>