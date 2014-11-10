<?php
$this->breadcrumbs=array(
	'Datos Contactos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List DatosContacto','url'=>array('index')),
	array('label'=>'Create DatosContacto','url'=>array('create')),
	array('label'=>'View DatosContacto','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage DatosContacto','url'=>array('admin')),
);
?>

<h1>Update DatosContacto <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>