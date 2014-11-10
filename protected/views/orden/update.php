<?php
$this->breadcrumbs=array(
	'Ordens'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Orden','url'=>array('index')),
	array('label'=>'Create Orden','url'=>array('create')),
	array('label'=>'View Orden','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Orden','url'=>array('admin')),
);
?>

<h1>Update Orden <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>