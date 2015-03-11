<div class="container">
    <?php
    $this->breadcrumbs=array(
    	'Pedidos'=>array('admin'),
    	'Detalle',
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
    <!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->
     
            <h1>Pedido N° <?php echo $model->id; ?> <small class="pull-right"><?php echo $model->getStatus($model->estado); ?><?php echo ($model->estado== 3)?'<br><a class="smallRLink" id="envioLink" onclick="shippingDisplay()">Enviar Pedido</a>':''; ?></small></h1>
            <hr class="no_margin_top"/>
        <?php 
        if($model->estado == 3) // dinero confirmado
        {
        ?>

                                    
            <div id="envioForm" class="alert alert-block form-inline well hide">
          
                   <div class="row-fluid"> 
                        <div class="col-md-12">
                            Guía
                    <?php
                                
                    switch ($model->tipo_guia) {
                        case 0:
                            echo 'Zoom hasta 0,5 Kg.';
                            break;
                        case 1:
                            echo 'Zoom entre 0,5 y 5 Kg.';
                            break;
                        case 2:
                            echo 'DHL mayor a 5 Kg.';
                            break;
                        default:
                            break;
                    }
                    ?>
                        </div>    
                        <div class="col-md-11">
                            <input name="" id="tracking" type="text" placeholder="Numero de Tracking" class="form-control">
                        </div>
        
                            <a class="btn btn-info col-md-1" onclick="enviarPedido(<?php echo $model->id; ?>)" class="btn" title="Enviar pedido">Enviar</a> 
                       
                   </div>
                   
                    
            </div>

        <?php
        }
        ?>
        <section class="row-fluid">
                    
                     <?php $width=$model->balance>0?12:18; ?>
                         <table width="100%" align="right" style="margin-bottom: 30px;">
                               <thead>
                                   <tr align="right">
                                       <th><h3>Enviado a</h3></th>
                                       <th width=" <?php echo $width;?>%"><h3 class="text_align_right">Subtotal</h3></th>
                                       <th width=" <?php echo $width;?>%"><h3 class="text_align_right">Envio</h3></th>
                                       <th width=" <?php echo $width;?>%"><h3 class="text_align_right">IVA</h3></th>
                                      
                                   <?php if($model->balance>0): ?>
                                       <th width=" <?php echo $width;?>%"><h3 class="text_align_right">Balance</h3></th>
                                   <?php endif; ?>
                                       <th width=" <?php echo $width;?>%"><h3 class="text_align_right">Total</h3></th>
                                       
                                   </tr>
                               </thead>
                               <tbody>
                                    <tr align="right">
                                        <td align="left">
                                        <?php if(isset($model->direccionEnvio)){
                                            echo $model->direccionEnvio->nombre."<br/>";
                                            echo $model->direccionEnvio->direccion_1."<br/>";
                                            if(strlen($model->direccionEnvio->direccion_2)>3)echo $model->direccionEnvio->direccion_2."<br/>";
                                            echo $model->direccionEnvio->ciudad->nombre." - ".$model->direccionEnvio->provincia->nombre."<br/>";
                                            echo $model->direccionEnvio->telefono."<br/>";
                                        }?>                                        
                                       <span class="muted">
                                           Fecha estimada de entrega <?php echo date('d/m/Y', strtotime($model->fecha.'+1 day'));?> - <?php echo date('d/m/Y', strtotime($model->fecha.'+1 week')); ?>                                           
                                       </span> 
                                        </td>
                                        <td class="quantity"><strong><?php echo $model->total-$model->envio-$model->iva; ?> Bs</strong></td>
                                        <td class="quantity"><strong><?php echo $model->envio; ?> Bs</strong></td>
                                        <td class="quantity"><strong><?php echo $model->iva; ?> Bs</strong></td>
                                        <?php if($model->balance>0): ?>                           
                                        <td class="quantity"><strong><?php echo $model->balance; ?> Bs</strong></td>                               
                                        <?php endif; ?>
                                        <td class="quantity"><strong><?php echo $model->total; ?> Bs</strong></td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                    
            </section>        
                    
           <section>
               
               <?php
            if($model->estado==4||$model->estado==8||$model->estado==9||$model->estado==10){
        ?>
            <div class="well well-small margin_top_small well_personaling_small">
                <h3 class="braker_bottom "> Transporte </h3>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
                    <tr>
                        <th scope="col">Fecha</th>
                        <!--  <th scope="col">Tipo</th>-->
                        <th scope="col">Transportista</th>
                        <th scope="col">Costo de envio</th>
                        <th scope="col">Numero de seguimiento</th>
                        <th scope="col"></th>
                    </tr>
                    <tr>
                        <td><?php
                            echo date("d/m/Y",strtotime(Estado::model()->getDate($model->id, $model->estado)));?>
                        </td>
                        <!-- <td>Delivery</td>-->
                        <td> 
                            <?php

                            switch ($model->tipo_guia) {
                                case 0:
                                    echo 'Zoom';
                                    break;
                                case 1:
                                    echo 'Zoom';
                                    break;
                                case 2:
                                    echo 'DHL';
                                    break;
                                default:
                                    break;
                            }
                            ?>
                        </td>
                        <td><?php echo number_format($model->envio, 2, ',', '.'); ?> Bs.</td>
                        <td><?php echo $model->tracking; ?></td>
                        <td><a href="#" title="Editar"><i class="icon-edit"></i></a></td>
                    </tr>
                            </table>

       </div>      
                        <?php
                        // envío
                    }
                    ?>
               
               
               
           </section>         
                    
                    
                 
                    
                    

                     
                            

                            <?php
                            if($model->estado == 9 || $model->estado == 10){ //hay alguna devolución, muestro el detalle
                                $total_devoluciones = 0;
                                $envio = 0;
                                $total = 0;
                                ?>
                                  <section> 
                                
                                <div class="well well-sm">
                                    <h3>Productos devueltos:</h3>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Nombre del producto</th>
                                                <th>Precio</th>
                                                <th>Cantidad</th>
                                                <th>Motivo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <?php
                                            foreach ($model->ordenHasInventarios as $orden_inventario) {
                                                $devolucion = Devolucion::model()->findByAttributes(array('orden_has_inventario_id'=>$orden_inventario->id));
                                                if($devolucion){
                                                    $caracteristicas_nosql = Caracteristica::model()->findAllByAttributes(array('inventario_id'=>$orden_inventario->inventario->id));                                                     
                                                    $caracteristicas = '';
                                                    $cont = 1;
                                                    foreach ($caracteristicas_nosql as $c_nosql) {
                                                        if($cont == sizeof($caracteristicas_nosql)){
                                                            $caracteristicas .= $c_nosql->valor;
                                                        }else{
                                                            $caracteristicas .= $c_nosql->valor.', ';
                                                        }
                                                        $cont++;
                                                    }

                                                   
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <div><?php echo $orden_inventario->inventario->producto->nombre; ?></div>
                                                            <div><?php echo $caracteristicas; ?></div>
                                                        </td>
                                                        <td><?php echo Yii::app()->numberFormatter->formatDecimal($orden_inventario->precio); ?> Bs.</td>
                                                        <td><?php echo $orden_inventario->cantidad; ?></td>
                                                        <td><?php echo $devolucion->motivo; ?></td>
                                                    </tr>
                                                    <?php
                                                    $total_devoluciones += $devolucion->monto_devuelto;
                                                    $envio += $devolucion->monto_envio;
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <table class="table margin_top_large">
                                    <tr>
                                        <th colspan="7"><div class=""><strong>Resumen</strong></div></th>
                                    </tr>       
                                    <tr>
                                        <td colspan="6"><div class=""><strong>Monto a devolver Bs.:</strong></div></td>
                                        <td class=""><?php echo Yii::app()->numberFormatter->formatDecimal($total_devoluciones); ?> Bs.</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6"><div class=""><strong>Monto por envío a devolver Bs.:</strong></div></td>
                                        <td  class=""><?php echo Yii::app()->numberFormatter->formatDecimal($envio); ?> Bs.</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6"><div class=""><strong>Total Bs.:</strong></div></td>
                                        <td  class=""><?php echo Yii::app()->numberFormatter->formatDecimal($total_devoluciones + $envio); ?> Bs.</td>
                                    </tr>        
                                    </table>
                                </div>
                                </section>
                                <?php
                            }
                            ?>

            </section>
         
                            <?php
                            // Mostrar reclamos y comentarios, si hay
                            $reclamos = Reclamo::model()->findAllByAttributes(array('orden_id'=>$model->id));
                            if($reclamos){
                                $total_devoluciones = 0;
                                $envio = 0;
                                $total = 0;
                                ?>
                                <section class="margin_bottom_large">
                                <h3>Reclamos</h3><hr class="no_margin_top"/>
                                <div class="well margin_bottom">
                                    
                                        
                                        <?php
                                        foreach ($reclamos as $reclamo) {
                                            $comentarios = ReclamoComentarios::model()->findAllByAttributes(array('reclamo_id'=>$reclamo->id));
                                            ?>
                                            <div>
                                                <?php
                                                echo "<div class='well bg_white'><strong>".$reclamo->comentario."</strong>";
                                                  echo " - <small>Enviado el ".date('d/m/Y',strtotime($reclamo->fecha))."</small>";
                                                echo CHtml::link('<span class="label label-info pull-right">Responder</span>', $this->createUrl('responderReclamo', array('id'=>$reclamo->id)))."<hr/>";

                                                if($comentarios){
                                                    echo '<div class="row padding_left_large padding_right_large text_align_right">';
                                                    foreach ($comentarios as $comentario) {
                                                        echo $comentario->comentario;
                                                        echo " - <small>Enviado el ".date('d/m/Y',strtotime($comentario->fecha))."</small></br>";
                                                    }
                                                    echo '</div>';
                                                }
                                                echo "</div>"
                                                ?>
                                            </div>
                                        
                                            <?php
                                        }
                                        ?>
                                   
                                </div>
                                </section>
                                <?php
                            }
                            ?>
                                      
                                            
                        <section>
                            
                            
                        	<?php
                        	if($dataProvider->totalItemCount>0)
                        	{	$template = '{summary}
							    <h2>Pagos</h2><table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
							        <tr>
							            <th scope="col">Pago #</th>
							            <th scope="col">Nombre</th>
							            <th scope="col">Cedula</th>
							            <th scope="col">Monto</th>
							            <th scope="col">Fecha</th>
							            <th scope="col">Estado</th>
							            <th scope="col">Acción</th>
							        </tr>
							    {items}
							    </table>
							    {pager} 
								';
						
								$this->widget('zii.widgets.CListView', array(
								    'id'=>'list-auth-pagos',
								    'dataProvider'=>$dataProvider,
								    'itemView'=>'_datos_pagos_admin',
								    'template'=>$template,
								    'enableSorting'=>'true',
								    'afterAjaxUpdate'=>" function(id, data) {
													   
														} ",
									'pager'=>array(
										'header'=>'',
										'htmlOptions'=>array(
										'class'=>'pagination pagination-right',
									)
									),					
								));  
								}
                        	?>
                        </section>
                        <section>
                            <h3>Productos</h3><hr class="no_margin_top"/>
                        <table class="table">
                            <thead>
                              <tr>
                                <th></th>
                                <th>Nombre del producto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($model->ordenHasInventarios as $orden_inventario) {
                                    $caracteristicas_nosql = Caracteristica::model()->findAllByAttributes(array('inventario_id'=>$orden_inventario->inventario->id));                                                     
                                    $caracteristicas = '';
                                    $cont = 1;
                                    foreach ($caracteristicas_nosql as $c_nosql) {
                                        if($cont == sizeof($caracteristicas_nosql)){
                                            $caracteristicas .= $c_nosql->valor;
                                        }else{
                                            $caracteristicas .= $c_nosql->valor.', ';
                                        }
                                        $cont++;
                                    }

                                    $principal = Imagenes::model()->findByAttributes(array('orden'=>1,'producto_id'=>$orden_inventario->inventario->producto_id));
                                                 
                                    if(!is_null($principal))
                                        $im = CHtml::image(str_replace(".","_thumb.",$principal->getUrl()), "Preview", array("height"=>"100px", "width" => "100px",'class'=>'img-responsive'));
                                    else 
                                        $im = '<img src="http://placehold.it/25x25" width="100%">';   
                                    ?>
                                    <tr>
                                        <td><?php echo $im; ?></td>
                                        <td>
                                            <div><?php echo $orden_inventario->inventario->producto->nombre; ?></div>
                                            <div><?php echo $caracteristicas; ?></div>
                                        </td>
                                        <td><?php echo $orden_inventario->precio; ?> Bs.</td>
                                        <td><?php echo $orden_inventario->cantidad; ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        </section>
                                         
                       
                    

            </div>
            <!-- COLUMNA PRINCIPAL DERECHA OFF // -->
        </div>
    </div>
</div>

<script>
    function enviarPedido(id){
        
        var guia = $('#tracking').attr('value');
        
        $.ajax({
            type: "post", 
            url: "../enviar", // action 
            data: { 'guia':guia, 'id':id}, 
            success: function (data) {
                if(data=="ok")
                {
                    window.location.reload();
                }
            }//success
           })   
          
       //  alert(guia); 
        
    }
</script>
 <script>
        function shippingDisplay(){
            if($('#envioForm').hasClass('hide')){
                $('#envioForm').removeClass('hide');
                $('#envioLink').html('Ocultar');
            }else{
                $('#envioForm').addClass('hide');
                $('#envioLink').html('Registrar Pago');
            }
        }
    </script>
