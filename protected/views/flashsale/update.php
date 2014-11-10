<?php
/* @var $this FlashsaleController */
/* @var $model Flashsale */

$this->breadcrumbs=array(
	'Flashsales'=>array('index'), 
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Flashsale', 'url'=>array('index')),
	array('label'=>'Create Flashsale', 'url'=>array('create')),
	array('label'=>'View Flashsale', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Flashsale', 'url'=>array('admin')),
);
?>

<h1>Update Flashsale <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>