<!-- CONTENIDO ON -->
<div class="container">
	<?php
	$this->breadcrumbs=array(
		'Venta Flash'=>array('admin'),
		'Crear',
	);
	?>	
	<div class="row-fluid">
        <!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->
		<div>
			<h1>Venta Flash<small> - Aplicar Nueva</small></h1>

			<?php echo $this->renderPartial('_form', array('model'=>$model,'producto'=>$producto,'codigo'=>$codigo, 'inventario'=>$inventario)); ?>

		</div>
	</div>
</div>
<!-- COLUMNA PRINCIPAL DERECHA OFF // -->