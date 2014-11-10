<?php
$this->breadcrumbs=array(
	'Tipo Pagos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TipoPago','url'=>array('index')),
	array('label'=>'Create TipoPago','url'=>array('create')),
	array('label'=>'View TipoPago','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage TipoPago','url'=>array('admin')),
);
?>

<h1>Update TipoPago <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>