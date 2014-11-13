<div class="container-fluid" style="padding: 0 15px;">

<?php
$this->breadcrumbs=array(
	'Pedidos'=>array('listado'),
	'Detalle',
);
?>	
    <div class="container">
        <div class="row">
            <!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->
            <div class="col-md-10 col-md-offset-1 main-content" role="main">
                    <div class="page-header">
                        <h1>
                           Pedido #<?php echo $model->id; ?>
                        </h1> 
                    </div>   
                    
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
                    
                    <section>
                        <h3>Resumen:</h3>
                        <div>
                            <p class="well well-sm"> Estado: <span>
                        
                            <?php
							$model->getStatus($model->estado); Yii::app()->end();/*
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
							}*/

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
                                    		?>
                                    		<div>
                                    			<?php
                                    			echo $reclamo->comentario.'</br>';
                                    			echo 'Fecha: '.$reclamo->fecha;
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
                            
		                    
								
							if($model->estado== 1|| $model->estado==7)
							{
							
							$detalle = new DetalleOrden;
								
							echo '<div class="well">
								<div class="row padding_left_medium">
									<div class="col-md-6 1">
									Registrar Pago '
									;
	
							$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
								'id'=>'pago-form',
								'enableAjaxValidation'=>false,
								'enableClientValidation'=>true,
								'type'=>'horizontal',
								'clientOptions'=>array(
									'validateOnSubmit'=>true, 
								),
								'htmlOptions' => array(
							        'enctype' => 'multipart/form-data',
							    ),
							));
							
							echo $form->errorSummary($model);
		
							echo '<div class="form-group">';
							echo $form->textFieldRow($detalle,'nombre',array('class'=>'form-control','maxlength'=>45));
							echo $form->error($detalle,'nombre');
							echo '</div>';
							
							echo '<div class="form-group">';
							echo $form->textFieldRow($detalle,'cedula',array('class'=>'form-control','maxlength'=>45));
							echo $form->error($detalle,'cedula');
							echo '</div>';
							
							echo '<div class="form-group">';
							echo $form->textFieldRow($detalle,'monto',array('class'=>'form-control','maxlength'=>45));
							echo $form->error($detalle,'monto');
							echo '</div>';
							
							echo '<div class="form-group">';
						    	echo $form->labelEx($model,'fecha');
									$this->widget('application.extensions.timepicker.timepicker', array(
										'model'=>$detalle,
										'name'=>'fecha',
									));
							echo $form->error($detalle,'fecha'); 
						    echo '</div>';
							
							echo $form->hiddenField($detalle,'orden_id',array('type'=>"hidden",'value'=>$model->id));
	
							echo '<div class="form-actions">';
								$this->widget('bootstrap.widgets.TbButton', array(
									'buttonType'=>'submit',
									'type'=>'primary',
									'label'=>'Enviar',
								));
							echo '</div>';
	
							$this->endWidget();
							
							echo '</div></div></div>';
							}	
								
							
							?></span> </p>
                            
                            <?php
                            
                            if($total>0)
							{
								
								$template = '{summary}
							    <h2>Pagos</h2><table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
							        <tr>
							            <th scope="col">Pago #</th>
							            <th scope="col">Nombre</th>
							            <th scope="col">Cedula</th>
							            <th scope="col">Monto</th>
							            <th scope="col">Fecha</th>
							            <th scope="col">Estado</th>
							        </tr>
							    {items}
							    </table>
							    {pager} 
								';
						
								$this->widget('zii.widgets.CListView', array(
								    'id'=>'list-auth-pagos',
								    'dataProvider'=>$dataProvider,
								    'itemView'=>'_datos_pagos',
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
                        </div>                        
                        <div>
                            <h4>Detalles del pedido</h4>
                        <table class="table">
                            <thead>
                              <tr>
                                <th></th>
                                <th>Nombre del producto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Acciones</th>
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
                                            <div>
                                            	Vendedor: <?php echo $orden_inventario->inventario->almacen->empresas->razon_social; ?>
                                            	<?php
	                                            if($model->estado==5||$model->estado==8||$model->estado==9||$model->estado==10){
	                                            	$calificacion = CalificacionEmpresa::model()->findByAttributes(array('orden_id'=>$orden_inventario->orden->id, 'user_id'=>Yii::app()->user->id));
	                                            	if($calificacion){
	                                            		echo '<small>(Tu calificación: '.$calificacion->puntuacion.')</small>';
	                                            	}else{
	                                            		//echo '   '.CHtml::link('Calificar', $this->createUrl('calificarVendedor', array('id'=>$orden_inventario->id)), array('class'=>'btn btn-success btn-xs'));
	                                            	}
	                                            }
	                                            ?>
                                            </div>
                                        </td>
                                        <td><?php echo $orden_inventario->precio; ?> Bs.</td>
                                        <td><?php echo $orden_inventario->cantidad; ?></td>
                                        <td>
                                        	<div class="dropdown">
												<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="#">
													<i class="icon-cog"></i> <b class="caret"></b>
												</a> 

												<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
													<?php
		                                            if($model->estado==5||$model->estado==8||$model->estado==9||$model->estado==10){
		                                            	$calificacion = CalificacionEmpresa::model()->findByAttributes(array('orden_id'=>$orden_inventario->orden->id, 'user_id'=>Yii::app()->user->id));
		                                            	if(!$calificacion){
		                                            		echo '<li>'.CHtml::link('<i class="glyphicon glyphicon-star"></i> Calificar vendedor', $this->createUrl('calificarVendedor', array('id'=>$orden_inventario->id))).'</li>';
		                                            	}
		                                            }
		                                            //if($model->estado==5||$model->estado==8||$model->estado==9||$model->estado==10){
		                                            	$reclamo = Reclamo::model()->findByAttributes(array('orden_id'=>$orden_inventario->orden->id, 'empresa_id'=>$orden_inventario->inventario->almacen->empresas_id));
		                                            	if(!$reclamo){
		                                            		echo '<li>'.CHtml::link('<i class="glyphicon glyphicon-exclamation-sign"></i> Hacer un reclamo', $this->createUrl('reclamo', array('id'=>$orden_inventario->id))).'</li>';
		                                            	}
		                                            //}
		                                            ?>
												
												</ul>
											</div>
                                        </td>
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
