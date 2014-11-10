<!-- CONTENIDO ON -->
     <div class="container-fluid" style="padding: 0 15px;">

<?php
/* @var $this AlmacenController */
/* @var $model Almacen */

$this->breadcrumbs=array(
	'Empresas' => array('empresas/vendedoras'),
	'Sucursales'=>array('almacen/listado/id_empresa/'.$empresa->id),
	'Crear',
);
?>

<div class="row">
        <!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->

        <div class="col-md-10  col-md-push-2 main-content" role="main">
			<h1>Crear sucursal para: <?php echo $empresa->razon_social; ?></h1>
			
<hr />
<?php $this->renderPartial('_form', array('model'=>$model)); ?>

</div>
</div>
</div>