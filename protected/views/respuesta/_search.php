<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'comentario',array('class'=>'span5','maxlength'=>300)); ?>

	<?php echo $form->textFieldRow($model,'fecha',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'pregunta_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'users_id',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
