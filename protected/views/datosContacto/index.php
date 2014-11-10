<?php
$this->breadcrumbs=array(
	'Datos Contactos',
);

$this->menu=array(
	array('label'=>'Create DatosContacto','url'=>array('create')),
	array('label'=>'Manage DatosContacto','url'=>array('admin')),
);
?>

<h1>Datos Contactos</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
