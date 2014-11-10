<?php
$this->breadcrumbs=array(
	'Preguntas',
);

$this->menu=array(
	array('label'=>'Create Pregunta','url'=>array('create')),
	array('label'=>'Manage Pregunta','url'=>array('admin')),
);
?>

<h1>Preguntas</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
