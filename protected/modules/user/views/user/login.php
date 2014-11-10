<div class="container">
	<?php
		$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Login");
		$this->breadcrumbs=array(
			UserModule::t("Login"),
		);
	?>
	<div class="row">
		<div class="col-md-offset-4 col-md-4">
			<h1><?php echo UserModule::t("Login"); ?></h1>

			<?php if(Yii::app()->user->hasFlash('loginMessage')): ?>

			<div class="alert in alert-block fade alert-success text_align_center">
				<?php echo Yii::app()->user->getFlash('loginMessage'); ?>
			</div>

			<?php endif; ?>

			<p><?php echo 'Por favor complete el formulario con los datos de su cuenta'; ?></p>
			<div class="form ">
				<?php echo CHtml::beginForm(); ?>
				
				<?php echo CHtml::errorSummary($model); ?>
				
				<div class="form-group">
					<?php echo CHtml::activeLabelEx($model,'username'); ?>
					<?php echo CHtml::activeTextField($model,'username', array('class'=>'form-control','placeholder'=>'Nombre de usuario o correo electrónico') ) ?>
				</div>
				
				<div class="form-group">
					<?php echo CHtml::activeLabelEx($model,'password'); ?>
					<?php echo CHtml::activePasswordField($model,'password', array('class'=>'form-control','placeholder'=>'Contraseña') ) ?>
				</div>
				
				<div class="help-block">
					<p class="hint">
					<?php echo CHtml::link("Registro",Yii::app()->getModule('user')->registrationUrl); ?> | <?php echo CHtml::link("Olvidé mi contraseña",Yii::app()->getModule('user')->recoveryUrl); ?>
					</p>
				</div>
				
				<div class="checkbox rememberMe">
					<?php echo CHtml::activeCheckBox($model,'rememberMe'); ?>
					<?php echo CHtml::activeLabelEx($model,'rememberMe'); ?>
				</div>

				<div class="submit">
					<?php echo CHtml::submitButton("Iniciar sesión", array('class'=>'btn btn-default')); ?>
				</div>
				
				<?php echo CHtml::endForm(); ?>
			</div><!-- form -->
		</div>
	</div>
</div>

<?php
$form = new CForm(array(
    'elements'=>array(
        'username'=>array(
            'type'=>'text',
            'maxlength'=>32,
        ),
        'password'=>array(
            'type'=>'password',
            'maxlength'=>32,
        ),
        'rememberMe'=>array(
            'type'=>'checkbox',
        )
    ),

    'buttons'=>array(
        'login'=>array(
            'type'=>'submit',
            'label'=>'Login',
        ),
    ),
), $model);
?>