
 
 
 
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
				<?php echo CHtml::label($atributo->nombre,'etiqueta'); ?>
				<input type="checkbox" name="<?php echo $atributo->nombre?>" id="<?php echo $i;?>" class="<?php echo $tipo;?>"><br>				
			</div>
		<?php
		}
		else 
		{
			if($atributo->tipo==5) // si es de tipo fecha
			{
				?>
				<div class="col-md-6 col-md-offset-3 margin_top_small">
					<?php echo CHtml::label($atributo->nombre,'etiqueta'); ?>
					<input type="date" name="<?php echo $atributo->nombre?>" id="<?php echo $i;?>" class="<?php echo $tipo;?>" <?php echo $obligatorio;?>><br>
				</div>
			<?php
			}
			else // si es de otro tipo
			{
				?>
				<div class="col-md-6 col-md-offset-3 margin_top_small">
					<?php echo CHtml::label($atributo->nombre,'etiqueta'); ?>
					<input type="text" name="<?php echo $atributo->nombre?>" id="<?php echo $i;?>" class="<?php echo $tipo;?>" <?php echo $obligatorio;?> <?php echo $patron;?> <?php echo $mensaje;?>>
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
				echo CHtml::label($atributo->nombre,'etiqueta'); 
				$rango=explode(",", $unidad->rango);
				?>
				<input type="text" name="<?php echo $atributo->nombre?>" id="<?php echo $i;?>" class="<?php echo $tipo;?>" <?php echo $obligatorio;?> <?php echo $patron;?> <?php echo $mensaje;?>>
				<select>
				<?php 
				foreach($rango as $ra)
				{
					$arreglo=explode("==", $ra);
				?>				
					<option value="<?php echo $arreglo[1];?>"><?php echo $arreglo[1];?></option>
				<?php
				}
				?>
				</select>
				<span id="<?php echo $i."e";?>" class="error margin_top_small_minus hide"><br/><small>Formato no válido</small></span><br>
				</div>
				<?php
			}
			else 
			{?>
				<div class="col-md-6 col-md-offset-3 margin_top_small" id="<?php echo "checkbox-".$i?>">
				<?php 
				echo CHtml::label($atributo->nombre,'etiqueta');?><br> <?php
				$rango=explode(",", $unidad->rango);?>
				<input type="text" name="<?php echo $atributo->nombre?>" id="<?php echo $i;?>" class="<?php echo $tipo;?>" <?php echo $obligatorio;?> <?php echo $patron;?> <?php echo $mensaje;?>>
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
				echo CHtml::label($atributo->nombre,'etiqueta'); 
				$rango=explode(",", $atributo->rango);
				?>
				<select class="form-control">
				<?php 
				foreach($rango as $ra)
				{
					$arreglo=explode("==", $ra);
				?>				
					<option value="<?php echo $arreglo[1];?>"><?php echo $arreglo[1];?></option>
				<?php
				}
				?>
				</select>
				</div>
				<?php
			}
			else 
			{?>
				<div class="col-md-6 col-md-offset-3 margin_top_small" id="<?php echo "checkbox-".$i?>">
				<?php 
				echo CHtml::label($atributo->nombre,'etiqueta');?><br> <?php
				$rango=explode(",", $atributo->rango);
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