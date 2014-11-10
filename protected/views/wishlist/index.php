<?php
$this->breadcrumbs=array(
	'Wishlists',
);

$this->menu=array(
	array('label'=>'Create Wishlist','url'=>array('create')),
	array('label'=>'Manage Wishlist','url'=>array('admin')),
);
?>

<h1>Wishlists</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
