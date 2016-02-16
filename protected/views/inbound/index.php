<?php
/* @var $this InboundController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Inbounds',
);

$this->menu=array(
	array('label'=>'Create Inbound', 'url'=>array('create')),
	array('label'=>'Manage Inbound', 'url'=>array('admin')),
);
?>

<h1>Inbounds</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
