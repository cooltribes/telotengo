<?php
$this->breadcrumbs=array(
	'Productos'=>array('Admin'),
	'Agregar',
);

?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>