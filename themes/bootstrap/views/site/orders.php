<?php 
$diferente=0;
$primera=0;
$total=0;
foreach($bolsaInventario as $carrito)
{
	if($diferente!=$carrito->almacen_id)
	{
		$suma=0;	
		$diferente=$carrito->almacen_id;	
	
	

?>	
<div class="orderContainer margin_top_small margin_bottom">
                <div class="title clearfix">
                   <div class="row-fluid">
                      <div class="col-md-6 no_horizontal_padding"></div>
                       <div class="col-md-6 no_horizontal_padding text-right"><?php echo $carrito->inventario->almacen->empresas->razon_social;?></div>
                   </div>
                </div>
                <div class="detail">
                    <table width="100%">
                        <col width="10%">
                        <col width="42%">
                        <col width="12%">
                        <col width="12%">
                        <col width="12%">
                        <col width="12%">
                        <thead>
                            <tr>
                                <th colspan="2">Producto</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-center">Precio Unt.</th>
                                <th class="text-center">Sub Total</th>
                                <th class="text-center"></th>
                                
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php 
                            $bolsita=BolsaHasInventario::model()->findAllByAttributes(array('almacen_id'=>$carrito->almacen_id, 'bolsa_id'=>$model->id));
                            foreach($bolsita as $bolsa) 
                            {
                            	$imagenPrincipal=Imagenes::model()->findByAttributes(array('producto_id'=>$bolsa->inventario->producto->id, 'orden'=>1));
                            	?>
                                <tr>
                                <td class="img"><img width="100%" src="<?php echo Yii::app()->getBaseUrl(true).$imagenPrincipal->url;?>"/></td>
                                <td class="name"> <?php echo $bolsa->inventario->producto->nombre;?></td>
                                <input type="hidden" id="maximo<?php echo $bolsa->id?>" value="<?php echo  $bolsa->inventario->cantidad;?>">
                                <td class="number"><input class="cadaUno" id="<?php echo $bolsa->id;?>cantidad" value="<?php echo $bolsa->cantidad;?>" type="number">
                               <a id="<?php echo $bolsa->id;?>" onclick="actualizar(<?php echo $bolsa->id;?>, 1)" style="" class="btn btn-mini">Actualizar</a></td>
                                <td class="number" id="unitario<?php echo $bolsa->id;?>"><?php echo $bolsa->inventario->precio;?> Bs</td></td>
                                <td class="number highlighted" id="subtotal<?php echo $bolsa->id;?>"> <?php echo $bolsa->inventario->precio*$bolsa->cantidad; ?> Bs</td>
                                <td class="link"><a onclick="actualizar(<?php echo $bolsa->id;?>, 2)">Eliminar</a></td>
                                
                                <?php $suma+=$bolsa->inventario->precio*$bolsa->cantidad;?>
                            </tr>
                            <?php
                            } ?>
                        </tbody>
                    </table>
                </div>
               

                <div class="summary text-right">
                	
                    <span id="total">Total: Bs. <?php echo $suma;  $total+=$suma;?></span>
                    <?php echo CHtml::submitButton('Generar orden por proveedor', array('id'=>$carrito->almacen_id."boton".$carrito->bolsa_id,'class'=>'btn-orange btn btn-danger btn-large orange_border margin_left cadaOrden')); ?>
                     
                    <!--<input class="btn-orange btn btn-danger btn-large orange_border margin_left" type="submit" name="yt0" value="Generar orden por proveedor"> -->
                </div>
            </div>
<?php	
	}
}
Yii::app()->session['suma']=$total;
?>


<script>
	$(document).ready(function() {
		$('.cadaUno').change(function() {
			var oid = $(this).attr("id");
			var res = oid.split("c"); //por el comienzo de  la palabra cantidad
			vari=res[0];
			//var vari = oid.substring(0, 1);
			
			var cantidad=$('#'+oid).val(); // la cantidad
			var maximo=$('#maximo'+vari).val();
			maximo=parseInt(maximo);
			cantidad=parseInt(cantidad);
					if(cantidad<=0)
	           	{
	           		$('#'+oid).val('1');
	           		//alert('epaa');
	           	}
	           	else
	           	{
	           	
				     if(cantidad>=maximo)
	           		{
	           			alert("El maximo de unidades es "+maximo);
	           			$('#'+oid).val(maximo); // la cantidad
	           			//$('#cantidad').val(maximo);
	           			//$('#unitario').html(maximo*unitario);
	           			
	           		}
	           		else
	           		{
	           			//$('#unitario').html(cantidad*unitario);
	           			
	           		}
	           		
			   }
		});
		
		
		$('.cadaOrden').click(function() {
			var oid = $(this).attr("id");
			var res = oid.split("b"); //por el comienzo de la palabra boton
			var almacen_id=res[0];
			var res2 = oid.split("n");
			var bolsa_id=res2[1];
			
			$.ajax({
			         url: "<?php echo Yii::app()->createUrl('Bolsa/actualizarInventario') ?>",
		             type: 'POST',
			         data:{
		                    almacen_id:almacen_id, bolsa_id:bolsa_id
		                   },
			        success: function (data) {
			        	
						location.reload();
			       	}
			    })
			
		});
	
	});
	
		
		function actualizar(id, opcion)
		{
			//opcion 1 es actualizar, 2 eliminar el registro completo
			var cantidad=$('#'+id+'cantidad').val(); // la cantidad
			var maximo=$('#maximo'+id).val();
			cantidad=parseInt(cantidad);
			maximo=parseInt(maximo);
			if(cantidad>=maximo)
				return false;	
			
			$.ajax({
			         url: "<?php echo Yii::app()->createUrl('Bolsa/actualizarInventario') ?>",
		             type: 'POST',
			         data:{
		                    id:id, opcion:opcion, cantidad:cantidad
		                   },
			        success: function (data) {
			        	
						location.reload();
			       	}
			    })
			
		}
</script>