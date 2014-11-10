<?php
$this->breadcrumbs=array(
	'Direccion Facturacions',
);

$this->menu=array(
	array('label'=>'Create DireccionFacturacion','url'=>array('create')),
	array('label'=>'Manage DireccionFacturacion','url'=>array('admin')),
);
?>

<h1>Direccion Facturacions</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
