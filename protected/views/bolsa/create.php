<?php
/* @var $this BolsaController */
/* @var $model Bolsa */

$this->breadcrumbs=array(
	'Bolsas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Bolsa', 'url'=>array('index')),
	array('label'=>'Manage Bolsa', 'url'=>array('admin')),
);
?>

<h1>Create Bolsa</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>