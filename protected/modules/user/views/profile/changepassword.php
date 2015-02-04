<?php $this->pageTitle=Yii::app()->name . ' - Cambiar contraseña';
$this->breadcrumbs=array(
	UserModule::t("Profile") => array('/user/profile'),
	'Cambiar contraseña',
);
?>
<div class="form container">
	<div class="row">
		<div class="col-md-offset-3 col-md-5">
			<h1><?php echo UserModule::t("Cambiar contraseña"); ?></h1>

			<hr class="no_margin_top" />

			<?php if(Yii::app()->user->hasFlash('success')){?>
			    <div class="alert in alert-block fade alert-success text_align_center">
			        <?php echo Yii::app()->user->getFlash('success'); ?>
			    </div>
			<?php } ?>
			<?php if(Yii::app()->user->hasFlash('error')){?>
			    <div class="alert in alert-block fade alert-dabger text_align_center">
			        <?php echo Yii::app()->user->getFlash('error'); ?>
			    </div> 
			<?php } ?>

			<div class="form">
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'changepassword-form',
					'enableAjaxValidation'=>false,
					'clientOptions'=>array(
						'validateOnSubmit'=>true,
					),
					'htmlOptions' => array('enctype'=>'multipart/form-data','class'=>'form-horizontal','role'=>"form"),
				)); ?>

					<?php echo $form->errorSummary($model); ?>

					<div class="form-group">
						<?php echo $form->labelEx($model,'oldPassword'); ?>
						<?php echo $form->passwordField($model,'oldPassword',array('class'=>'form-control','placeholder'=>'Contraseña anterior')); ?>
						<?php echo $form->error($model,'oldPassword'); ?>
					</div>

					<div class="form-group">
						<?php echo $form->labelEx($model,'password'); ?>
						<?php echo $form->passwordField($model,'password',array('class'=>'form-control','placeholder'=>'Nueva contraseña')); ?>
						<?php echo $form->error($model,'password'); ?>
						<p class="hint">
							<?php echo UserModule::t("Al menos 4 caracteres"); ?>
						</p>
					</div>

					<div class="form-group">
						<?php echo $form->labelEx($model,'verifyPassword'); ?>
						<?php echo $form->passwordField($model,'verifyPassword',array('class'=>'form-control','placeholder'=>'Repita la nueva contraseña')); ?>
						<?php echo $form->error($model,'verifyPassword'); ?>
					</div>


					<div class="submit">
						<?php echo CHtml::submitButton(UserModule::t("Guardar"), array('class'=>'btn btn-danger btn-lg form-control')); ?>
					</div>

				<?php $this->endWidget(); ?>
			</div><!-- form -->
		</div>
	</div>
</div>