<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'wishlist-form',
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
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('class'=>'form-control','maxlength'=>65)); ?>
		<?php echo $form->error($model, 'nombre'); ?>
	</div>
	
	<?php echo $form->hiddenField($model,'users_id',array('type'=>"hidden",'value'=>Yii::app()->user->id)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Guardar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
