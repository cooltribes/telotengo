<div class="container">

<?php
$this->breadcrumbs=array(
	'Pedidos'=>array('admin'),
	'Devolución',
);
?>

	<?php if(Yii::app()->user->hasFlash('success')){?>
		<div class="alert in alert-block fade alert-success text_align_center">
	<?php echo Yii::app()->user->getFlash('success'); ?> 
	</div>
	<?php } ?>
	<?php if(Yii::app()->user->hasFlash('error')){?>
		<div class="alert in alert-block fade alert-danger text_align_center">
			<?php echo Yii::app()->user->getFlash('error'); ?>
		</div>
	<?php } ?>	

    <div class="row-fluid">
        <div role="main">
            <div class="row-fluid">
                <h1>Procesar devolución - Pedido #<?php echo $model->id; ?><small class="pull-right">Detalles del pedido</small></h1>
                
        <section>                                     
            <div>
                <table class="table" >
                <thead>
                    <tr>
                        <th></th>
                        <th>Imagen</th>
                        <th>Nombre del producto</th>
                        <th>Marca</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Motivo</th>
                    </tr>
                </thead>
                    <tbody>
                        <input type="hidden" id="orden_id" value="<?php echo $model->id; ?>" />
                        <?php
                        foreach ($model->ordenHasInventarios as $orden_inventario) {
                            $inventario = Inventario::model()->findByAttributes(array('id'=>$orden_inventario->inventario->id)); // consigo existencia actual y precio
                            $indiv = Producto::model()->findByPk($inventario->producto_id); // consigo nombre
                            $marca = Marca::model()->findByPk($indiv->marca_id);

                            ?>
                            <tr>
                                <td>
                                    <input id="precio-<?php echo $orden_inventario->id; ?>" type='hidden' value="<?php echo $orden_inventario->precio; ?>" />
                                    <input id="envio-<?php echo $orden_inventario->id; ?>" type='hidden' value="<?php echo $orden_inventario->orden->envio; ?>" />
                                    <input class='check checkbox' id="<?php echo $orden_inventario->id; ?>" type='checkbox' value='' />
                                </td>
                                <td><?php
                                    $imagen = Imagenes::model()->findByAttributes(array('producto_id'=>$indiv->id));
                                    $foto = CHtml::image(Yii::app()->baseUrl.str_replace(".","_thumb.",$imagen->url), "Imagen ", array("width" => "70", "height" => "70"));
                                    echo $foto;
                                ?></td>
                                <td>
                                    <div><?php echo $orden_inventario->inventario->producto->nombre; ?></div>
                                </td>
                                <td><?php echo $marca->nombre; ?></td>
                                <td><?php echo $orden_inventario->precio; ?> Bs.</td>
                                <td><?php echo $orden_inventario->cantidad; ?></td>
                                <td>
                                    <select disabled="true" id="motivo-<?php echo $orden_inventario->id; ?>" class="form-control input-medium">
                                        <option>-- Seleccione --</option>
                                        <option>Cambio por otro articulo</option>
                                        <option>Devolución por artículo dañado</option>
                                        <option>Devolución por insatisfacción</option>
                                        <option>Devolución por pedido equivocado</option>
                                    </select>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                    </table>
                    <br/>
                    <table class="pull-right table">
                            <tr>
                                <th style="border-top: 0px;"><div class=""><h2><strong>Resumen</strong></h2></div></th>
                            </tr>       
                            <tr>
                                <td colspan="12"><div class=""><strong>Monto a devolver Bs.:</strong></div></td>
                                <td style="width:35%;"><input class="form-control" type="text" readonly="readonly" id="monto" value="000,00" /> </td>
                            </tr>
                            <tr>
                                <td colspan="12"><div class=""><strong>Monto por envío a devolver Bs.:</strong></div></td>
                                <td style="width:35%;"><input class="form-control " type="text" readonly="readonly" id="montoenvio" value="000,00" /> </td>
                            </tr>
                            <tr>
                                <td colspan="12"><div class=""><strong>Total Bs.:</strong></div></td>
                                <td style="width:35%;"><input class="form-control " type="text" readonly="readonly" id="montoTotal" value="000,00" /></td>
                            </tr>        
                            </table>
                            <div class="pull-right"><a onclick="devolver()" title="Devolver productos" style="cursor: pointer;" class="btn btn-danger btn-large">Hacer devolución</a>
                            </div>
                                            
                        </div>
                    </section>

            </div>
            <!-- COLUMNA PRINCIPAL DERECHA OFF // -->
        </div>
    </div>
</div>

<script type="text/javascript">
    
var monto = 0;        
var montoEnvio = 0;        
var montoTotal = 0;    

function actualizarTotal(){
    
    montoTotal = parseFloat(monto) + parseFloat(montoEnvio);
    $('#montoTotal').val(Math.round(montoTotal * 100) / 100);
}        
        
function actualizarMonto(precio,tipo){
    
    monto = parseFloat(monto) + parseFloat(precio);
    if(tipo == "resta")
        montoEnvio = 0;

//    $('#monto').val(monto.toString());
    $('#monto').val(Math.round(monto * 100) / 100);
    actualizarTotal();   
}

        /*Marcar / desmarcar*/
    $(".check").click(function() {
        if($(this).is(':checked')){
                //sumar
            var id = $(this).attr('id');
//            actualizarMonto(parseFloat($('#precio-'+id).attr('value')));          
//            console.log($('#precio-'+id).val());
            
            $('#montoenvio').val(parseFloat($('#envio-'+id).val()));
            montoEnvio = $('#montoenvio').val();
            actualizarMonto(parseFloat($('#precio-'+id).val()),"suma");            
            $(".input-medium#motivo-"+id).prop('disabled', false);

        }
        else
        {// restar
            var id = $(this).attr('id');            
            $('#montoenvio').val(0);                    
            //monto = parseFloat(monto) - parseFloat($('#precio-'+id).attr('value'));                   
            $(".input-medium#motivo-"+id).prop('selectedIndex',0);            
            $(".input-medium#motivo-"+id).change();
            $(".input-medium#motivo-"+id).prop('disabled', true);            
            
            actualizarMonto(-parseFloat($('#precio-'+id).val()),"resta");   
        }

    });
    
    $(".input-medium").change(function() {
            var motivos = new Array();

            var checkValues = $(':checkbox:checked').map(function() {
                    motivos.push ( $('#motivo-'+this.id).attr('value') );

                    return this.id;
            }).get().join();

            /*if( motivos.indexOf("Devolución por prenda dañada") != -1 
                    || motivos.indexOf("Devolución por pedido equivocado") != -1 )
            {

                
                var id = $('#orden_id').attr('value');
                //var monto = $('#monto').attr('value');

                $.ajax({
                type: "post", 
                url: "<?php echo Yii::app()->baseUrl; ?>/orden/calcularenvio", // action 
                data: { 'orden':id, 'check':checkValues, 'motivos':motivos}, 
                success: function (data) {
                    
                    montoEnvio = parseFloat(data);
                    $('#montoenvio').val(montoEnvio);
                    actualizarTotal();  
                                        

                }//success
                }); 

                //Otros motivos
            }else{
            
               
                
                //$('#montoenvio').val(montoEnvio);
            }*/

            //montoEnvio = 0.00;   
            
            actualizarTotal();  
            
    });

    function devolver()
    {
        var motivos = new Array();
        
        var checkValues = $(':checkbox:checked').map(function() {
            motivos.push ( $('#motivo-'+this.id).attr('value') );

            return this.id;
        }).get().join();
        
        if(checkValues==""){                    
                    alert("Debe seleccionar al menos un artículo");
                }else if(motivos.indexOf("-- Seleccione --") != -1)
                    alert("Debe indicar un motivo de devolución para las prendas seleccionadas.");          
        else{
            
            var id = $('#orden_id').attr('value');
            var monto = $('#monto').attr('value');
            var envio = $('#montoenvio').attr('value');
            
            $.ajax({
                type: "post", 
                url: "../procesarDevolucion", // action 
                data: { 'orden':id, 'check':checkValues, 'monto':monto, 'motivos':motivos, 'envio':envio}, 
                success: function (data) {
                    console.log(data);
                    if(data=="ok")
                        window.location = "<?php echo Yii::app()->createUrl('orden/detalle', array('id'=>$model->id)); ?>";

                }//success
            });             
        }
    }
    
</script>
