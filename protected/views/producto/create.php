<?php
$this->breadcrumbs=array(
	'Productos'=>array('Admin'),
	'Agregar',
);



 echo $this->renderPartial('_form', array('model'=>$model));

?>