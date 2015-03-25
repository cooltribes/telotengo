<?php
/* @var $this OrdenController */

$this->breadcrumbs=array(
	'Orden'=>array('admin'),
	'Detalle'=>array('detalleusuario','id'=>$orden->id),
	'Devolucion',
);
$returnable=false;
?>
<style> .table td {vertical-align:middle; text-align:center;}</style>
<script type="text/javascript">
	var indices=Array();
	var montos=Array();
	var cantidades=Array();
	var looks=Array();
	var motivos=Array();
	var ptcs=Array();
</script>

	<?php if(Yii::app()->user->hasFlash('success')){?>
	    <div class="alert in alert-block fade alert-success text_align_center">
	        <?php echo Yii::app()->user->getFlash('success'); ?>
	    </div>
	<?php } ?>
	<?php if(Yii::app()->user->hasFlash('error')){?>
	    <div class="alert in alert-block fade alert-error text_align_center">
	        <?php echo Yii::app()->user->getFlash('error'); ?>
	    </div>
	<?php } ?>

	<div class="container margin_top">
		<h1> Solicitud de Devolución <small>(Pedido #<?php echo $orden->id;?>)</small></h1>  
		<input type="hidden" id="orden_id" value="<?php echo $orden->id; ?>" />
		<hr/>
		<div class="margin_left_small margin_top">
			<p class="T_xlarge"><?php echo number_format($orden->total, 2, ',', '.');  ?></p>
			<span>Precio total del pedido</span>
		</div>

	   <div> 
	     <h3 class="braker_bottom">Productos comprados</h3>
	      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
	        <tr>
	        	<th scope="col"></th>
	        	<th scope="col">SKU</th>
				<th scope="col">Marca</th>
				<th scope="col">Nombre</th>
				<th scope="col">Cantidad a<br/>Devolver</th>
				<th scope="col">Precio</th>
				<th scope="col">Motivo</th>          
	        </tr>

			<?php
			$indice=0;
			$row=0;
        	$productos = OrdenHasInventario::model()->findAllByAttributes(array('orden_id'=>$orden->id)); // productos de la orden
		
			if(count($productos) > 0)	
				echo("<tr class='bg_color5'><td colspan='9'></td></tr>");
				
				foreach($productos as $prod){
					$inventario = Inventario::model()->findByAttributes(array('id'=>$prod->inventario->id)); // consigo existencia actual y precio
					$indiv = Producto::model()->findByPk($inventario->producto_id); // consigo nombre
					$marca = Marca::model()->findByPk($indiv->marca_id);
	    			
					$imagen = Imagen::model()->findByAttributes(array('producto_id'=>$indiv->mainimage->id));
					$foto = CHtml::image(Yii::app()->baseUrl.str_replace(".","_thumb.",$imagen->url), "Imagen ", array("width" => "70", "height" => "70"));

					echo("<tr>");
					echo("<td style='text-align:center'><div>".$foto."</div></td>");
                     
    				echo('<td style="vertical-align: middle">'.$indiv->codigo.'</td>');
                   	echo("<td>".$inventario->sku."</td>");                       
                   	echo("<td>".$marca->nombre."</td>");
                   	echo("<td>".$indiv->nombre."</td>");
                   	echo("<td>".$marca->nombre."</td>");
                  	echo "<td><input type='number' id='inventario_".$inventario->id."_0' value='0' class='input-mini cant' max='".$prod->cantidad."' min='0' required='required' /></td>";
                   	echo("<td>".number_format($inventario->precio, 2, ',', '.')."</td>");               
    				echo(CHtml::dropDownList($inventario->id."_motivo",'',Devolucion::model()->reasons,array('empty'=>'Selecciona una opcion'))."</td>");
					echo CHtml::hiddenField($inventario->id."_cantidad"); 
					echo CHtml::hiddenField($inventario->id."_precio",$inventario->precio);
					echo"<script>ptcs.push('".$ptc->id."');</script>";

					echo"<script>montos.push('0');</script>"; 
					echo"<script>cantidades.push('0');</script>";
				}
			else{
				echo "<td colspan='3'>Este producto se encuentra en proceso de devolución </td>";
			}

    		echo "</tr>";
    				 
    		}
		}
	}

    ?>

        <tr>
        	<td colspan="8"><div class="text_align_right"><strong>Monto a devolver BsF:</strong></div></td>
        	<td class="text_align_right"><input class="text_align_right" type="text" readonly="readonly" id="monto" value="000,00" /> </td>
        </tr>
    	</table>
    	<div class="pull-right">
    	    <a onclick="devolver()" id="buttonReturn" title="Devolver productos" style="cursor: pointer;" class="btn btn-warning btn-large">Hacer devolución</a>
    	   <a id="proccessing" style="cursor: pointer;" class="btn btn-large hide">Procesando...</a>
    	</div>
	</div>

</div> 
<!-- /container --> 
<script type="text/javascript">
	
var monto = 0;        
	$( ".motivos" ).change(function() {
  		var hidden = $(this).attr('id').replace('motivo','indice');
  		var indice = parseInt($('#'+hidden).val());

  		if($(this).val()=='')
  			motivos[indice]='-';
  		else
  			motivos[indice]= $(this).val();  			
	}); 



 $('body').on('input','.cant', function(){
 	var a =  parseInt($(this).val());
 	var b = parseInt($('#'+$(this).attr('id')+'hid').val());
 	if(isNaN(a)){
	    	$(this).val('0'); 
	    	actualizarArrays(parseInt($('#'+$(this).attr('id')+'indice').val()),a,0);
	    	$(this).val('0'); $('#'+$(this).attr('id')+'motivo').val('');  $('#'+$(this).attr('id')+'motivo').prop('disabled', 'disabled'); 
	   		
	}
	else {
		if(a>b){
			$(this).val('0'); 
			actualizarArrays(parseInt($('#'+$(this).attr('id')+'indice').val()),0,0);			
	   	}
		if(a<1&&a>0){
			$(this).val('0'); $('#'+$(this).attr('id')+'motivo').val('');  $('#'+$(this).attr('id')+'motivo').prop('disabled', 'disabled'); 
			actualizarArrays(parseInt($('#'+$(this).attr('id')+'indice').val()),0,0);	
		}
		if(a<=b&&a>0){
			$('#'+$(this).attr('id')+'motivo').val('');  $('#'+$(this).attr('id')+'motivo').prop('disabled', false); 
			actualizarArrays(parseInt($('#'+$(this).attr('id')+'indice').val()),a,parseFloat($('#'+$(this).attr('id')+'precio').val()));
			
		}
		if(a==0){
			$('#'+$(this).attr('id')+'motivo').val('');  $('#'+$(this).attr('id')+'motivo').prop('disabled', 'disabled'); 
			actualizarArrays(parseInt($('#'+$(this).attr('id')+'indice').val()),0,0); 			
	   	}		
	}
	
	 calcularDevolucion();
  
});

function calcularDevolucion(){
	var i=0;
	var acum=0;
	for(i=0; i<montos.length;i++){
		acum=acum+parseFloat(montos[i]);
	}
	$('#monto').val(parseFloat(acum).toFixed(2));
}

$( document ).ready(function() {
  console.log(montos.toString()+" "+indices.toString()+" "+cantidades.toString());
});

function actualizarArrays(indice,cantidad,monto ){
	montos[indice]=parseFloat(cantidad)*parseFloat(monto);
	cantidades[indice]=parseFloat(cantidad);
	if(cantidad==0)
		motivos[indice]='-';
	console.log(montos.toString()+" - "+cantidades.toString()+" - "+ptcs.toString());
}

function devolver()
	{			//console.log(cantidades.toString()+" // "+motivos.toString());
				blockReturn(true);
				var ct=0;
				var mt=0;
				for(var i =0; i<indices.length; i++){
					if(parseInt(cantidades[i])>0)
						ct++;
					if(motivos[i]!='-')
						mt++;
				}
				if(ct==mt&&ct!=0){
				    var id = $('#orden_id').attr('value');
                    var monto = $('#monto').attr('value');
                    	var inds=indices.toString();
						var monts=montos.toString();
						var cants=cantidades.toString();
						var lks=looks.toString();
						var mots=motivos.toString();
						var prtcs=ptcs.toString();
                 
                     
                    
                    $.ajax({
                        type: "post", 
                        dataType: 'json',
                        url: "../devolver", // action 
                        data: { 'orden':id, 'monto':monto,'indices':inds, 'montos':monts, 'motivos':mots, 'ptcs':prtcs, 'looks':lks,'cantidades':cants}, 
                        success: function (data) {
                        	//console.log(data.productos);
                        	// agregar pdoductos devueltos
                        	for (var i = data.productos.length - 1; i >= 0; i--) {
                        		//console.log('ID: '+data.productos[i].id);
                        		ga('ec:addProduct', {
								  'id': data.productos[i].id,       // Product ID is required for partial refund.
								  'quantity': data.productos[i].quantity         // Quantity is required for partial refund.
								});
                        	};
                        	// enviar devolución a analytics
                        	ga('ec:setAction', 'refund', {
							  'id': id,       // Transaction ID is required for partial refund.
							});

                            if(data.status=="okuser")
                                    window.location.replace("<?php echo Yii::app()->baseUrl;?>/orden/detallePedido/"+id);
                            if(data.status=="okadmin")
                                    window.location.replace("<?php echo Yii::app()->baseUrl;?>/orden/detalles/"+id);
                            
                            if(data.status=="error")
                                    location.reload();
                            if(data.status=='no')
                            	location.reload();       
                         }
                    });		
                }
                else{
                    if(ct==mt&&mt==0)
                	   alert('No has seleccionado productos para devolver');
                	else  
                	   alert('Para cada prenda que desees devolver debes especificar el motivo de la devolución');
                	blockReturn(false);   
                }		
		
		}
function blockReturn(bool){
    if(bool){
        $('#buttonReturn').addClass('hide');
        $('#proccessing').removeClass('hide');
    }else{
        $('#buttonReturn').removeClass('hide');
        $('#proccessing').addClass('hide');
    }
}		
	
</script>