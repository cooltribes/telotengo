<?php
$this->breadcrumbs=array(
	'Marcas'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Marca','url'=>array('index')),
	array('label'=>'Create Marca','url'=>array('create')),
	array('label'=>'View Marca','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Marca','url'=>array('admin')),
);
?>

<h1>Update Marca <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>