<div class="form container">
	
<?php
$this->breadcrumbs=array(
	'Wishlist'=>array('listado'),
	'Agregar',
);

?>	
	<div class="row">
		<div class="col-md-offset-3 col-md-5">
			<h1>Crear Lista de deseos</h1>

			<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>
	</div>
</div>



