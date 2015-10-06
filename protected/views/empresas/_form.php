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
 
            <?php echo $form->textField($model,'rif', array('id'=>'rif','class'=>'form-control', 'placeholder'=>'RIF(Letra seguida del número sin espacios ni guiones)', 'maxlength'=>45)); ?>

            <?php echo $form->error($model,'rif'); ?>            

        
        
    </div>
    
        <div class="form-group row-fluid">
 
            <?php echo $form->textField($model,'zip', array('id'=>'zip','class'=>'form-control', 'placeholder'=>'Introduzca Codigo Postal (numeros enteros)', 'maxlength'=>50)); ?>

            <?php echo $form->error($model,'zip'); ?>            

        
        
    </div>
    
    <div class="form-group">

            <?php echo $form->textField($model,'telefono', array('id'=>'telefono','class'=>'form-control', 'placeholder'=>'Teléfono', 'maxlength'=>15)); ?>

        <?php echo $form->error($model,'telefono'); ?>
    </div>
    <div class="form-group">
			<?php echo $form->dropDownList($model,'provincia', CHtml::listData(Provincia::model()->findAll(),'id', 'nombre'), 
        array(
        'class'=>'form-control',
        'empty'=>'Seleccione Estado',
        'ajax'=>array(
            'type'=>'POST',
            'url'=>CController::createUrl('Empresas/selectdos'),
            'update'=>'#'.CHtml::activeId($model, 'ciudad'),
        ),
         
        )); ?>
         <?php echo $form->error($model,'provincia'); ?>
    </div>
    
    
    <div class="form-group">

            <?php echo $form->dropDownList($model,'ciudad', array(), array('class'=>'form-control', 'empty'=>'Ciudad de oficina principal')); ?>
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

<!--    <div class="form-group">

            <?php echo $form->dropDownList($model,'forma_legal',Empresas::itemAlias('FormaLegal'),array('class'=>'form-control')); ?>
            <?php echo $form->error($model,'forma_legal'); ?>

    </div>-->

    

    

<!--    <div class="form-group">

            <?php echo $form->dropDownList($model,'num_empleados',Empresas::itemAlias('NumEmpleados'),array('class'=>'form-control')); ?>
            <?php echo $form->error($model,'num_empleados'); ?>

</div>-->

<!--    <div class="form-group">

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


<script>

$(document).ready(function() {
	var completo="";
	var soloLetra='';
	var zipCompleto="";
	var telefonoCompleto="";
	$('#rif').on('input', function(event) {
		var palabra=$(this).val();
		var letras = " jevgJEVG"; //JVEG rifs posibles
		var numeros = " 1234567890"; //JVEG rifs posibles
		var primeraLetra=palabra.charAt(0);
		if(letras.indexOf(primeraLetra)==-1)
		{
			alert('Iniciales de Rifs son J, V, E, G');
			soloLetra=primeraLetra;
			$(this).val('');
		}
		//$(this).val().charAt(0).toUpperCase();
		 if(palabra.substring(1))
		 {
		 	var largo= palabra.length;
		 	var separar=palabra[largo-1];
		 	//alert(separar);
			if(numeros.indexOf(separar)==-1)
			{
				alert('Solo se permiten numeros');
				$(this).val(completo);
			}	
		 }
	completo=$(this).val();
	});
	
	
	$('#zip').on('input', function(event) {
		var zip=$.isNumeric($("#zip").val());
		if(zip==false)
		{
			alert ("introduzca numeros enteros");
			$("#zip").val(zipCompleto);
			return false;
			
		}
		else
		{
			zipCompleto=$("#zip").val();
		}
	});
	
	
	$('#telefono').on('input', function(event) {
		var telefono=$.isNumeric($("#telefono").val());
		if(telefono==false)
		{
			alert ("introduzca numeros enteros");
			$("#telefono").val(telefonoCompleto);
			return false;
			
		}
		else
		{
			telefonoCompleto=$("#telefono").val();
		}
	});
	
});	
</script>