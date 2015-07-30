
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
 foreach($categoriaAtributo as $catA)
 {
	$atributo=Atributo::model()->findByPk($catA->atributo_id);
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
				echo CHtml::label($atributo->nombre,'etiqueta'); if($obligatorio=="required") echo "*"; ?><br> <?php
				$rango=explode(",", $atributo->rango);
				$j=1;
				foreach($rango as $ra)
				{
					$arreglo=explode("==", $ra);
				?>				
					<input type="checkbox" name="<?php echo $atributo->nombre;?>" id="<?php echo $i."a".$j?>" value="<?php echo $arreglo[1];?>"><?php echo $arreglo[1];?><br>
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
 }?>
 	<div id="avanzar" class="col-md-6 col-md-offset-3 margin_top" >
			
			<button class="btn btn-danger form-control" title="Guardar" id="btnx" type="submit">Guardar</button>
	</div>
	
	</form>
	</div>
</div>
</div>  

<script>
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