<!-- CONTENIDO ON -->
     <div class="container-fluid" style="padding: 0 15px;">

<?php
$this->breadcrumbs=array(
	'Empresas'=>array('admin'),
	'Crear',
);

?>
<?php if(Yii::app()->user->hasFlash('success')){?>
	    <div class="alert in alert-block fade alert-success text_align_center">
	        <?php echo Yii::app()->user->getFlash('success'); ?>
	    </div>
	<?php } ?>
	<?php if(Yii::app()->user->hasFlash('error')){?>
	    <div class="alert in alert-block fade alert-error text_align_center">
	        <?php echo Yii::app()->user->getFlash('error'); ?>
	    </div>
	<?php } ?>

<div class="row">
        <!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->

        <div class="col-md-10  col-md-push-2 main-content" role="main">
			<h1>Empresas<small> - Solicitud</small></h1>

			<h3><?php echo '¡Bienvenido, '.$profile->first_name.' '.$profile->last_name.'!'; ?></h3>

<h6>Ingresa a continuación los datos de tu empresa.</h6>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

</div>
</div>
</div>