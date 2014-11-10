<div class="well">
	<div class="row padding_left_medium">
		<div class="col-md-6 1">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'datos-pago-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'type'=>'horizontal',
	'clientOptions'=>array(
		'validateOnSubmit'=>true, 
	),
	'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
)); ?>

	<?php echo $form->errorSummary($model); ?>
	
	<?php 
	$empresa = new Empresas;
	$data = $empresa->empresasUser();
	$array = Array();
	
	foreach($data->getData() as $each){
		$array [] = Array('id'=>$each['id'],'razon'=>$each['razon_social']);
	}
		
	?>	 
	
	<div class="form-group">
		<?php echo $form->labelEx($model,'empresa_id'); ?> 
		<?php echo $form->dropDownList($model,'empresa_id', CHtml::listData($array, 'id', 'razon'),array('class'=>'form-control','prompt'=>'Seleccione.')); ?>
		<?php echo $form->error($model,'empresa_id'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'numero'); ?>
		<?php echo $form->textField($model,'numero',array('class'=>'form-control','maxlength'=>80)); ?>
		<?php echo $form->error($model,'numero'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'rif'); ?>
		<?php echo $form->textField($model,'rif',array('class'=>'form-control','maxlength'=>80,'placeholder'=>"En caso de agregar una cuenta ingrese aquí el RIF.")); ?>
		<?php echo $form->error($model,'rif'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'banco'); ?>
		<?php echo $form->textField($model,'banco',array('class'=>'form-control','maxlength'=>80,'placeholder'=>"En caso de agregar una cuenta ingrese aquí el Banco correspondiente.")); ?>
		<?php echo $form->error($model,'banco'); ?>
	</div>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Guardar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

	</div>
	</div>
	</div>