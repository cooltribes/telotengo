<div class="form-horizontal margin_top" role="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
));
?>

	<?php echo $form->errorSummary(array($model,$profile)); ?>


	<div class="form-group">
		<div class="col-sm-12">
			<?php echo $form->labelEx($model,'email'); ?>
			<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'email'); ?>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-12">
			<?php echo $form->labelEx($model,'type'); ?>
			<?php echo $form->dropDownList($model,'type',User::itemAlias('UserType'),array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'type'); ?>
		</div>
	</div>

	<div class="form-group">
	
		<div class="form-actions col-sm-offset-2 col-sm-10 no_margin">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=> 'Invitar',
			)); ?>
		</div> 

	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->