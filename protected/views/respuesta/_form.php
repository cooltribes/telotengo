<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'respuesta-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'type'=>'horizontal',
	'clientOptions'=>array(
		'validateOnSubmit'=>true, 
	),
	'htmlOptions'=>array('class'=>'form-horizontal','role'=>"form"),
)); ?>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="form-group"> 
		<?php echo $form->textAreaRow($model,'comentario',array('class'=>'span5','maxlength'=>300)); ?>
	</div>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Responder',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
