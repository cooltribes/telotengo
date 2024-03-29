<style>
.reducirNombre{font-size:20px;}
.bold{ font-weight: bold;};
</style>
<?php $this->breadcrumbs=array('Mis Ventas'=>Yii::app()->createUrl('orden/misVentas'),'Orden #'.$model->id); ?> 
<div id="orderDetail" class="row-fluid margin_top">
   

        <?php 
        if($model->estado ==0 && !empty($model->disponibilidadInventario($model->id)))
        {?>

          <div class="alert in alert-block fade alert-danger text_align_left bold existencia">
          Los Siguientes Items no tienen inventario <br>
          <ul>
          <?php
          foreach($model->disponibilidadInventario($model->id) as $noDisponible)
          {
              $modelado=inventario::model()->FindByPk($noDisponible);
              echo "<li>* ".$modelado->producto->nombre; echo " solo dispone de ".$modelado->cantidad." unidades </li>";
          }
          ?>
          </ul>  
        </div>
    <?php
        } ?>
    
    <h2>SOLICITUD DE VENTA</h2>
    <div class="col-md-8 cart no_horizontal_padding margin_top_small">
        <div class="orderContainer margin_bottom">
                <div class="title clearfix">
                   <div class="row-fluid">
                      <div class="col-md-10 no_horizontal_padding reducirNombre">Almacen: <?php echo $model->almacen->alias;?></div>
                      <div class="col-md-2 no_horizontal_padding text-right">ORDEN #<?php echo $model->id;?></div>
                  
                   </div>
                </div>
                <div class="detail padding_left_xsmall padding_right_xsmall">
                    <table width="100%">
                        <colgroup>
                        <col width="10%">
                        <col width="30%">
                        <col width="10%">
                        <col width="10%">
                        <col width="10%">
                        <col width="10%">
                        <col width="10%">
                        <col width="10%">
                        </colgroup><thead>
                            <tr>
                                <th colspan="2">Producto</th>
                                <th class="text-center">Codigo TLT</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-center">Precio Unt.</th>
                                <th class="text-center">Sub Total</th>
                                <!-- <th class="text-center">I. V. A.</th>
                                  <th class="text-center">Precio Total</th>-->
                               
                            </tr>
                        </thead>
                        
                        <tbody>
                        	
                        	<?php 
                        	$acumulado=0;
                        	foreach($productoOrden as $proc):
                        	$imagenPrincipal=Imagenes::model()->findByAttributes(array('producto_id'=>$proc->inventario->producto->id, 'orden'=>1));
                        	?>
                             <tr>
                             	<td class="img"><img width="100%" src="<?php echo Yii::app()->getBaseUrl(true).$imagenPrincipal->url;?>"/></td> 
                                <td class="name"> <?php echo $proc->inventario->producto->nombre;?></td>
                                <td class="number"><?php echo $proc->inventario->producto->tlt_codigo;?></td>
                                <td class="number"><?php echo $cantidad=$proc->cantidad;?></td>
                                <td class="number"><?php $precio=$proc->monto; echo Funciones::formatPrecio($precio);?></td>
                                <td class="number highlighted"><?php $sub=$precio*$cantidad; echo Funciones::formatPrecio($sub); ?></td>
                                <?php /*
                                <td class="number"><?php $iva=$precio*$cantidad*Yii::app()->params['IVA']['value']; echo Funciones::formatPrecio($iva);?></td>
                                <td class="number highlighted"><?php $tota=$sub+$iva; echo Funciones::formatPrecio($tota);?></td>*/
                                  $acumulado+=$sub; ?>
                                
                            </tr>
                            <?php endforeach;  ?>
                            
                       </tbody>
                    </table>
                </div>
               

                <div class="summary text-right">
                    
                    <span id="SubTotal">SubTotal: <?php echo Funciones::formatPrecio($acumulado);?></span><br>
                    <span id="total">IVA: <?php $iva=$acumulado*Yii::app()->params['IVA']['value']; echo Funciones::formatPrecio($iva);?></span><br>
                    <span id="total">Total: <?php echo Funciones::formatPrecio($acumulado+$iva);?></span>
                   
                </div>
            </div>
    </div>
    
    
    <div class="col-md-4 margin_top_small">
        
        <div class="orderInfo no_horizontal_padding ">

          
            <div class="padding_left" style="border:1px solid #CCC">
                   <h4 class="margin_top_small">Estado actual </h4>
            <?php
            if($model->estado==0) 
            {?>
               
                   <p class="estadoOrden"><span id="estado" class="yellow-text"><?php echo $model->estados($model->estado);?></span></p> 
                   <div class="padding_bottom">
                   <?php 
                   if($model->disponibilidadInventario()==true)
                   { 
                   ?>
                      <a href="#" class="btn-orange btn orange_border margin_left white" data-toggle="tooltip"  title="Uno de los Items de la orden, no tiene suficiente inventario">Aceptar</a>
           <?php   }
                    else
                    {
                      echo CHtml::submitButton('Aceptar', array('id'=>'aceptar','name'=>$model->id,'class'=>'btn-orange btn orange_border margin_left white')); 
                    } 
                    echo CHtml::submitButton('Rechazar', array('id'=>'cancelar','name'=>$model->id,'class'=>'btn btn-darkgray margin_left')); ?> 
                </div>
                    
            <?php   
            }
            if($model->estado==1)
            {?>       
                        <p class="estadoOrden"><span id="estado" class="aceptado"><?php echo $model->estados($model->estado);?></span></p>
            <?php   
            }
            if($model->estado==2)
            {?>       
                        <p class="estadoOrden"><span id="estado" class="rechazado"><?php echo $model->estados($model->estado);?></span></p>
            <?php   
            }
            ?>
        </div>
       
            <div class="margin_top sellerInfo">
   
                    <h3>Información del Comprador</h3>
          
               <ul>
                   <li>
                            <span class="name">N° de Orden:</span>
                            <span class="value"><?php echo $model->id;?></span>
                   </li>
                   <li>
                            <span class="name">Fecha de Emisión:</span>
                            <span class="value"><?php $date = date_create($model->fecha);echo date_format($date, 'd/m/Y H:i:s');?></span>  
                   </li>
                   <li>
                            <span class="name">Empresa:</span>
                            <span class="value"><?php echo $model->empresa->razon_social;?></span>
                   </li>
                   <li>
                            <span class="name">Estado:</span>
                            <span class="value"><?php echo $model->empresa->city->provincia->nombre;?></span>
                   </li>
                  <li>
                            <span class="name">Ciudad:</span>
                            <span class="value"><?php echo $model->empresa->city->nombre;?></span>
                   </li>
                   <li>
                            <span class="name">Direccion:</span>
                            <span class="value"><?php echo $model->empresa->direccion;?></span>
                   </li>
                   <li>
                            <span class="name">RIF:</span>
                            <span class="value"><?php echo $model->empresa->rif;?></span>
                   </li>
                   <li>
                            <span class="name">Teléfono:</span>
                            <span class="value"><?php echo $model->empresa->telefono;?></span> 
                   </li>
                   <li>
                              <span class="name">Generado por</span>
                              <span class="value"><?php echo Profile::model()->retornarNombreCompleto($model->users->id);?></span>  
                    </li>
                      <li>
                            <span class="name">Correo Electrónico:</span>
                            <span class="value"><?php echo $model->users->email;?></span>  
                   </li>
                   
                   
               </ul>
                
               
                
                
               <!-- <p>
                    <span class="name">Dirección de Envío:</span>
                    <span class="value">Edif. Los Mirtos, Piso 3 Oficina 3 San Cristóbal Edo. Táchira</span>
               </p> -->
                
               
            </div>
        </div>
        <div class="separator margin_top_small margin_bottom_small"></div>
        
        <div class=" orderActions no_horizontal_padding margin_top_small">
            <h4 class="margin_top_small">Acciones</h4>
            <table width="100%" class="table-striped" id="tabla">
                <col width="30%">
                <col width="40%">
                <col width="30%">
                <thead>
                    <tr>
                        <th>Estado</th>
                        <th>Usuario</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($ordenEstado as $local): ?>
                    <tr>
                        <td><?php echo $local->orden->estados($local->estado);?></td>
                        <td><?php echo $local->user->profile->first_name." ". $local->user->profile->last_name;?></td>
                        <td><?php $date = date_create($local->fecha);echo date_format($date, 'd/m/Y H:i:s');;?></td>
                    </tr>
                    
                   <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        
        
        
        
    </div>
    
    
    
</div>
<script>
		$(document).ready(function() {
      $('[data-toggle="tooltip"]').tooltip(); 
			$('#aceptar').click(function() {
                $('#aceptar').prop( "disabled", true );
                $('#cancelar').prop( "disabled", true );
				var id=$(this).attr("name");
				var estado=1;
				cambio(id, estado);

			});
			
			$('#cancelar').click(function() {
                $('#cancelar').prop( "disabled", true );
                $('#aceptar').prop( "disabled", true );
				var id=$(this).attr("name");
				var estado=2;
				cambio(id, estado);

			});
			
			function cambio(id, estado)
			{
					$.ajax({
			         url: "<?php echo Yii::app()->createUrl('Orden/cambiarEstado') ?>",
		             type: 'POST',
                 dataType:'json',
			         data:{
		                    id:id, estado:estado
		                   },
			        success: function (data) {
			        	
			        	$('#aceptar').hide();
			        	$('#cancelar').hide();
			        	var user="<?php echo User::model()->FindByPk(Yii::app()->user->id)->profile->first_name." ".User::model()->FindByPk(Yii::app()->user->id)->profile->last_name;?>";     	 
			        	var fecha="<?php $date = date_create(date("Y-m-d H:i:s"));echo date_format($date, 'd/m/Y H:i:s');?>" ; 
                if(data.estado==1)
			        	{
			        		$('#estado').addClass('aceptado');
			        		$('#estado').html('Aceptada');
			        		var variable="Aprobada";
                   ga('require', 'ecommerce');

                  ga('ecommerce:addTransaction', {
                      'id': data.orden_id,                     // id de la orden
                      'affiliation': data.empresa_nombre,   // nombre de la empresa
                      'revenue': data.monto,               //  monto sin Iva
                      'tax': data.iva                   // el iva del producto
                    });

                  jQuery.each( data.arrayProductos, function( i, val ) {

                    //alert(val['sku']);
                    ga('ecommerce:addItem', {
                          'id': data.orden_id,            // id de la orden
                          'name': val['name'],            // nombre del producto
                          'sku': val['sku'],              // Codigo telotengo
                          'category': val['category'],    // Categoria del producto
                          'price': val['price'],          // precio unitario de cada producto
                          'quantity': val['quantity'],    // cantidad por cada producto
                        });

                  });

                  ga('ecommerce:send');

			        	}else
			        	{
				        	$('#estado').addClass('rechazado');
				        	$('#estado').html('Rechazada');
				        	var variable="Rechazada";
			        	}
                $('.existencia').hide();
						$('#tabla').append('<tr> <td> '+variable+' </td> <td>'+user+' </td> <td>'+fecha+' </td> </tr>');

			       	}
			    })
			}
		
		});

</script>
