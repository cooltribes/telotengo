  <!-- CONTENIDO ON -->
<div class="container" style="padding: 0 15px;">

<?php
$this->breadcrumbs=array( 
	'Bolsa',
);
 
$subtotal = 0; 
?> 
        <div class="row-fluid"> 
            <div><h1>Bolsa</h1><hr class="no_margin_top"/></div>
            <div class="col-md-12 no_padding" >
               

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
                
                <section class="col-sm-8 main-content no_padding_left padding_right">
                    
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
                            <th class="text-center">Cantidad</th>
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
		                                	echo'<td class="text-right">Bs. '.$inventario->flashSalePrice().'</td>';
		                                }else{
		                                echo '	
		                                	<td class="text-right">Bs. '.$inventario->precio.'</td>';
		                                }

		                                ?>
		                                <td align="center">
		                                	<input type="number" min="0" max="<?php echo $inventario->cantidad; ?>" step="1" value="<?php echo $uno->cantidad; ?>"
		                                			name="cantidad" id="<?php echo $inventario->id; ?>" class="cant text-center">
		                                	<div>
		                                        <a style="cursor: pointer" onclick="update(<?php echo $inventario->id.",".$uno->bolsa->id; ?>)"><small>Actualizar</small></a>
		                                    </div>
		                                </td>
		                                <?php	

		                                echo '
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
                <section class="col-sm-4 no_padding_right">
                    <?php $iva = $subtotal * 0.12; ?>
                 
                        <div class="text_align_center well bg_white">
                            <div class="padding_xsmall">
                                Subtotal: <span>Bs. <?php echo $subtotal-$iva; ?></span>
                            </div>
                            <div class="padding_xsmall">
                                IVA: <span>Bs. <?php echo $iva; ?></span>
                            </div>
                            <div class="padding_small">
                                <h4>
                                    Total: <strong>Bs. <?php echo $subtotal; ?></strong>
                                </h4>
                            </div>
                            <div class="text_center">
                        <div>  
                              <small><p class="no_margin_bottom"><i class="icon-calendar"></i>
                             <?php echo 'Fecha estimada de entrega' ?>:</small>   
                             <?php echo date('d/m/Y', strtotime('+1 day'));?>  - <?php echo date('d/m/Y', strtotime('+1 week')); ?>
                          </p>
                        </div>
                        <div class="text-center">
                            <small><a href="#">Ver Políticias de Envíos y Devoluciones</a></small>
                        </div>
                    </div>
                            
                            <?php
                            echo CHtml::link('<span class="glyphicon glyphicon-shopping-cart"></span> Comprar', $this->createUrl('authenticate'), array('class'=>'btn btn-success btn-lg margin_top'));
                            ?>
                        </div>
                    
                    
                </section>
                
            </div>
        </div>
        <!-- COLUMNA PRINCIPAL DERECHA OFF // -->


<!-- CONTENIDO OFF -->

<script>
	
	$(".cant").keypress(function(){
		console.log("merwebo");
		var a = parseInt($(this).val());
		if(isNaN(a)){
			$(this).val('');
			event.preventDefault();
			$(this).val('0');
			
		}
	});

	function eliminar(id){
	
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
 
	function update(id,bolsa)
	{
		cantidad = $("#"+id).val();
		
	 	$.ajax({
	        type: "post",
	        url: "actualizar", // action de actualizar
	        data: { 'id':id, 'cantidad': cantidad, 'bolsa':bolsa}, 
	        success: function (data) {
				if(data=="ok"){
					window.location.reload()
				}
	       	}//success
	    })
	}
	
</script>
