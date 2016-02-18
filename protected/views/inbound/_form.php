<?php
/* @var $this InboundController */
/* @var $model Inbound */
/* @var $form CActiveForm */
?>

<div class="form"> 

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'inbound-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha_carga'); ?>
		<?php echo $form->textField($model,'fecha_carga'); ?>
		<?php echo $form->error($model,'fecha_carga'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'total_productos'); ?>
		<?php echo $form->textField($model,'total_productos'); ?>
		<?php echo $form->error($model,'total_productos'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'total_cantidad'); ?>
		<?php echo $form->textField($model,'total_cantidad'); ?>
		<?php echo $form->error($model,'total_cantidad'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->