  <!-- CONTENIDO ON -->
<div class="container-fluid" style="padding: 0 15px;">

<?php
$this->breadcrumbs=array( 
	'Bolsa',
);

$subtotal = 0; 
?> 
        <div class="row">
            <div class="col-md-8 col-md-push-2 " >
                <div><h1>Bolsa</h1></div>

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
                
                <section class="col-sm-8 main-content">
                <?php
                	if(isset($model))
					{
							
					$bolsa_has = BolsaHasInventario::model()->findAllByAttributes(array('bolsa_id'=>$model->id));	
					$subtotal = 0; 
                        
					if(isset($bolsa_has) && count($bolsa_has)>0 )
					{	
						
                ?>
                    <table class="table">
                        <thead>
                          <tr>
                            <th></th>
                            <th>Nombre del producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                        
							foreach($bolsa_has as $uno)
							{
								$inventario = Inventario::model()->findByPk($uno->inventario_id);	
								
								if($inventario->estado ==1){
								
									$principal = Imagenes::model()->findByAttributes(array('orden'=>1,'producto_id'=>$inventario->producto_id));
	    							$producto = Producto::model()->findByPk($inventario->producto_id);
									
									if($inventario->hasFlashSale()){
										$subtotal += ($inventario->flashSalePrice())*($uno->cantidad);
									}else{
										$subtotal += ($inventario->precio)*($uno->cantidad);
									}	

	    							if($principal->getUrl())
	    								$im = CHtml::image(str_replace(".","_thumb.",$principal->getUrl()), "Preview", array("height"=>"100px", "width" => "100px",'class'=>'img-responsive'));
	    							else 
	    								$im = '<img src="http://placehold.it/100x100" width="100%">';  	
									
									$marca = Marca::model()->findByPk($producto->marca_id);
	    							//echo $marca->nombre;	

	    							$caracteristicas_nosql = Caracteristica::model()->findAllByAttributes(array('inventario_id'=>$inventario->id));					    								
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
									// <div>'.$caracteristicas.'</div>';
									echo '
										<tr>
		                                <td>'.$im.'</td>
		                                <td>
		                                    <div>'.$producto->nombre.' '.$marca->nombre.'</div>';
		                                    
		                                    if($inventario->hasFlashSale())
		                                    	echo '<div>Aplica Oferta</div>';

		                                    echo '
		                                </td>';
		                                if($inventario->hasFlashSale()){
		                                	echo'<td>'.$inventario->flashSalePrice().' Bs.</td>';
		                                }else{
		                                echo '	
		                                	<td>'.$inventario->precio.' Bs.</td>';
		                                }

		                                echo '
		                                <td>'.$uno->cantidad.'</td>
		                                <td>
		                                	<div>
		                                        <a style="cursor: pointer" onclick="eliminar('.$inventario->id.')" >Eliminar</a>
		                                    </div>
		                           		</td>
								    </tr>';
								} // estado del inventario
									
							}
						}
						else
						{
							echo "No tienes productos en el carrito. ¿Por qué no ves si algo te gusta? </br> <a href='http://telotengo.com".Yii::app()->baseUrl."/tienda'>Ir a la Tienda</a>" ;	
						}
                        ?>                       	          
                       </tbody> 
                    </table>
                <?php
                }else{
					echo "No tienes productos en el carrito. ¿Por qué no ves si algo te gusta? </br> <a href=http://telotengo.com/'".Yii::app()->baseUrl."/tienda'>Ir a la Tienda</a>" ;
				}
                ?>
                </section>
                <section class="col-sm-4">
                    <?php $iva = $subtotal * 0.12; ?>
                    <div class="well">
                        <h3>Resumen</h3>
                        <hr>
                        <div class="text_align_center">
                            <div class="padding_xsmall">
                                Subtotal: <span><?php echo $subtotal-$iva; ?> Bs.</span>
                            </div>
                            <div class="padding_xsmall">
                                IVA: <span><?php echo $iva; ?> Bs.</span>
                            </div>
                            <div class="padding_small">
                                <h4>
                                    Total: <strong><?php echo $subtotal; ?> Bs.</strong>
                                </h4>
                            </div>
                            <?php
                            echo CHtml::link('<span class="glyphicon glyphicon-shopping-cart"></span> Comprar', $this->createUrl('authenticate'), array('class'=>'btn btn-success btn-lg'));
                            ?>
                        </div>
                    </div>
                    <div class="text_,align_center">
                        <div>  
                            <p><i class="icon-calendar"></i><small>
                    			<?php echo 'Fecha estimada de entrega' ?>:
                    			<?php echo date('d/m/Y', strtotime('+1 day'));?>  - <?php echo date('d/m/Y', strtotime('+1 week')); ?>
                    		</small></p>
                        </div>
                        <div>
                            <small><a href="#">Ver Políticias de Envíos y Devoluciones</a></small>
                        </div>
                    </div>
                </section>
                
            </div>
        </div>
        <!-- COLUMNA PRINCIPAL DERECHA OFF // -->

    </div>
<!-- CONTENIDO OFF -->

<script>

	function eliminar(id)
	{
	
	// llamada ajax para el controlador de bolsa	   
     	$.ajax({
	        type: "post",
	        url: "eliminar", // action de actualizar
	        data: { 'num':id }, 
	        success: function (data) {
				
				if(data=="ok")
				{
					window.location.reload()
				}
					
	       	}//success
	       })

	}
	
</script>
