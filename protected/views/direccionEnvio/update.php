<?php
$this->breadcrumbs=array(
	'Direccion Envios'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List DireccionEnvio','url'=>array('index')),
	array('label'=>'Create DireccionEnvio','url'=>array('create')),
	array('label'=>'View DireccionEnvio','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage DireccionEnvio','url'=>array('admin')),
);
?>

<h1>Update DireccionEnvio <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>