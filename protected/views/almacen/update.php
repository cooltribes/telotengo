<?php
if(Yii::app()->user->isAdmin())
{
	$this->breadcrumbs=array(
	'Sucursal' => array('almacen/admin'),
	'Editar Sucursal',
	);
}
else
{
	$this->breadcrumbs=array(
	'Sucursal' => array('almacen/administrador'),
	'Editar Sucursal',
	);
}


?>
<div class="container">
<h1>Editar sucursal para: <?php echo $model->empresas->razon_social; ?></h1>
	<hr/>
	<?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>