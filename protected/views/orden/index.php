<?php
$this->breadcrumbs=array(
	'Ordens',
);

$this->menu=array(
	array('label'=>'Create Orden','url'=>array('create')),
	array('label'=>'Manage Orden','url'=>array('admin')),
);
?>

<h1>Ordens</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
