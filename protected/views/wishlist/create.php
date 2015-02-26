<div class="form container">
<h1>Crear lista de deseos</h1>
            <hr class="no_margin_top" />	
<?php
$this->breadcrumbs=array(
	'Wishlist'=>array('listado'),
	'Agregar',
);

?>	
	<div class="row-fluid">
		<div class="col-md-offset-3 col-md-6">
			
			<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>
	</div>
</div>



