
<div class="row-fluid">


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tipo-pago-form',
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


	
	<div class="col-md-6 col-md-offset-3">
		<?php echo $form->textFieldRow($model,'nombre',array('class'=>'form-control','maxlength'=>45)); ?>
	</div>
	
	<div class="col-md-6 col-md-offset-3 margin_top_small">
		<label> Logotipo </label>
		<?php                      
			echo CHtml::activeFileField($model, 'imagen_url',array('name'=>'url'));
			echo $form->error($model, 'imagen_url'); 
		?>
   </div>
    
   
		<?php 
			if(!$model->isNewRecord): ?>
	 <div  class="col-md-6 col-md-offset-3 margin_small">
        <?php
				echo '<label> Actual </label>';
				echo CHtml::image(Yii::app()->request->baseUrl.'/images/tipopago/'.$model->id.'_thumb.jpg',"image");
                
         ?>       
	</div>
	<?php	endif; ?>
	
	
	<div class="col-md-6 col-md-offset-3 margin_top_small">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Guardar',
			 'htmlOptions'=>array('class'=>'form-control')
		)); ?>
	</div>
	

	</div>

<?php $this->endWidget(); ?>
