<?php
/* @var $this BolsaController */
/* @var $model Bolsa */

$this->breadcrumbs=array(
	'Bolsas'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Bolsa', 'url'=>array('index')),
	array('label'=>'Create Bolsa', 'url'=>array('create')),
	array('label'=>'View Bolsa', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Bolsa', 'url'=>array('admin')),
);
?>

<h1>Update Bolsa <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>