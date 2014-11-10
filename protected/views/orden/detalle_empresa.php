<div class="container-fluid" style="padding: 0 15px;">

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
		<div class="alert in alert-block fade alert-error text_align_center">
			<?php echo Yii::app()->user->getFlash('error'); ?>
		</div>
	<?php } ?>	
	
    <div class="container">
        <div class="row">
            <!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->
            <div class="col-md-10 col-md-offset-1 main-content" role="main">
                    <div class="page-header">
                        <h1>
                           Pedido #<?php echo $model->id; ?>
                        </h1>
                    </div>

                    <?php 
                    if($model->estado == 3) // dinero confirmado
                    {
                        ?>
                        <section>
                            <h3>Acciones:</h3>
                            
                            <div class="alert alert-block form-inline ">
                                <h4 class="alert-heading "> Enviar pedido:</h4>
                                <p>
                                <input name="" id="tracking" type="text" placeholder="Numero de Tracking">
                                <a onclick="enviarPedido(<?php echo $model->id; ?>)" class="btn" title="Enviar pedido">Enviar</a> </p>
                                Tipo de guía: 
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
                                
                        </section>
                        <?php
                        }
                    ?>

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
                                    
                                </tr>
                            </table>

                            <?php if(!is_null($tracking))
                            { 
                                ?>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
                                    <tr>
                                        <th scope="col">Fecha</th>
                                        <!--  <th scope="col">Tipo</th>-->
                                        <th scope="col">Estatus</th>
                                    </tr>
                                    <?php 
                                    foreach ($tracking as $track){
                                        echo "<tr>
                                            <td>".$track->fecha."</td><td>".$track->descripcion_estatus."</td>        
                                        </tr>";
                                    }
                                    ?>
                                </table>
                                <?php 
                            }
                            ?>
                        </div>      
                        <?php
                        // envío
                    }
                    ?>
                    
                    <section>
                        <h3>Resumen:</h3>
                        <div>
                            <p class="well well-sm"> Estado: <span>
                            <?php
		
								switch ($model->estado) {
							    case 1:
							        echo "En espera de pago"; 
							        break;
							    case 2:
							        echo "En espera de confirmación"; 
							        break;
							    case 3:
							        echo "Pago Confirmado";
							        break;
								case 4:
									echo "Orden Enviada";
									break;
								case 5:	
									echo "Orden Cancelada";
									break;
								case 6:
									echo "Pago Rechazado";
									break;
								case 7:
									echo "Pago Insuficiente";
									break;
								case 8: 
									echo "Entregado</td>";
									break;
								case 9:
									echo "Orden Devuelta";
									break;
								case 10:
									echo "Parcialmente Devuelto";
									break;	
								}
						
							?></span> </p>

                            <?php
                            if($model->estado == 9 || $model->estado == 10){ //hay alguna devolución, muestro el detalle
                                $total_devoluciones = 0;
                                $envio = 0;
                                $total = 0;
                                ?>
                                <div class="well well-sm">
                                    Productos devueltos:
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
                                <?php
                            }
                            ?>

                            <?php
                            // Mostrar reclamos y comentarios, si hay
                            $reclamos = Reclamo::model()->findAllByAttributes(array('orden_id'=>$model->id));
                            if($reclamos){
                                $total_devoluciones = 0;
                                $envio = 0;
                                $total = 0;
                                ?>
                                <div class="well well-sm">
                                    <div class="panel-heading">
                                        Reclamos:
                                        <?php
                                        foreach ($reclamos as $reclamo) {
                                            $comentarios = ReclamoComentarios::model()->findAllByAttributes(array('reclamo_id'=>$reclamo->id));
                                            ?>
                                            <div>
                                                <?php
                                                echo $reclamo->comentario.'</br>';
                                                echo 'Fecha: '.$reclamo->fecha.'</br>';
                                                echo CHtml::link('<span class="label label-info">Responder</span>', $this->createUrl('responderReclamo', array('id'=>$reclamo->id)));

                                                if($comentarios){
                                                    echo '<div>Comentarios: <ul>';
                                                    foreach ($comentarios as $comentario) {
                                                        echo '<li>'.$comentario->comentario.' | '.$comentario->fecha.'</li>';
                                                    }
                                                    echo '</ul></div>';
                                                }
                                                ?>
                                            </div>
                                            <hr>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div>
                        	<?php
                        	
                        		$template = '{summary}
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
                        	
                        	?>
                            <h4>Detalles del pedido</h4>
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
                                                                        
                                    if($principal->getUrl())
                                        $im = CHtml::image(str_replace(".","_thumb.",$principal->getUrl()), "Preview", array("height"=>"100px", "width" => "100px",'class'=>'img-responsive'));
                                    else 
                                        $im = '<img src="http://placehold.it/100x100" width="100%">';   
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
                        <div class="padding_xsmall">
                                Subtotal: <span><?php echo $model->total; ?> Bs.</span>
                            </div>
                            <div class="padding_xsmall">
                                Envio: <span><?php echo $model->envio; ?> Bs.</span>
                            </div>
                            <div class="padding_xsmall">
                                IVA: <span><?php echo $model->iva; ?> Bs.</span>
                            </div>
                            <div class="">
                                <h3>
                                    Total: <strong><?php echo $model->total+$model->envio+$model->iva; ?> Bs.</strong>
                                </h3>
                            </div>
                            <div>  
                                <p class="text-muted">Fecha estimada de entrega 01/02/2014 - 03/02/2014</p>

                            </div>        
                        </div>
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
