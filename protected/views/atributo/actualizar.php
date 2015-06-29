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
 <div class="row-fluid">

		<div class="col-md-6 col-md-offset-3 margin_top_small">
			
		<?php 
		 echo $form->textFieldRow($model,'nombre',array('class'=>'form-control','maxlength'=>80, 'id'=>'nombre')); 	?>

	</div>

	<div class="col-md-6 col-md-offset-3 margin_top_small">
		<?php
		 echo $form->labelEx($model,'tipo');  
		 echo CHtml::activeDropDownList($model,'tipo',$model->getTiposAtributos(),array('id'=>'tipo','prompt'=>'Eliga un tipo',
                                'class'=>'form-control'));
		echo $form->error($model,'tipo');
		?>
	</div>
	
	<div class="col-md-6 col-md-offset-3 margin_top_small"  id="multiple">
		<label>Multiple</label> <br>
				<?php echo $form->radioButtonList($model,'multiple', array(
                        1=>'Si',
                        0=>'No',
                )); ?>

	</div>

	<a id="agregarCampo" class="btn btn-info" href="#">Agregar Atributo</a>
	
<div class="col-md-6 col-md-offset-3 margin_top" id="contenedor">
    <div class="added">
    	<label class="especial" >Opciones</label> <br>
    	<?php 
    	$cadaUno=explode(',', $model->rango);
		$i=1;
		$pila=array();
		foreach($cadaUno as $each)
		{
			$single=explode('==', $each);
			array_push($pila, $single[1]);
		?>	

        	<input type="text"  class="especial" name="mitexto[]" id="campo_<?php echo $i;?>"  value="<?php echo $single[1]?>" size="60"/> <a href="#" id="<?php echo $i;?>"class="eliminar">&times;</a>
		<?php		
		$i++;
		}
    	?>    
    </div>
</div>

	<div class="col-md-6 col-md-offset-3 margin_top_small" id="tipoUnidad" style="display:none">
		<?php		 
		echo $form->dropDownListRow($model,'tipo_unidad', CHtml::listData(Unidad::model()->findAll(array('order'=>'nombre')),'id','nombre'), 
									array('empty'=>'Seleccione una unidad, si es necesario', 'class'=>'form-control'));						                  
		?>
	</div>
	
			<div class="col-md-6 col-md-offset-3 margin_top_small">
		<label>Obligatorio</label> <br>
			<?php echo $form->radioButtonList($model,'obligatorio', array(
                        1=>'Si',
                        0=>'No',
                )); ?>
		
	</div>	


	<div id="principale" class="col-md-6 col-md-offset-3 margin_top" class="btn btn-danger form-control" style="display:none">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Guardar',
			'htmlOptions'=>array('class'=>'form-control')
		)); ?>

	</div>

	<div id="avanzar" class="col-md-6 col-md-offset-3 margin_top" >
			<a class="btn btn-danger form-control"  title="Guardar">Guardar</a>
	</div>

</div><!-- form -->
<?php $this->endWidget(); ?>

<script>
$(document).ready(function() {

			
    var MaxInputs       = 100; //Número Maximo de Campos
    var contenedor       = $("#contenedor"); //ID del contenedor
    var AddButton       = $("#agregarCampo"); //ID del Botón Agregar
    var vector= [];
    var idAct= <?php echo $model->id;?>;
    var arrayJS=<?php echo json_encode($pila);?>;
    for(var i=0;i<arrayJS.length;i++)
    {
       // alert(arrayJS[i]);
        vector.push(i);
        
    }
    //var x = número de campos existentes en el contenedor
    var x = <?php echo $i++;?>  /// se modifico

    var FieldCount = x-1; //para el seguimiento de los campos
	
	vector.push(FieldCount);
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
        	var ide=$(this).attr("id");
        	vector[$(this).attr("id")-1]="noIndexado"; // ELIMINAR
         $( "#"+ide ).remove();
         $( "#campo_"+ide ).remove();
            x--;
        }
        return false;
    });
    
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
    
	$('#avanzar').on('click', function(event) {
		
		event.preventDefault();
		var j;
		var otro;
		var multiple;
		var obligatorio;
		var tipo;
		var nombre=$("#nombre").val();
		
		 
		if($('#Atributo_obligatorio_0').is(':checked')) 
		 	obligatorio=$("#Atributo_obligatorio_0").val();
		 else
		 	obligatorio=$("#Atributo_obligatorio_1").val();
		 	
		 	
		 if($('#Atributo_multiple_0').is(':checked')) 
		 	multiple=$("#Atributo_multiple_0").val();
		 else
		 	multiple=$("#Atributo_multiple_1").val();
		 	
		 	
		 if($("#tipo").val()!=3)
		 	multiple=0;

		tipo=$("#tipo").val();
		
		if(nombre=="")
		{
			alert('No pueden haber campos vacios');
			return false;
		}
		for(j=0;j<vector.length;j++)
		{
			
			if(vector[j]!='noIndexado')
			{
				otro=j+1;
				if($("#campo_"+otro).val()=="" )
				{
					alert('No pueden haber campos vacios'); /// no deje hacer nada 
					return false;
				}
				else
				{
					if( !($("#campo_"+otro).val() == undefined))
					{
						vector[j]=$("#campo_"+otro).val(); 
					}
					else
					{
						vector[j]='noIndexado'; //es el ultimo
					}

				}
			}	
		}
		
					$.ajax({
	         url: "<?php echo Yii::app()->createUrl('Atributo/create') ?>",
             type: 'POST',
	         data:{
                    nombre:nombre, vector:vector, obligatorio:obligatorio, multiple:multiple, tipo:tipo, idAct:idAct,
                   },
	        success: function (data) {
	        	
	        	//alert (data);
      			//window.location.href = '../categoria/categoriaRelacionada/'+data+'';
      			window.location.href = '../admin/';
	       	}
	       })

	});
});	


	
</script>
