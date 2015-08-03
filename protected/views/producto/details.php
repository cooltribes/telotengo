
 <?php 
 /*$doc = array(
    "name" => "MongoDB",
    "type" => "database",
    "count" => 1,
    "info" => (object)array( "x" => 203, "y" => 102),
    "versions" => array("0.9.7", "0.9.8", "0.9.9"),
	"producto"=> "5",
);

 $connection = new MongoClass();
 $document = $connection->getCollection('coleccion');*/
  

 //$coleccion->insert($doc);

/*$prueba = array("producto"=>'19'); //busqueda
$user = $document->findOne($prueba); //busqueda
	var_dump($user);*/
	
	
# $document->update(array("producto"=>"19"), array('$set'=>array("count"=>"40"))); //modificacion



 ?>
 
 
 <div class="container">
 <div class="row-fluid">
      <h1>Más detalles<small> - <?php echo $producto->nombre; ?></small></h1>
            <!-- Nav tabs -->
            <!-- SUBMENU ON -->
            <?php echo $this->renderPartial('_menu', array('model'=>$producto, 'activo'=>'detalles')); ?>
 	<div class="well clearfix">
 	<form method="post" id="idx">
 <?php
 $i=1;
 $hidden=array();
 foreach($categoriaAtributo as $catA)
 {
	$atributo=Atributo::model()->findByPk($catA->atributo_id);
	if($atributo->obligatorio&&$atributo->multiple==1&&$atributo->tipo==3)
                    if(!in_array($atributo->nombre_mongo, $hidden))
                        array_push($hidden,array('nombre'=>$atributo->nombre_mongo,'valor'=>isset($busqueda[$producto->cambiarNombre($atributo->nombre)])?implode(',',$busqueda[$producto->cambiarNombre($atributo->nombre)]).',':''));
	//echo $atributo->id;
	$tipo= $atributo->buscarTipo($atributo->tipo);
	 $patron= $atributo->buscarPatron();
	 $mensaje=$atributo->buscarMensaje();
	$obligatorio= $atributo->buscarObligatorio($atributo->obligatorio);
	if( $tipo!="range" && (($atributo->tipo_unidad=="" || !isset($atributo->tipo_unidad)))) // si no tiene rango ni tipos de unidad es porque es solo un simple campo de texto
	{
	
		if($atributo->tipo==6) // si es boleano
		{?>
			
			<div class="col-md-6 col-md-offset-3 margin_top_small">
				<?php echo CHtml::label($atributo->nombre,'etiqueta'); 	if($obligatorio=="required") echo "*";?>
				<input type="checkbox" <?php echo $producto->buscarBoolean($atributo->nombre);?> name="<?php echo $atributo->nombre?>" id="<?php echo $i;?>" class="<?php echo $tipo;?>"><br>				
			</div>
		<?php
		}
		else 
		{
			if($atributo->tipo==5) // si es de tipo fecha
			{
				?>
				<div class="col-md-6 col-md-offset-3 margin_top_small">
					<?php echo CHtml::label($atributo->nombre,'etiqueta'); if($obligatorio=="required") echo "*";?>
					<input type="date" value="<?php echo isset($busqueda[$producto->cambiarNombre($atributo->nombre)])?  $busqueda[$producto->cambiarNombre($atributo->nombre)]:''; ?>" name="<?php echo $atributo->nombre?>" id="<?php echo $i;?>" class="<?php echo $tipo;?>" <?php echo $obligatorio;?>><br>
				</div>
			<?php
			}
			else // si es de otro tipo
			{
				?>
				<div class="col-md-6 col-md-offset-3 margin_top_small">
					<?php echo CHtml::label($atributo->nombre,'etiqueta'); if($obligatorio=="required") echo "*";?>
					<input type="text" name="<?php echo $atributo->nombre?>" value="<?php echo isset($busqueda[$producto->cambiarNombre($atributo->nombre)])?  $busqueda[$producto->cambiarNombre($atributo->nombre)]:''; ?>" id="<?php echo $i;?>" class="<?php echo $tipo;?>" <?php echo $obligatorio;?> <?php echo $patron;?> <?php echo $mensaje;?>>
					<span id="<?php echo $i."e";?>" class="error margin_top_small_minus hide"><br/><small>Formato no válido</small></span><br>
				</div>
				<?php	
			}	
		}	
		
	}
	else
	{
		
		if($atributo->tipo_unidad) // si tipo de unidad, quiere decir que no hay rango
		{
			$unidad=Unidad::model()->findByPk($atributo->tipo_unidad);
			if($atributo->multiple==0)
			{
				// dropdown
				?>

				<div class="col-md-6 col-md-offset-3 margin_top_small">
				<?php 
				echo CHtml::label($atributo->nombre,'etiqueta'); if($obligatorio=="required") echo "*";
				$rango=explode(",", $unidad->rango);
				?>
				<input type="text" name="<?php echo $atributo->nombre?>" value="<?php echo isset($busqueda[$producto->cambiarNombre($atributo->nombre)])?  $busqueda[$producto->cambiarNombre($atributo->nombre)]:''; ?>" id="<?php echo $i;?>" class="<?php echo $tipo;?>" <?php echo $obligatorio;?> <?php echo $patron;?> <?php echo $mensaje;?>>
				
				<select name="<?php echo $atributo->nombre;?>*-*UNIDAD">
				<?php 
				foreach($rango as $ra)
				{
					$arreglo=explode("==", $ra);
				?>				
					<option <?php echo $producto->buscarSelect($atributo->nombre, $arreglo[1]);?> value="<?php echo $arreglo[1];?>"><?php echo $arreglo[1];?></option>
				<?php
				}
				?>
				</select>
				
				<span id="<?php echo $i."e";?>" class="error margin_top_small_minus hide"><br/><small>Formato no válido</small></span><br>
				</div>
				<?php
			}
			else ///ESTE CASO NUNCA VA A PASAR( POR AHORA)
			{?>
				<div class="col-md-6 col-md-offset-3 margin_top_small" id="<?php echo "checkbox-".$i?>">
				<?php 
				echo CHtml::label($atributo->nombre,'etiqueta');if($obligatorio=="required") echo "*";?><br> <?php
				$rango=explode(",", $unidad->rango); ?>
				<input type="text" name="<?php echo $atributo->nombre?>" value="<?php echo isset($busqueda[$producto->cambiarNombre($atributo->nombre)])?  $busqueda[$producto->cambiarNombre($atributo->nombre)]:''; ?>" id="<?php echo $i;?>" class="<?php echo $tipo;?>" <?php echo $obligatorio;?> <?php echo $patron;?> <?php echo $mensaje;?>>
				<?php
				$j=1;
				foreach($rango as $ra)
				{
					$arreglo=explode("==", $ra);
				?>				
					<input type="checkbox" name="<?php echo $arreglo[1];?>" id="<?php echo $i."a".$j?>" value="<?php echo $arreglo[1];?>"><?php echo $arreglo[1];?><br>
				<?php
				$j++;
				}
				?>	
				</div>
				
			<?php
			}
			
		}
	    else // si no hay tipo de unidad, quiere decir que hay rango..(La unica manera que haya multiple es que sea range)
	    {
			if($atributo->multiple==0)
			{
				// dropdown
				?>

				<div class="col-md-6 col-md-offset-3 margin_top_small">
				<?php 
				echo CHtml::label($atributo->nombre,'etiqueta');if($obligatorio=="required") echo "*";
				$rango=explode(",", $atributo->rango);
				?>
				
				<?php 
				if($atributo->obligatorio==1)
				{
				?>
					<select class="form-control" name="<?php echo $atributo->nombre;?>">
					<?php 
					foreach($rango as $ra)
					{
						$arreglo=explode("==", $ra);
					?>				
						<option <?php echo $producto->buscarSelect($atributo->nombre, $arreglo[1], '1');?> value="<?php echo $arreglo[1];?>"><?php echo $arreglo[1];?></option>
					<?php
					}
					?>
					</select>
				<?php // no sea obligatorio
				} 
				else
				{
				?>
					<select class="form-control" name="<?php echo $atributo->nombre;?>">
					<option  value="opcion-vacia">Seleccione una opcion, en caso contrario deje esta opcion</option>
					<?php 
					foreach($rango as $ra)
					{
						$arreglo=explode("==", $ra);
					?>				
						<option <?php echo $producto->buscarSelect($atributo->nombre, $arreglo[1], '1');?> value="<?php echo $arreglo[1];?>"><?php echo $arreglo[1];?></option>
					<?php
					}
					?>
					</select>
				
				<?php
				}
				?>
				
				</div>
				<?php
			}
			else 
			{?>
				<div class="col-md-6 col-md-offset-3 margin_top_small" id="<?php echo "checkbox-".$i?>">
				<?php 
				echo CHtml::label($atributo->nombre,'etiqueta'); if($obligatorio=="required") echo "*"; ?>
				<span class="error" id="<?php echo $atributo->nombre_mongo ?>_error" style="display:none">Seleccione una o mas opciones</span><br> <?php
				
                    
				$rango=explode(",", $atributo->rango);
				$j=1;
				foreach($rango as $key=>$ra)
				{
					$arreglo=explode("==", $ra);
				?>				
					<input type="checkbox" onclick="reqCheck('#<?php echo $i."a".$j?>','<?php echo $atributo->nombre_mongo;?>','<?php echo $arreglo[1];?>')" class="<?php echo $atributo->nombre_mongo;?>" name="<?php echo $atributo->nombre;?>[<?php echo $key ?>]" id="<?php echo $i."a".$j?>" value="<?php echo $arreglo[1];?>"
					<?php 
					   if(!is_null($busqueda))
					echo in_array($arreglo[1],$busqueda[$producto->cambiarNombre($atributo->nombre)])?"checked='checked'":"";?>
					
					/>
	             
					<?php 
					
					
					echo $arreglo[1];?>
					<br/>
				<?php
				$j++;
				}
                ?>	
				</div>
				
			<?php
			}
	    }
	}
	echo "\n";
	echo "\n";
	$i++;
	//if(($atributo->tipo_unidad=="" || isset($atributo->tipo_unidad)) && ($atributo->rango=="" || isset($atributo->rango))) // si no tiene rango ni tipos de unidad es porque es solo un simple campo de texto
 }

 ?>
 	<div id="avanzar" class="col-md-6 col-md-offset-3 margin_top" >
			
			<button class="btn btn-danger form-control" title="Guardar" id="btnx" type="submit">Guardar</button>
	</div>
	
	</form>
<?php 
    foreach($hidden as $hid){?>
      <input type='hidden' class="hiddenCheck" value="<?php echo $hid['valor'] ?>" name="<?php echo $hid['nombre'] ?>_hid" id="<?php echo $hid['nombre'] ?>_hid" />

<?php }  
?>
	</div>
</div>
</div>  

<script>
function reqCheck(id,name,value){
     if($(id).is(':checked')){
                             
                                $('#'+name+'_hid').val(''+value+','+$('#'+name+'_hid').val()); 
                           }                            
                           else
                               $('#'+name+'_hid').val($('#'+name+'_hid').val().replace(''+value+',',''));
                           
                           console.log( $('#'+name+'_hid').val());
}

function hiddenCheck(){
    var result=Array();
    result['bool']=true;
    result['error'] ="";
    $('.error').hide();
    
    $('.hiddenCheck').each(function(){
        if($(this).val().length==0){
            result['bool'] = false;
            if(result['error']==""){
               result['error'] = '#'+$(this).attr('name').replace('hid','error');
               
            }
                
        }
            
      
    });
    return result;
    
}
    
$('#btnx').click(function(e){
    var validation=hiddenCheck();
    if(!validation['bool']){
        e.preventDefault();
        console.log(validation['error']);
        $(validation['error']).show();
        $('html,body').animate({
          scrollTop: $(validation['error']).offset().top-200
        }, 500)
    }        
    else
    console.log("GO");

    
});


$(document).ready(function() {
	
	
	
var bandInt=0, bandFloat=0;

var validaInt=1, validaFloat=1, validaString=1;
	$('#btnx').on('click', function(event) {
		

		
		$('form#formx').submit();
		//return false;
		
	});
	

	$('body').on('input','.float', function() { 
		
		var numero =  $(this).attr('value');
		var id=$(this).attr('id');
		if (!/^([0-9])*[.]?[0-9]*$/.test(numero))
		{
			if(bandFloat==0) // es incorrecto
			{
				$("#"+id+"e").removeClass("hide");
				bandFloat=1;
				validaFloat=0;
			}
			
		}
		else
		{
			if(bandFloat==1) // es correcto
			{
				$("#"+id+"e").addClass("hide");
				bandFloat=0;
				validaFloat=1;
			}
		}
   				
	  });
	  
	  	$('body').on('input','.int', function() { 
		var patron = /^\d*$/; 
		var numero =  $(this).attr('value'); 
		var id=$(this).attr('id');
		if ( !patron .test(numero))
		{
			if(bandInt==0) // es incorrecto
			{
				$("#"+id+"e").removeClass("hide");
				bandInt=1;
				validaInt=0;
			}	
			
		}
		else
		{
			if(bandInt==1) // es correcto
			{
				$("#"+id+"e").addClass("hide");
				bandInt=0;
				validaInt=1;
			}
			 
		}	
	  });
	  
	  
});	
</script>