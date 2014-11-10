<?php
/* @var $this AlmacenController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Almacens',
);

$this->menu=array(
	array('label'=>'Create Almacen', 'url'=>array('create')),
	array('label'=>'Manage Almacen', 'url'=>array('admin')),
);
?>

<h1>Almacens</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
