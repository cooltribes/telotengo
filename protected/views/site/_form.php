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
    
            <?php echo $form->dropDownList($model,'cargo',Empresas::itemAlias('Cargo'),array('class'=>'form-control','empty'=>'Tu cargo o posición')); ?>
            <?php echo $form->error($model,'cargo'); ?>

    </div>
    <div class="form-group">
    

            <?php echo $form->dropDownList($model,'sector',Empresas::itemAlias('Sector'),array('class'=>'form-control','empty'=>'Sector o industria')); ?>
            <?php echo $form->error($model,'sector'); ?>

    </div>
    
	<div class="form-group">
	    	<?php echo $form->textField($model,'razon_social', array('class'=>'form-control', 'placeholder'=>'Nombre o Razón Social', 'maxlength'=>205)); ?>

	    <?php echo $form->error($model,'razon_social'); ?>
	</div>
	
	<div class="form-group row-fluid">
 
            <?php echo $form->textField($model,'numero', array('class'=>'form-control', 'placeholder'=>'RIF', 'maxlength'=>45)); ?>

            <?php echo $form->error($model,'numero'); ?>            

        
        
    </div>
    
    <div class="form-group">

            <?php echo $form->textField($model,'telefono', array('class'=>'form-control', 'placeholder'=>'Teléfono', 'maxlength'=>15)); ?>

        <?php echo $form->error($model,'telefono'); ?>
    </div>
    <div class="form-group">

            <?php echo $form->dropDownList($model, 'ciudad',array(), array('class'=>'form-control','empty'=>"Estado")); ?>
        <?php echo $form->error($model,'ciudad'); ?>
    </div>
    
    
    <div class="form-group">

            <?php echo $form->dropDownList($model, 'ciudad', array(),array('class'=>'form-control','empty'=>"Ciudad de la oficina principal")); ?>
        <?php echo $form->error($model,'ciudad'); ?>
    </div>
    
    <div class="form-group">

            <?php echo $form->textField($model,'direccion', array('class'=>'form-control', 'placeholder'=>'Dirección', 'maxlength'=>350)); ?>
        <?php echo $form->error($model,'direccion'); ?>
    </div>
    
    <div class="form-group">

            <?php echo $form->textField($model,'web', array('class'=>'form-control', 'placeholder'=>'Página Web', 'maxlength'=>55)); ?>

        <?php echo $form->error($model,'web'); ?>
    </div> 

<!--	<div class="form-group">

			<?php echo $form->dropDownList($model,'forma_legal',Empresas::itemAlias('FormaLegal'),array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'forma_legal'); ?>

	</div>-->

	

	

<!--	<div class="form-group">

			<?php echo $form->dropDownList($model,'num_empleados',Empresas::itemAlias('NumEmpleados'),array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'num_empleados'); ?>

</div>-->

<!--	<div class="form-group">

	    	<?php echo $form->textField($model,'mail', array('class'=>'form-control', 'placeholder'=>'', 'maxlength'=>85)); ?>

	    <?php echo $form->error($model,'mail'); ?>
	</div>-->
	
	

	

	<div class="form-group">
        <div class="text-center">
            ¿Qué te interesa hacer en TeloTengo?
        </div>
        <div class="text-center">    
            <?php echo $form->radioButtonList($model, 'tipoEmpresa', array('vendedor'=>'Vender', 'comprador'=>'Comprar', 'compraVenta'=>'Ambas'),array('style'=>'display:inline','separator'=>'  ', 'labelOptions'=>array('style'=>'display:inline'))); ?>
        </div>
        <?php echo $form->error($model,'tipoEmpresa'); ?>
    </div> 

	

	

	<div class="margin_top text-center">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>"Enviar datos",
			'htmlOptions'=>array('class'=>'btn-black btn btn-danger btn-large'),
		)); ?>
	</div>

<?php $this->endWidget(); ?>
	</div>
</div>