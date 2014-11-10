<div class="container">
	<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Change Password");
	$this->breadcrumbs=array(
		'Iniciar sesión' => array('/user/login'),
		'Cambiar contraseña',
	);
	?>

	<h1><?php echo 'Cambiar contraseña'; ?></h1>


	<div class="form">
	<?php echo CHtml::beginForm(); ?>
		<?php echo CHtml::errorSummary($form); ?>
		
		<div class="row">
		<?php echo CHtml::activeLabelEx($form,'password'); ?>
		<?php echo CHtml::activePasswordField($form,'password'); ?>
		<p class="hint">
		<?php echo 'Al menos 4 caracteres'; ?>
		</p>
		</div>
		
		<div class="row">
		<?php echo CHtml::activeLabelEx($form,'verifyPassword'); ?>
		<?php echo CHtml::activePasswordField($form,'verifyPassword'); ?>
		</div>
		
		
		<div class="row submit">
		<?php echo CHtml::submitButton('Guardar'); ?>
		</div>

	<?php echo CHtml::endForm(); ?>
	</div><!-- form -->
</div>