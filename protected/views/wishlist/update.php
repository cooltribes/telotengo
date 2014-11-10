<?php
$this->breadcrumbs=array(
	'Wishlists'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Wishlist','url'=>array('index')),
	array('label'=>'Create Wishlist','url'=>array('create')),
	array('label'=>'View Wishlist','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Wishlist','url'=>array('admin')),
);
?>

<h1>Update Wishlist <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>