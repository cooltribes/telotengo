<!-- CONTENIDO ON -->
     <div class="container-fluid" style="padding: 0 15px;">
     	
<?php
$this->breadcrumbs=array(
	'Venta Flash'=>array('admin'),
	'Crear',
);

?>	
      <div class="row">
        <!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->

        <div class="col-md-10  col-md-push-2 main-content" role="main">
			<h1>Venta Flash<small> - Nueva</small></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'producto'=>$producto,'codigo'=>$codigo, 'inventario'=>$inventario)); ?>

</div>
</div>
</div>

<!-- COLUMNA PRINCIPAL DERECHA OFF // -->