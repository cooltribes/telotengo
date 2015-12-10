

<?php
/* @var $this AlmacenController */
/* @var $model Almacen */

$this->breadcrumbs=array(
	'Empresas' => array('empresas/vendedoras'),
	'Almacenes'=>array('almacen/administrador/id_empresa/'.$empresa->id),
	'Crear',
);
?>

 
        <!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->

        <div class="col-md-8 col-md-offset-2" role="main">
			<h1>Crear sucursal para: <?php echo $empresa->razon_social; ?></h1>
			
<hr />
<?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>

