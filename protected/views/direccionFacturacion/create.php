<?php
$this->breadcrumbs=array(
	'Direcciones de facturación'=>array('listado'),
	'Agregar',
);
?>

<div class="form container">
	<div class="row-fluid">
		<div class="col-md-offset-3 col-md-6">
			<h1>Agregar nueva dirección de facturación</h1>
			<hr class="no_margin_top" />
			<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>
	</div>
</div>