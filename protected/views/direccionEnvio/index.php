<?php
$this->breadcrumbs=array(
	'Direccion Envios',
);

$this->menu=array(
	array('label'=>'Create DireccionEnvio','url'=>array('create')),
	array('label'=>'Manage DireccionEnvio','url'=>array('admin')),
);
?>

<h1>Direccion Envios</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
