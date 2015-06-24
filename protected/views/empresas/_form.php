<div class="row-fluid">
	<div>

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
		<?php echo $form->labelEx($model,'forma_legal'); ?>
		<div class="col-sm-12">
			<?php echo $form->dropDownList($model,'forma_legal',Empresas::itemAlias('FormaLegal'),array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'forma_legal'); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'sector', array('class'=>'col-sm-2')); ?>
	    <div class="col-sm-10">
	   		<?php echo $form->dropDownList($model,'sector',Empresas::itemAlias('Sector'),array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'sector'); ?>
	    </div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'cargo'); ?>
		<div class="col-sm-12">
			<?php echo $form->dropDownList($model,'cargo',Empresas::itemAlias('Cargo'),array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'cargo'); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'num_empleados'); ?>
		<div class="col-sm-12">
			<?php echo $form->dropDownList($model,'num_empleados',Empresas::itemAlias('NumEmpleados'),array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'num_empleados'); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'mail', array('class'=>'col-sm-2')); ?>
	    <div class="col-sm-10">
	    	<?php echo $form->textField($model,'mail', array('class'=>'form-control', 'placeholder'=>'', 'maxlength'=>85)); ?>
	    </div>
	    <?php echo $form->error($model,'mail'); ?>
	</div>
	
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
		<?php echo $form->labelEx($model,'telefono', array('class'=>'col-sm-2')); ?>
	    <div class="col-sm-10">
	    	<?php echo $form->textField($model,'telefono', array('class'=>'form-control', 'placeholder'=>'Ingrese solo numeros. Ejm: 04140011223', 'maxlength'=>15)); ?>
	    </div>
	    <?php echo $form->error($model,'telefono'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'ciudad', array('class'=>'col-sm-2')); ?>
		<div class="col-sm-10">
			<?php echo $form->textField($model, 'ciudad', array('class'=>'form-control','placeholder'=>"Ciudad de la dirección principal")); ?>
	    </div>
	    <?php echo $form->error($model,'ciudad'); ?>
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

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>"Enviar datos",
			'htmlOptions'=>array('class'=>'btn btn-primary'),
		)); ?>
	</div>

<?php $this->endWidget(); ?>
	</div>
</div>