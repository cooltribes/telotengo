

	<div class="row-fluid padding_left_medium">

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

	<?php // echo $form->errorSummary($model,array('class'=>'classificado')); ?>

	<div class="col-md-6 col-md-offset-3">
		<?php echo $form->textFieldRow($model,'nombre',array('class'=>'form-control','maxlength'=>45)); ?>
	</div>
	
	<div class="col-md-6 col-md-offset-3 lineRadios margin_top_small">
		<?php echo $form->radioButtonListInlineRow($model, 'destacado', array(1 => 'Si', 0 => 'No',)); ?>
	</div>
	<?php //echo $form->radioButtonListRow($model, 'destacado', array('Si','no',)); ?>
	
	<div class="col-md-6 col-md-offset-3 margin_top_small" >
	<?php echo $form->textAreaRow($model,'descripcion',array('class'=>'form-control no_resize','maxlength'=>250)); ?>
	</div>
	
	<div class="col-md-6 col-md-offset-3 margin_top_small">
	    <label> Logo </label>
		<?php                      
			echo CHtml::activeFileField($model, 'Urlimagen',array('name'=>'url'));
			echo $form->error($model, 'Urlimagen'); 
		?>
    </div>
	<?php 
			if(!$model->isNewRecord):?>
	 <div class="col-md-6 col-md-offset-3 margin_top_medium">
		
	<?php		echo '<label>Actual : </label>';
				echo CHtml::image(Yii::app()->request->baseUrl.'/images/marca/'.$model->id.'_thumb.jpg',"image");
        ?>    
        
        </div> 
          <?php  endif; 
		?>
	
	
	<div class="col-md-6 col-md-offset-3 margin_top_medium">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Guardar',
			'htmlOptions'=>array('class'=>'form-control')
		)); ?>
	</div>
	
<?php $this->endWidget(); ?>


	</div>
