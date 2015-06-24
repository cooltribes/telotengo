
 <div class="row-fluid">

		<div class="col-md-6 col-md-offset-3 margin_top_small">
		<?php echo CHtml::textField('nombre', $model->nombre, array('id'=>'nombre','class'=>'form-control','maxlength'=>100, 
			'width'=>100,)); ?>

	</div>


	<a id="agregarCampo" class="btn btn-info" href="#">Agregar Unidad</a>
	
<div class="col-md-6 col-md-offset-3 margin_top" id="contenedor">
    <div class="added">
    	<?php 
    	$cadaUno=explode(',', $model->rango);
		$i=1;
		$pila=array();
		foreach($cadaUno as $each)
		{
			$single=explode('==', $each);
			array_push($pila, $single[1]);
		?>	

        	<input type="text" name="mitexto[]" id="campo_<?php echo $i;?>"  value="<?php echo $single[1]?>" size="60"/> <a href="#" id="<?php echo $i;?>"class="eliminar">&times;</a>
		<?php		
		$i++;
		}
    	?>    
    </div>
</div>




	<div class="col-md-6 col-md-offset-3 margin_top">
			<a id="avanzar" class="btn btn-danger form-control"  title="Guardar y avanzar">Guardar y avanzar</a>
	</div>

</div><!-- form -->


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
            $(contenedor).append('<div><input type="text" name="mitexto[]" id="campo_'+ FieldCount +'" placeholder="Texto '+ FieldCount +'" size="60"/><a id='+FieldCount+' href="#" class="eliminar">&times;</a></div>');
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
    
	$('#avanzar').on('click', function(event) {
		
		event.preventDefault();
		var j;
		var otro;
		var nombre=$("#nombre").val();
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
	         url: "<?php echo Yii::app()->createUrl('Unidad/actualizacion') ?>",
             type: 'POST',
	         data:{
                    nombre:nombre, vector:vector, idAct:idAct,
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
