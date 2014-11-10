<?php
$this->breadcrumbs=array(
	'Inventarios'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Inventario','url'=>array('index')),
	array('label'=>'Create Inventario','url'=>array('create')),
	array('label'=>'View Inventario','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Inventario','url'=>array('admin')),
);
?>

<h1>Update Inventario <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>