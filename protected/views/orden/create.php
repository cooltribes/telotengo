<?php
$this->breadcrumbs=array(
	'Ordens'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Orden','url'=>array('index')),
	array('label'=>'Manage Orden','url'=>array('admin')),
);
?>

<h1>Create Orden</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>