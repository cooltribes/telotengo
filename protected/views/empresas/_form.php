<div class="row-fluid">
	<div class="col-md-10">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'empresas-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'type'=>'horizontal',
	'clientOptions'=>array(
		'validateOnSubmit'=>true, 
	),
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'razon_social', array('class'=>'col-sm-2')); ?>
	    <div class="col-sm-10">
	    	<?php echo $form->textField($model,'razon_social', array('class'=>'form-control', 'placeholder'=>'', 'maxlength'=>205)); ?>
	    </div>
	    <?php echo $form->error($model,'razon_social'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'mail', array('class'=>'col-sm-2')); ?>
	    <div class="col-sm-10">
	    	<?php echo $form->textField($model,'mail', array('class'=>'form-control', 'placeholder'=>'', 'maxlength'=>85)); ?>
	    </div>
	    <?php echo $form->error($model,'mail'); ?>
	</div>
<?php /*
	<div class="form-group">
		<?php echo $form->labelEx($model,'rif', array('class'=>'col-sm-2')); ?>
	    <div class="col-sm-10">
	    	<?php echo $form->textField($model,'rif', array('class'=>'form-control', 'placeholder'=>'Solo numeros. Ejm: 12345678', 'maxlength'=>45)); ?>
	    
	    </div>
	    <?php echo $form->error($model,'rif'); ?>
	</div>
	*/ ?>
	
	<div class="form-group">
		<?php echo $form->labelEx($model,'rif', array('class'=>'col-sm-2')); ?>
	    <div class="col-sm-10">
	    	<?php echo $form->dropDownList($model,'prefijo', array('0'=>'Seleccione...','V'=>'V','E'=>'E','J'=>'J'),
	    		 array('class'=>'form-control')); ?>
	    	  <?php echo $form->error($model,'prefijo'); ?>
	    	  
	    	<?php echo $form->textField($model,'numero', array('class'=>'form-control', 'placeholder'=>'Solo numeros. Ejm: 12345678', 'maxlength'=>45)); ?>
	    
	    </div>
	    <?php echo $form->error($model,'numero'); ?>
	</div>


	<div class="form-group">
		<?php echo $form->labelEx($model,'direccion', array('class'=>'col-sm-2')); ?>
	    <div class="col-sm-10">
	    	<?php echo $form->textArea($model,'direccion', array('class'=>'form-control', 'placeholder'=>'', 'maxlength'=>350)); ?>
	    </div>
	    <?php echo $form->error($model,'direccion'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'web', array('class'=>'col-sm-2')); ?>
	    <div class="col-sm-10">
	    	<?php echo $form->textField($model,'web', array('class'=>'form-control', 'placeholder'=>'', 'maxlength'=>55)); ?>
	    </div>
	    <?php echo $form->error($model,'web'); ?>
	</div> 

	<!-- <div class="form-group">
		<?php //echo $form->labelEx($model,'destacado', array('class'=>'col-sm-2')); ?>
		<div class="col-sm-10">
			<?php //echo $form->checkBox($model, 'destacado', array()); ?>
	    </div>
	    <?php //echo $form->error($model,'destacado'); ?>
	</div> -->

	<!-- <div class="form-group">
		<?php //echo $form->labelEx($model,'url', array('class'=>'col-sm-2')); ?>
	    <div class="col-sm-10">
	    	<?php //echo $form->textField($model,'url', array('class'=>'form-control', 'placeholder'=>'', 'maxlength'=>255)); ?>
	    </div>
	    <?php //echo $form->error($model,'url'); ?>
	</div> -->

	<div class="form-group">
		<?php echo CHtml::label('Deseo vender en telotengo con esta empresa','vender', array('class'=>'col-sm-2')); ?>
		<div class="col-sm-10">
			<?php echo CHtml::checkBox('vender', false, array()); ?>
	    </div>
	</div>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Registrar' : 'Guardar',
		)); ?>

		<?php
		echo CHtml::link('Cancelar', Yii::app()->baseUrl.'/empresas/admin', array('class'=>'btn btn-default'));
		?>
	</div>

<?php $this->endWidget(); ?>

	</div>
	</div>