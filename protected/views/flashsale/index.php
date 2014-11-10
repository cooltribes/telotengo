<?php
/* @var $this FlashsaleController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Flashsales',
); 

$this->menu=array(
	array('label'=>'Create Flashsale', 'url'=>array('create')),
	array('label'=>'Manage Flashsale', 'url'=>array('admin')),
);
?>

<h1>Flashsales</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
