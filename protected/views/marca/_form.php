
<div class="well">
	<div class="row padding_left_medium">
		<div class="col-md-6 1">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'marca-form',
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
	
	<div class="form-group">
		<?php echo $form->textFieldRow($model,'nombre',array('class'=>'form-control','maxlength'=>45)); ?>
	</div>
	
	<div class="form-group">
		<?php echo $form->radioButtonListInlineRow($model, 'destacado', array(1 => 'Si', 0 => 'No',)); ?>
	</div>
	<?php //echo $form->radioButtonListRow($model, 'destacado', array('Si','no',)); ?>
	
	<div class="form-group">
	<?php echo $form->textAreaRow($model,'descripcion',array('class'=>'form-control','maxlength'=>250)); ?>
	</div>
	
	<div class="form-group">
	    <label> Logotipo </label>
		<?php                      
			echo CHtml::activeFileField($model, 'Urlimagen',array('name'=>'url'));
			echo $form->error($model, 'Urlimagen'); 
		?>
    </div>
	
	 <div class="form-group">
		<?php 
			if($model->isNewRecord)
				echo '';
			else {
				echo '<label>Actual : </label>';
				echo CHtml::image(Yii::app()->request->baseUrl.'/images/marca/'.$model->id.'_thumb.jpg',"image");
			} 
		?>
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