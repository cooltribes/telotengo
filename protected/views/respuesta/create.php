<div class="container">
	<?php
	$this->breadcrumbs=array(
		'Preguntas'=>array('Admin'),
		'Aportar Respuesta',
	);
	?>
	<div class="row-fluid">
		<div>
			
				<div class="well preguntaHeader margin_bottom"> 
					Pregunta: <?php echo $pregunta->pregunta; ?>
				</div>
				<h2 class="margin_top">Aportar Respuesta</h2><hr class="no_margin_top"/>
				<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>
	</div>
</div>
