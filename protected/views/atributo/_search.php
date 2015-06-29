<?php
/* @var $this AtributoController */
/* @var $model Atributo */
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
		<?php echo $form->label($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tipo_unidad'); ?>
		<?php echo $form->textField($model,'tipo_unidad'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tipo'); ?>
		<?php echo $form->textField($model,'tipo'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'multiple'); ?>
		<?php echo $form->textField($model,'multiple'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'rango'); ?>
		<?php echo $form->textField($model,'rango'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'obligatorio'); ?>
		<?php echo $form->textField($model,'obligatorio'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->