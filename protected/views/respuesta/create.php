<div class="form container">
<?php
$this->breadcrumbs=array(
	'Preguntas'=>array('Admin'),
	'Aportar Respuesta',
);

?>
<div class="row">
		<div class="col-md-offset-3 col-md-5">
			<h2>Aportar Respuesta</h2>
				<div>
				Pregunta: <?php echo $pregunta->pregunta; ?>
				</div>

				<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

		</div>
	</div>
</div>
