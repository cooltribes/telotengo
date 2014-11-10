<?php
$this->breadcrumbs=array(
	'Telefono Almacens',
);

$this->menu=array(
	array('label'=>'Create TelefonoAlmacen','url'=>array('create')),
	array('label'=>'Manage TelefonoAlmacen','url'=>array('admin')),
);
?>

<h1>Telefono Almacens</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
