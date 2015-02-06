<div class="container">
	<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Restore");
	$this->breadcrumbs=array(
		'Iniciar sesión' => array('/user/login'),
		'Recuperar contraseña',
	);
	?>

	<h1><?php echo 'Recuperfar contraseña'; ?></h1>  

	<?php if(Yii::app()->user->hasFlash('recoveryMessage')): ?>
	<div class="success">
	<?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
	</div>
	<?php else: ?>

	<div class="form">
	<?php echo CHtml::beginForm(); ?>

		<?php echo CHtml::errorSummary($form); ?>
		
		<div class="row">
			<?php echo CHtml::activeLabel($form,'login_or_email'); ?>
			<?php echo CHtml::activeTextField($form,'login_or_email') ?>
			<p class="hint"><?php echo 'Por favor ingrese su nombre de usuario o correo electrónico'; ?></p>
		</div>
		
		<div class="row submit">
			<?php echo CHtml::submitButton('Recuperar'); ?>
		</div>

	<?php echo CHtml::endForm(); ?>
	</div><!-- form -->
	<?php endif; ?>
</div>