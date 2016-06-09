<style>

    .form-group{
       height: 51px;
       margin-bottom:10px;
    }
</style>

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

    <?php //echo $form->errorSummary($model); ?>
    
    <div class="form-group" id="otraContainer" style="display:none">
    

             <?php echo $form->textField($model,'otraOpcion', array('id'=>'otraOpcion','class'=>'form-control', 'placeholder'=>'Otro cargo o posición', 'maxlength'=>205)); ?>
            <?php echo $form->error($model,'otraOpcion'); ?>
            <span class="help-block text_align_left padding_right">
		              <span class="help-block error" id="esconder" style="display: none;">No puede ser nulo
		              </span>
             </span>	

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
 
            <?php echo $form->textField($model,'rif', array('class'=>'form-control rifs', 'placeholder'=>'RIF (Letra y número sin espacios ni guiones)', 'maxlength'=>45)); ?>

            <?php echo $form->error($model,'rif'); ?>            

        
        
    </div>
    
        <div class="form-group row-fluid">
 
            <?php //echo $form->textField($model,'tipo_contribuyente', array('class'=>'form-control', 'placeholder'=>'Tipo de contribuyente', 'maxlength'=>45)); ?>
			 <?php echo $form->dropDownList($model,'tipo_contribuyente',array('0'=>'Contribuyente Ordinario', '1'=>'Contribuyente Especial', '2'=>'Contribuyente Formal'),array('class'=>'form-control','empty'=>'Seleccione un tipo de contribuyente')); ?>
            <?php echo $form->error($model,'tipo_contribuyente'); ?>            

        
        
    </div>
    
        
    <div class="form-group">
            <?php echo $form->textField($model,'telefono', array('id'=>'telefono', 'class'=>'form-control', 'placeholder'=>'Teléfono (código y número sin espacios ni guiones)', 'maxlength'=>11)); ?>


        <?php echo $form->error($model,'telefono'); ?>
    </div>
    <div class="form-group provincias">
			<?php echo $form->dropDownList($model,'provincia', CHtml::listData(Provincia::model()->findAll(array('order'=>'nombre asc')),'id', 'nombre'), 
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
    
 

         <div class="form-group hide ciudades">
            <?php echo $form->dropDownList($model,'ciudad', array(), array('class'=>'form-control cu', 'empty'=>'Ciudad de oficina principal')); ?>
             <span class="help-block text_align_left padding_right">
                      <span class="help-block error" id="errorCiudad" style="display: none;">Ciudad no puede ser nulo</span>
             </span>    
        </div>


        <div class="form-group row-fluid ciudades2">
           <?php echo $form->dropDownList($model,'ciudad2', CHtml::listData(Ciudad::model()->findAllByAttributes(array('provincia_id'=>$model->provincia),array('order'=>'nombre asc')),'id', 'nombre'), 
            array(
            'class'=>'form-control cu2',
            )); ?> 
            <?php #echo $form->error($model,'ciudad'); ?>
        </div>

    
    <div class="form-group row-fluid">
            <?php echo $form->textField($model,'zip', array('id'=>'zip','class'=>'form-control', 'placeholder'=>'Código Postal (numeros enteros)', 'maxlength'=>50)); ?>

            <?php echo $form->error($model,'zip'); ?>            

        
        
    </div>
    
    
    <div class="form-group">

            <?php echo $form->textField($model,'direccion', array('class'=>'form-control', 'placeholder'=>'Dirección', 'maxlength'=>350)); ?>
        <?php echo $form->error($model,'direccion'); ?>
    </div>
    
    <div class="form-group">

            <?php echo $form->textField($model,'web', array('class'=>'form-control', 'placeholder'=>'Página Web', 'maxlength'=>55)); ?>

        <?php echo $form->error($model,'web'); ?>
    </div> 

    
<!--
    <div class="form-group">
            ¿Cambiar de rol?
            <?php echo $form->radioButtonList($model, 'tipoEmpresa', array('vendedor'=>'Vender', 'comprador'=>'Comprar', 'compraVenta'=>'Ambas'),array('style'=>'form-control','separator'=>'  ', 'labelOptions'=>array('style'=>'display:inline'))); ?>
       
        <?php echo $form->error($model,'tipoEmpresa'); ?>
    </div> 

    -->

    
<div class="form-group">
    <div class="margin_top text-center">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>$model->etiqueta(),
            'htmlOptions'=>array('class'=>'btn-black btn btn-danger btn-large botone'),
        )); ?>
        <?php $this->endWidget(); ?>
    </div>
    </div> 


    </div>
</div>

<?php 
if(!$model->isNewRecord)
{
    ?>
    <script>
    $(document).ready(function() {
    $('.provincias').on('change', function(event) {

        $('.ciudades2').hide();
        $('.ciudades').removeClass('hide');  
        $("#errorCiudad" ).show();

    });
     });
    </script>
   <?php 
}

?>

<script>

$(document).ready(function() {
	//$("#otraOpcion").hide();	
	var completo="";
	var soloLetra='';
	var zipCompleto="";
	var telefonoCompleto="";
	$('.rifs').on('input', function(event) {
		var id=$(this).attr('id');
		//var palabra=$(this).val();
		var palabra=$("#"+id).val();
		var letras = " jevgJEVG"; //JVEG rifs posibles
		var numeros = " 1234567890"; //JVEG rifs posibles
		var primeraLetra=palabra.charAt(0);
		if(letras.indexOf(primeraLetra)==-1)
		{
			alert('Iniciales de Rif son V, E, P, J, G y C');
			soloLetra=primeraLetra;
			$("#"+id).val('');
		}
		//$(this).val().charAt(0).toUpperCase();
		 if(palabra.substring(1))
		 {
		 	var largo= palabra.length;
		 	var separar=palabra[largo-1];
		 	//alert(separar);
			if(numeros.indexOf(separar)==-1)
			{
				alert('Solo se permiten numeros  después de la letra.');
				$("#"+id).val(completo);
			}	
		 }
	completo=$("#"+id).val();
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
	
	
	$('.cargos').on('change', function(event) {
		var ca=$(this).attr('id');
		if($("#"+ca).val()=="Otro")
		{
			$("#otraContainer").show();
		}	
		else
		{
			$("#otraContainer").hide();
		
		}
				
		
		
	});
	
	$('.botone').on('click', function(event) {
		if($("#Empresas_cargo").val()=="Otro" && $("#otraOpcion").val()=="")
		{
			$('#esconder').show();
			return false;
		}
        if(!$(".ciudades" ).hasClass( "hide" ))
        {
             if($(".cu" ).val()=="")
             {
                $("#errorCiudad" ).show();
                return false;
             }
           //  return false;
        }
	});

    $('.cu').on('change', function(event) {
        if($(".cu" ).val()=="")
        {
            $("#errorCiudad" ).show();
        }
        else
        {
            $("#errorCiudad" ).hide();
        }
    });
});	
</script>