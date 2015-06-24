<!-- CONTENIDO ON -->
<div class="container">
     	
<?php
$this->breadcrumbs=array( 
	'Categorias'=>array('admin'),
	'Crear',
);

?>
	<div class="row-fluid">
	<!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->

    <div>
	       <h1><?php echo $model->isNewRecord ? 'Crear Categoría' : 'Categoría - <small>'.$model->nombre.'</small>'; ?></h1><hr class="no_margin_top"/>

<?php echo $this->renderPartial('menu', array('model'=>$model,'opcion'=>1)); ?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

</div>
</div>
</div>

<!-- COLUMNA PRINCIPAL DERECHA OFF // -->