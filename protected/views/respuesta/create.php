<div class="container">
	<?php
	$this->breadcrumbs=array(
		'Preguntas'=>array('pregunta/admin'),
		'Aportar Respuesta',
	);
	?>
	<div class="row-fluid">
		<div>
			<h2>Aportar Respuesta</h2>
				<div>
					Pregunta: <?php echo $pregunta->pregunta; ?>
				</div>
				<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>
	</div>
</div>
