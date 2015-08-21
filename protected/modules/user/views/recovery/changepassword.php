<div class="container">
	<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Change Password");
	
	if($_GET['solicitud']=="nueva")
		$mensaje="Crea tu Contraseña";
	else
		$mensaje="Cambiar contraseña";
	
	$this->breadcrumbs=array(
		'Iniciar sesión' => array('/user/login'),
		$mensaje
	);
	?>
	
    <h1><?php echo $mensaje; ?></h1>
    <hr class="no_margin_top"/>
<div class="row-fluid">



	<div class="form">
	<?php echo CHtml::beginForm(); ?>
		<?php echo CHtml::errorSummary($form); ?>
		
		<div class="col-md-6 col-md-offset-3">
		<?php echo CHtml::activeLabelEx($form,'password'); ?><br/>
		<?php echo CHtml::activePasswordField($form,'password', array('class'=>'form-control')); ?>
		<p class="hint">
		<small><?php echo 'Al menos 4 caracteres'; ?></small>
		</p>
		</div>
		
		<div class="col-md-6 col-md-offset-3">
		<?php echo CHtml::activeLabelEx($form,'verifyPassword'); ?><br/>
		<?php echo CHtml::activePasswordField($form,'verifyPassword', array('class'=>'form-control')); ?>
		</div>
		
		
		<div class="col-md-6 col-md-offset-3">
		<?php echo CHtml::submitButton('Guardar',array('class'=>'btn btn-danger form-control margin_top')); ?>
		</div>

	<?php echo CHtml::endForm(); ?>
	</div><!-- form -->
</div>

</div>