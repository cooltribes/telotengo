<?php
$this->breadcrumbs=array(
	'Tipo Pagos',
);

$this->menu=array(
	array('label'=>'Create TipoPago','url'=>array('create')),
	array('label'=>'Manage TipoPago','url'=>array('admin')),
);
?>

<h1>Tipo Pagos</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
