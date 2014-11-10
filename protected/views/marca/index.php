<?php
$this->breadcrumbs=array(
	'Marcas',
);

$this->menu=array(
	array('label'=>'Create Marca','url'=>array('create')),
	array('label'=>'Manage Marca','url'=>array('admin')),
);
?>

<h1>Marcas</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
