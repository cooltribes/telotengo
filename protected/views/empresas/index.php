<?php
$this->breadcrumbs=array(
	'Empresases',
);

$this->menu=array(
	array('label'=>'Create Empresas','url'=>array('create')),
	array('label'=>'Manage Empresas','url'=>array('admin')),
);
?>

<h1>Empresases</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
