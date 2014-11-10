<?php
$this->breadcrumbs=array(
	'Wishlists'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Wishlist','url'=>array('index')),
	array('label'=>'Create Wishlist','url'=>array('create')),
	array('label'=>'Update Wishlist','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Wishlist','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Wishlist','url'=>array('admin')),
);
?>

<h1>View Wishlist #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
		'users_id',
	),
)); ?>
