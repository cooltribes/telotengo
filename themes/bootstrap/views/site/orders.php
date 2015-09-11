<?php 
$diferente=0;
$primera=0;
foreach($bolsaInventario as $carrito)
{
	if($diferente!=$carrito->almacen_id)
	{
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
                            $bolsita=BolsaHasInventario::model()->findAllByAttributes(array('almacen_id'=>$carrito->almacen_id));
                            foreach($bolsita as $bolsa) 
                            {
                            	$imagenPrincipal=Imagenes::model()->findByAttributes(array('producto_id'=>$bolsa->inventario->producto->id, 'orden'=>1));
                            	?>
                                <tr>
                                <td class="img"><img width="100%" src="<?php echo Yii::app()->getBaseUrl(true).$imagenPrincipal->url;?>"/></td>
                                <td class="name">MOUSE MICROSOFT OPTICAL <?php echo $bolsa->inventario->producto->nombre;?></td>
                                <input type="hidden" id="maximo+<?php echo $bolsa->id?>" value="<?php echo  $bolsa->inventario->cantidad;?>">
                                <td class="number"><input class="cadaUno" id="<?php echo $bolsa->id;?>cantidad" value="<?php echo $bolsa->cantidad;?>" type="number"></td>
                                <td class="number"><?php echo $bolsa->inventario->precio;?> Bs</td>
                                <td class="number highlighted" id="subtotal+<?php echo $bolsa->id;?>"> <?php echo $bolsa->inventario->precio*$bolsa->cantidad; ?> Bs</td>
                                <td class="link"><a href="#">Eliminar</a></td>
                                
                            </tr>
                            <?php
                            } ?>
                        </tbody>
                    </table>
                </div>
                <div class="summary text-right">
                    <span id="total">Total: Bs. 420.000</span>
                    <input class="btn-orange btn btn-danger btn-large orange_border margin_left" type="submit" name="yt0" value="Generar orden por proveedor">
                </div>
            </div>
<?php	
	}
}?>


<script>
	$(document).ready(function() {
		$('.cadaUno').change(function() {
			var oid = $(this).attr("id");
			alert(oid);
			//alert($('#cantidad2&').val());
			//alert($('#'+oid).val());
		
		});
	});
</script>
