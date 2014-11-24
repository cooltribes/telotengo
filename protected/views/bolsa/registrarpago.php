	<?php if(Yii::app()->user->hasFlash('success')){?>
	    <div class="alert in alert-block fade alert-success text_align_center">
	        <?php echo Yii::app()->user->getFlash('success'); ?>
	    </div>
	<?php } ?>
	<?php if(Yii::app()->user->hasFlash('error')){?>
	    <div class="alert in alert-block fade alert-error text_align_center">
	        <?php echo Yii::app()->user->getFlash('error'); ?>
	    </div>
	<?php } ?>

	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	        'id'=>'pago-form', 
	        'enableAjaxValidation'=>false,
	        'enableClientValidation'=>true,
	        'clientOptions'=>array(
	                'validateOnSubmit'=>true, 
	        ),
	        'htmlOptions'=>array('class'=>''),
		)); 
	?>
    <div class="controls">
    	<?php echo CHtml::activeTextField($pago,'nombre', array('id' => 'nombre', 'class' => 'col-md-5', 'placeholder' => 'Nombre del depositante')); ?>
        <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
    </div>
    <div class="control-group"> 
        <div class="controls">
        	<?php echo CHtml::activeTextField($pago,'confirmacion', array('id' => 'numeroTrans', 'class' => 'col-md-5', 'placeholder' => 'Número o Código del Depósito')); ?>
            <div style="display:none" class="help-inline"></div>
        </div>
    </div>
    <div class="control-group"> 
        <div class="controls">
        	<?php echo CHtml::activeTextField($pago,'cedula', array('id' => 'cedula', 'class' => 'col-md-5', 'placeholder' => 'Cedula del depositante')); ?>
			<div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
        </div>
    </div>
    <div class="control-group"> 
        <div class="controls input-append">
        	<?php echo CHtml::activeTextField($pago,'monto', array('id' => 'monto', 'title' => 'Monto','class' => 'col-md-4','placeholder' => "Monto. Use coma (,) como separador decima")); ?>
            <span class="add-on"><?php echo 'Bs.'; ?></span>
            <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
        </div>
    </div>
	<div class="control-group input-prepend">
		<label class="control-label required"> Fecha <span class="required">*</span>
			<?php
			    $this->widget('zii.widgets.jui.CJuiDatePicker',array(
			        'model' => $pago,
			        'attribute' => "fecha",
			        'language' => 'es',
			        // additional javascript options for the date picker plugin
			        'options'=>array(
			            'showAnim'=>'fold',
			            'dateFormat'=>'yy-mm-dd',
			        ),
			    ));

			?>
		</label>
	</div>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Enviar Pago',
		)); ?>
	</div>

	<?php 
    	$this->endWidget();
    ?>
