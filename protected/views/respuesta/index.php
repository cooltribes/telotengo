<?php
$this->breadcrumbs=array(
	'Respuestas',
);

$this->menu=array(
	array('label'=>'Create Respuesta','url'=>array('create')),
	array('label'=>'Manage Respuesta','url'=>array('admin')),
);
?>

<h1>Respuestas</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
