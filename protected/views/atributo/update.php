<div class="container">
<?php
/* @var $this AtributoController */
/* @var $model Atributo */


$this->breadcrumbs=array(
	'Atributos'=>array('index'),
	'Update',
);


?>

	<div class="row-fluid">
	<!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->

    <div>
	       <h1>Actualizar <?php echo $model->nombre; ?></h1>

<?php 
	if($model->tipo==3) /// son vistas distintas
		echo $this->renderPartial('actualizar', array('model'=>$model));
	else 
		echo $this->renderPartial('_form', array('model'=>$model));
	

?>

	</div>
	</div>
</div>



