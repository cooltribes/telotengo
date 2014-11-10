<?php
$this->breadcrumbs=array(
	'Datos Contactos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List DatosContacto','url'=>array('index')),
	array('label'=>'Manage DatosContacto','url'=>array('admin')),
);
?>

<h1>Create DatosContacto</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>