<style>
.alert{padding:.75rem 1rem .75rem 3rem;border:1px solid #e8e8e8;background:#fff;color:#555459;border-left-width:5px;margin:0 auto 1rem;border-radius:.25rem;}
.alert.alert_warning{border-left-color:#ff5b0b}
.glyphicon-warning-sign:before{color: #ff5b0b;font-size:2.0rem;font-style:normal;}
.modificaciones {padding-top: 12px;}
.glyphicon:empty { width: 2em;}
.glyphicon:empty.off  { width: 1em;}
.oscuro{font-size: 14px;}
.modal2{overflow-y: auto; height:596px;}
.colorPrecioModal{color:#ff5b0b;}



</style>
<?php $this->breadcrumbs=array('Carrito'); 
if($cambios):
?> 
<div id="myModal2" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg"> 

    <!-- Modal content-->
    <div class="modal-content modal2">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title colorPrecioModal" style="text-align-last: center;font-weight: bold;">Productos que han cambiado</h3>
      </div>
      <div class="modal-body oscuro">
        <p>Los Siguientes productos han cambiado debido a modificaciones realizadas en el inventario por parte de las 
        empresas vendedoras</p>
        <ul>
            <?php foreach($cambios as $row):?>
                <li><b>* Producto: </b><?php echo $row->inventario->producto->nombre;?></li>
                <ul>
                    <li><b> Cantidad Disponible: </b><?php echo $row->inventario->cantidad;?></li>
                    <li><b> Precio: </b> <em class="colorPrecioModal"><?php echo Funciones::formatPrecio($row->inventario->precio);?></em></li>
                    <li><b> Empresa: </b><?php echo $row->inventario->almacen->empresas->razon_social;?></li>
                    <li><b> Almacen: </b><?php echo $row->inventario->almacen->nombre;?></li>
                </ul>
                <br>
            <?php endforeach;?>
        </ul>
      </div>
    </div>

  </div>
</div>
<?php endif;?>
<div class="col-md-12 margin_top_small">
    <h1 class="dark no_margin">INTENCIONES DE COMPRA</h1>
</div>
<div class="col-md-12 no_horizontal_padding cart">
    <div class="row-fluid">
        <div class="col-md-9">
            <?php $this->renderPartial('orders',array('orders'=>NULL,'model'=>$model, 'bolsaInventario'=>$bolsaInventario)); ?>
        </div>        
        <div class="col-md-3">
            <div class="orderAll margin_top_small">
                Subtotal:<?php echo Funciones::formatPrecio($sub=Yii::app()->session['suma']);?><br/>
                IVA: <?php echo Funciones::formatPrecio($iva=Yii::app()->session['suma']*0.12);?> <br/>
                <span class="total">
                    Total: <?php echo Funciones::formatPrecio(Yii::app()->session['suma']+$iva);  unset(Yii::app()->session['suma']);?>
                </span>
                <input class="btn-green btn btn-danger margin_top_small todosBotones" type="submit" id="procesarTodo" name="yt0" value="Procesar todas las órdenes">
            </div>
            <div class="text-center margin_top_xsmall">
                <a class="blueLink" href=" <?php echo Yii::app()->baseUrl; ?>/tienda">Seguir Comprando</a>
            </div>
            <!--<div class="text-center mutedLink">
                <a class="muted" href="#">Ver políticas de envíos y devoluciones</a>
            </div>-->
            <?php 
            if($cambios)
            {
                 ?>
                <div class="modificaciones">
                <p id="search_results_message_limit"  class="alert alert_warning">
                    <i class="glyphicon glyphicon-warning-sign"></i>
                    Algunos productos han cambiado debido a modificaciones en el inventario. <a data-toggle="modal" data-target="#myModal2" class="bold blueLink">Ver detalle</a>
                    
                </p>
                </div>
               <?php 
            }
            ?>
            <div class="orderedContainer margin_top_small" id="orderedContainer">
                <div class="ordered">
                    
                </div>
                <div class="margin_top text-center">
                    <a class="btn btn-darkgray" href="<?php echo Yii::app()->baseUrl?>/orden/misCompras">Ver Todas</a>
                </div>
                
            </div>
        </div>
        
    </div>
</div>
  

<script>
	$(document).ready(function() {
		$('#procesarTodo').click(function() {
            $('.todosBotones').prop( "disabled", true );
			var bolsa_id= '<?php echo $model->id;?>';
			var empresas_id='<?php echo $model->empresas_id;?>';
			var monto= <?php echo $sub;?>;
			var iva= <?php echo $iva?>;
			
						$.ajax({
			         url: "<?php echo Yii::app()->createUrl('Orden/procesarTodo') ?>",
		             type: 'POST',
		             dataType:'json', 
			         data:{
		                    bolsa_id:bolsa_id, empresas_id:empresas_id, monto:monto, iva:iva
		                   },
			        success: function (data) {
			         
                        if(data.status='ok'){
                            
                            
                        var path= "<?php echo Yii::app()->createUrl('Orden/misCompras') ?>";
                        window.location.href = path;
                            
                           /* $('#orderedContainer>.ordered').html(data.html);
                             $('#orderedContainer').fadeIn();
                             $('.orderContainer').fadeOut();
                             $('.orderContainer').remove();*/
                        }
                        
                        
                        
                    }
			    })
		});
	});	
</script>



