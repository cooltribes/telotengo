<?php
$this->breadcrumbs=array(
	'Direcciones de facturación'=>array('listado'),
	'Agregar',
);

?>

<div class="form container">
	<div class="row">
		<div class="col-md-offset-3 col-md-5">
			<h1>Agregar nueva dirección de facturación</h1>

			<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>
	</div>
</div>