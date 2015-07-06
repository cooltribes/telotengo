<div class="container">
<?php
/* @var $this ColorController */
/* @var $model Color */

$this->breadcrumbs=array(
	'Colores'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Actualizar',
);


?>
	<div class="row-fluid">
	<!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->

    <div>
		<h1>Actualizar<?php echo $model->nombre; ?></h1>

		<?php $this->renderPartial('_form', array('model'=>$model)); ?>
	</div>
	</div>
</div>