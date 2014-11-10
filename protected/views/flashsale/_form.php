<?php
/* @var $this FlashsaleController */
/* @var $model Flashsale */
/* @var $form CActiveForm */
?>

<div class="well">
	<div class="row padding_left_medium">
		<div class="col-md-6 1">


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'flashsale-form',
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
	
	<p class="note">Los campos marcados con <span class="required">*</span> son obligatorios.</p>

	<div class="form-group">
		<?php 

		    $principal = Imagenes::model()->findByAttributes(array('orden'=>1,'producto_id'=>$producto->id));
		    							
		    if($principal->getUrl()) 
		    	echo CHtml::image(str_replace(".","_x180.",$principal->getUrl()), "Imagen ", array());
		   
		    $marca = Marca::model()->findByPk($producto->marca_id);
				
			echo "<p><strong>".$producto->nombre." por <small>".$marca->nombre."</small></strong></p>
					<p>Descripción del producto: ".$producto->descripcion."
					</p>";								
			echo '<p><b> Precio Actual:</b> '.$inventario->precio.' Bs.</p>';
			echo $codigo;
			
		?>   
	</div>
	
	<div class="form-group"> 
		<?php echo $form->labelEx($model,'cantidad'); ?>
		<?php echo $form->textField($model,'cantidad',array('class'=>'form-control','maxlength'=>10,'placeholder'=>'Cantidad disponible para la Venta Flash.')); ?>
		<?php echo $form->error($model,'cantidad'); ?>
	</div>
	
	<div class="form-group">
		<?php echo $form->labelEx($model,'descuento'); ?>
		<?php echo $form->textField($model,'descuento',array('class'=>'form-control','placeholder'=>'Descuento a aplicar sobre el producto.')); ?>
		<?php echo $form->error($model,'descuento'); ?>
	</div>
	
	<div class="form-group">
    	<?php echo $form->labelEx($model,'fecha_inicio'); ?>
			<?php 
				$this->widget('application.extensions.timepicker.timepicker', array(
				    'model'=>$model,
				    'name'=>'fecha_inicio',
				    // 'options'=>array('dateFormat'=>'dd-mm-yy'), // jquery plugin options
				    
				));
			?>
		<?php echo $form->error($model,'fecha_inicio'); ?>
    </div>

    	<?php /*becho $form->labelEx($model,'fecha_inicio'); 
		 echo $form->textField($model,'fecha_inicio',array('class'=>'form-control')); 
		 echo $form->error($model,'fecha_inicio'); */ ?>

	<div class="form-group">
    	<?php echo $form->labelEx($model,'fecha_fin'); ?>
			<?php 
				$this->widget('application.extensions.timepicker.timepicker', array(
				    'model'=>$model,
				    'name'=>'fecha_fin',
				   //  'options'=>array('dateFormat'=>'dd-mm-yy'), // jquery plugin options
				     
				));
			?>
		<?php echo $form->error($model,'fecha_fin'); ?>  
    </div>
	
		<?php /* echo $form->labelEx($model,'fecha_fin'); 
		echo $form->textField($model,'fecha_fin',array('class'=>'form-control')); 
		echo $form->error($model,'fecha_fin'); */ ?>
	
	<div class="form-group">
	   	<?php // echo $form->labelEx($model,'estado'); ?> 
		<?php // echo $form->textField($model,'estado',array('class'=>'form-control')); ?>
		<?php echo $form->radioButtonListRow($model,'estado', array(1 => 'Activo', 0 => 'Inactivo',)); ?>
		<?php echo $form->error($model,'estado'); ?>
    </div>
   
	<?php // echo $form->textField($model,'inventario_id',array('class'=>'form-control')); ?>
	<?php echo $form->hiddenField($model,'inventario_id',array('type'=>"hidden",'value'=>$inventario->id)); ?>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Guardar',
		)); ?>
	</div>
	
	
	</div>
	</div>
	</div>


<?php $this->endWidget(); ?>

