<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'nombre',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'mail',array('class'=>'span5','maxlength'=>85)); ?>

	<?php echo $form->textFieldRow($model,'razon_social',array('class'=>'span5','maxlength'=>205)); ?>

	<?php echo $form->textFieldRow($model,'rif',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'direccion',array('class'=>'span5','maxlength'=>350)); ?>

	<?php echo $form->textFieldRow($model,'web',array('class'=>'span5','maxlength'=>55)); ?>

	<?php echo $form->textFieldRow($model,'estado',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'destacado',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
