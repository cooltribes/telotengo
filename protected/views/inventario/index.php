<?php
$this->breadcrumbs=array(
	'Inventarios',
);

$this->menu=array(
	array('label'=>'Create Inventario','url'=>array('create')),
	array('label'=>'Manage Inventario','url'=>array('admin')),
);
?>

<h1>Inventarios</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
