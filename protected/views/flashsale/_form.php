<?php
/* @var $this FlashsaleController */
/* @var $model Flashsale */
/* @var $form CActiveForm */
?>

	<div class="row-fluid">
		<div class=" col-md-5">

	<div class="prodFlash">
		<?php 

		    $principal = Imagenes::model()->findByAttributes(array('orden'=>1,'producto_id'=>$producto->id));
	    							
		    if($principal->getUrl()) 
		    	echo CHtml::image(str_replace(".","_x180.",$principal->getUrl()), "Imagen ", array('width'=>'250'));
		   
		    $marca = Marca::model()->findByPk($producto->marca_id);
							
			echo "<p><strong>".$producto->nombre." por <small>".$marca->nombre."</small></strong></p>";								
			echo '<p><b> Precio Actual:</b> '.$inventario->precio.' Bs.</p>';
			echo $codigo;
			
		?>   
	</div>
	</div>
	<div class="col-md-7">
	    
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
        'class'=>'row-fluid'
    ),
)); ?>
	    <p class="not col-md-12">Los campos marcados con <span class="required">*</span> son obligatorios.</p>
	<div class="col-md-12"> 
		<?php echo $form->labelEx($model,'cantidad'); ?>
		<?php echo $form->textField($model,'cantidad',array('class'=>'form-control','maxlength'=>10,'placeholder'=>'Cantidad disponible para la Venta Flash.')); ?>
		<?php echo $form->error($model,'cantidad'); ?>
	</div>
	
	<div class="col-md-12">
		<?php echo $form->labelEx($model,'descuento'); ?>
		<?php echo $form->textField($model,'descuento',array('class'=>'form-control','placeholder'=>'Descuento a aplicar sobre el producto.')); ?>
		<?php echo $form->error($model,'descuento'); ?>
	</div>
	
	<div class="col-md-12">

			<?php 
				echo $form->labelEx($model,'fecha_inicio',array('class'=>'control-label'));
                                $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                          
                                    'model'=>$model,
                                    'name'=>'Flashsale[fecha_inicio]',
                                    'value'=>date("d/m/Y",strtotime($model->fecha_inicio)),
                                    // additional javascript options for the date picker plugin
                                    'options'=>array(
                                        'showAnim'=>'fold',
                                    ),
                                    'htmlOptions'=>array(
                             
                                        'class'=>'form-control'
                                    ),
                                )); 
			?>
		<?php echo $form->error($model,'fecha_inicio'); ?>
    </div>

    	<?php /*becho $form->labelEx($model,'fecha_inicio'); 
		 echo $form->textField($model,'fecha_inicio',array('class'=>'form-control')); 
		 echo $form->error($model,'fecha_inicio'); */ ?>

	<div class="col-md-12">
    	<?php            echo $form->labelEx($model,'fecha_fin',array('class'=>'control-label'));
                                $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                   
                                    'model'=>$model,
                                    'name'=>'Flashsale[fecha_fin]',
                                    'value'=>date("d/m/Y",strtotime($model->fecha_fin)),
                                    // additional javascript options for the date picker plugin
                                    'options'=>array(
                                        'showAnim'=>'fold',
                                    ),
                                    'htmlOptions'=>array(
                             
                                        'class'=>'form-control'
                                    ),
                                )); 
                
			?>
		<?php echo $form->error($model,'fecha_fin'); ?>  
    </div>
	
		<?php /* echo $form->labelEx($model,'fecha_fin'); 
		echo $form->textField($model,'fecha_fin',array('class'=>'form-control')); 
		echo $form->error($model,'fecha_fin'); */ ?>
	
	<div class="col-md-12 lineRadios"> 
	   	<?php // echo $form->labelEx($model,'estado'); ?> 
		<?php // echo $form->textField($model,'estado',array('class'=>'form-control')); ?>
		<?php echo $form->radioButtonListRow($model,'estado', array(1 => 'Activo', 0 => 'Inactivo',),array('class'=>'col-md-3')); ?>
		<?php echo $form->error($model,'estado'); ?>
 
   
	<?php // echo $form->textField($model,'inventario_id',array('class'=>'form-control')); ?>
	<?php echo $form->hiddenField($model,'inventario_id',array('type'=>"hidden",'value'=>$inventario->id)); ?>
	</div>
	<div class="col-md-12"> 
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Guardar',
			'htmlOptions'=>array('class'=>'margin_top_small form-control')
		)); ?>
	</div>
	
	
	</div>
	</div>



<?php $this->endWidget(); ?>

