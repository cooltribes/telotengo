<?php
/* @var $this AtributoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Atributos',
);

$this->menu=array(
	array('label'=>'Create Atributo', 'url'=>array('create')),
	array('label'=>'Manage Atributo', 'url'=>array('admin')),
);
?>

<h1>Atributos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
