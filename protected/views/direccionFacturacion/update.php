<?php
$this->breadcrumbs=array(
	'Direccion Facturacions'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List DireccionFacturacion','url'=>array('index')),
	array('label'=>'Create DireccionFacturacion','url'=>array('create')),
	array('label'=>'View DireccionFacturacion','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage DireccionFacturacion','url'=>array('admin')),
);
?>

<h1>Update DireccionFacturacion <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>