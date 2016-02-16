<?php
/* @var $this InboundController */
/* @var $model Inbound */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha_carga'); ?>
		<?php echo $form->textField($model,'fecha_carga'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'total_productos'); ?>
		<?php echo $form->textField($model,'total_productos'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'total_cantidad'); ?>
		<?php echo $form->textField($model,'total_cantidad'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->