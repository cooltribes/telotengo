<?php
$this->breadcrumbs=array(
	'Almacen' => array('almacen/admin'),
	'Editar Sucursal',
);

?>
<div class="container">
<h1>Editar sucursal para: <?php echo $model->empresas->razon_social; ?></h1>
	<hr/>
	<?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>