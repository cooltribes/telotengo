<?php
/* @var $this BolsaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Bolsas',
);

$this->menu=array(
	array('label'=>'Create Bolsa', 'url'=>array('create')),
	array('label'=>'Manage Bolsa', 'url'=>array('admin')),
);
?>

<h1>Bolsas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
