<!-- CONTENIDO ON -->
     <div class="container-fluid" style="padding: 0 15px;">
     	
<?php
$this->breadcrumbs=array(
	'Categorias'=>array('admin'),
	'Crear',
);

?>	
      <div class="row">
        <!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->

        <div class="col-md-10  col-md-push-2 main-content" role="main">
			<h1>Categoría<small> - Nueva</small></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

</div>
</div>
</div>

<!-- COLUMNA PRINCIPAL DERECHA OFF // -->