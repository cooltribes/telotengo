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
	
	<div class="col-md-12 "> 
		<?php echo $form->textAreaRow($model,'comentario',array('class'=>'form-control no_resize','maxlength'=>300)); ?>
	</div>
	
	<div class="col-md-2 col-md-offset-10 margin_top_small">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Responder',
			'htmlOptions'=>array('class'=>'row-fluid')
		)); ?>
	</div>

<?php $this->endWidget(); ?>
