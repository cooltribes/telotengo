<div class="row-fluid">


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array( 
	'id'=>'atributo-form',
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
</div> 


	<div class="col-md-6 col-md-offset-3 margin_top_small">
		<?php echo $form->textFieldRow($model,'nombre',array('class'=>'form-control','maxlength'=>80, 'id'=>'nombre')); 	?>
	</div>
	
	
	<div class="col-md-6 col-md-offset-3 margin_top_small">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textArea($model,'descripcion', array('id'=>'descripcion', 'rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'descripcion'); ?>
	</div>
	

	<div class="col-md-6 col-md-offset-3 margin_top_small">
		<?php
		 echo $form->labelEx($model,'tipo');  
		 echo CHtml::activeDropDownList($model,'tipo',$model->getTiposAtributos(),array('id'=>'tipo','prompt'=>'Elija un tipo',
                                'class'=>'form-control'));
		echo $form->error($model,'tipo');
		?>
	</div>
	
	<div class="col-md-6 col-md-offset-3 margin_top_small" style="display:none" id="multiple">
		<label>Multiple</label> <br>
			<?php echo $form->radioButtonList($model,'multiple', array(
                        1=>'Si',
                        0=>'No',
                )); ?>
		
	</div>
	
		<div id="boton" style="display:none"><a id="agregarCampo" class="btn btn-info" href="#" >Agregar Atributo</a></div>
		<div class="col-md-6 col-md-offset-3 margin_top" id="contenedor">
    		<div class="added">
    			<label class="especial" style="display:none">Opciones</label> <br>
        	<input type="text" style="display:none" class="especial" name="mitexto[]" id="campo_1" placeholder="Texto 1" size="60"/><a href="#" class="eliminar" style="display:none">&times;</a>
    		</div>
		</div>
	
	<div class="col-md-6 col-md-offset-3 margin_top_small" id="tipoUnidad">
		<?php		 
		echo $form->dropDownListRow($model,'tipo_unidad', CHtml::listData(Unidad::model()->findAll(array('order'=>'nombre')),'id','nombre'), 
									array('empty'=>'Seleccione una unidad, si es necesario', 'class'=>'form-control'));						                  
		?>
	</div>
	
	
	
		<div class="col-md-6 col-md-offset-3 margin_top_small" id="obligatorio">
		<label>Obligatorio</label> <br>
			<?php echo $form->radioButtonList($model,'obligatorio', array(
                        1=>'Si',
                        0=>'No',
                )); ?>
		
	</div>		
	
	
	
		<div id="principale" class="col-md-6 col-md-offset-3 margin_top" class="btn btn-danger form-control">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Guardar',
			'htmlOptions'=>array('class'=>'form-control')
		)); ?>

	</div>
	
	<div id="avanzar" class="col-md-6 col-md-offset-3 margin_top" style="display:none">
			<a class="btn btn-danger form-control"  title="Guardar">Guardar</a>
	</div>
	
<?php $this->endWidget(); ?>



<script>
$(document).ready(function() {
	

    var MaxInputs       = 100; //Número Maximo de Campos
    var contenedor       = $("#contenedor"); //ID del contenedor
    var AddButton       = $("#agregarCampo"); //ID del Botón Agregar
    var vector= [];
    //var x = número de campos existentes en el contenedor
    var x = $("#contenedor div").length + 1;
    var FieldCount = x-1; //para el seguimiento de los campos
	
	vector.push(FieldCount);
	
	    $("#tipo").change(function (e) {
	    	
		    if($("#tipo").val()==3)	// si es range
		    {
		    	$('.especial').show();
		    	$('.eliminar').show();
		    	$('.agregarCampo').show();
		    	$('#boton').show();
		    	$('#avanzar').show();
		    	$('#multiple').show();
		    	$('#principale').hide();
		    	$('#tipoUnidad').hide();
		    	$('#tipoUnidad').val('');
		    }
		    else
		    {
		    	$('.especial').hide();
		    	$('.eliminar').hide();
		    	$('.agregarCampo').hide();
		    	$('#boton').hide();
		    	$('#avanzar').hide();
		    	$('#multiple').hide();
		    	$('#principale').show();
		    	$('#tipoUnidad').show();
		    }

    });
	
	
    $(AddButton).click(function (e) {
        if(x <= MaxInputs) //max input box allowed
        {
          
            FieldCount++;
            //agregar campo
            $(contenedor).append('<div><input type="text" class="especial" name="mitexto[]" id="campo_'+ FieldCount +'" placeholder="Texto '+ FieldCount +'" size="60"/><a id='+FieldCount+' href="#" class="eliminar">&times;</a></div>');
            vector.push(FieldCount);
            x++; //text box increment
        }
        return false;
    });

    $("body").on("click",".eliminar", function(e){ //click en eliminar campo, deberia por lo menos quedar un campo
        if( x > 2 ) {
        	vector[$(this).attr("id")-1]="noIndexado"; // ELIMINAR
            $(this).parent('div').remove(); //eliminar el campo

            x--;
        }
        return false;
    });
    
    
	$('#avanzar').on('click', function(event) {
		
		event.preventDefault();
		var j;
		var otro;
		var multiple;
		var obligatorio;
		var tipo
		var nombre=$("#nombre").val();
		var idAct="<?php echo($model->id);?>";
		var descripcion=$('#descripcion').val();
		if($('#Atributo_obligatorio_0').is(':checked')) 
		 	obligatorio=$("#Atributo_obligatorio_0").val();
		 else
		 	obligatorio=$("#Atributo_obligatorio_1").val();
		 	
		 	
		 if($('#Atributo_multiple_0').is(':checked')) 
		 	multiple=$("#Atributo_multiple_0").val();
		 else
		 	multiple=$("#Atributo_multiple_1").val();
		 	
		 if($("#tipo").val()==3)
		 	multiple=0;

		 	
		tipo=$("#tipo").val();
		
		if(nombre=="")
		{
			alert('Nombre no puede ser vacio');
			return false;
		}
		
		for(j=0;j<vector.length;j++)
		{
			
			if(vector[j]!="noIndexado")
			{
				otro=j+1;
				if($("#campo_"+otro).val()=="")
				{
					alert('No pueden haber opciones vacias'); /// no deje hacer nada 
					return false;
				}
				else
				{
					vector[j]=$("#campo_"+otro).val(); //separacion por ahora
				}
			}	
		}
		
			$.ajax({
	         url: "<?php echo Yii::app()->createUrl('Atributo/create') ?>",
             type: 'POST',
	         data:{
                    nombre:nombre, vector:vector, obligatorio:obligatorio, multiple:multiple, tipo:tipo, descripcion:descripcion, idAct:idAct
                   },
	        success: function (data) {
	        	
	        	//alert (data);
      			//window.location.href = '../categoria/categoriaRelacionada/'+data+'';
      			//window.location.href = '../admin/';
      			window.location.href = '<?php echo Yii::app()->createUrl("Atributo/admin");?>';
	       	}
	       })
		//alert('bien');
	});
});	


	
</script>
	

