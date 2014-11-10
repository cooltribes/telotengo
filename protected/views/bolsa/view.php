  <!-- CONTENIDO ON -->
    <div class="container-fluid" style="padding: 0 15px;">

<?php
$this->breadcrumbs=array(
	'Bolsa',
);
?> 
        <div class="row">
        	<?php if(Yii::app()->user->hasFlash('error')){?>
			    <div class="alert in alert-block fade alert-danger text_align_center">
			        <?php echo Yii::app()->user->getFlash('error'); ?>
			    </div>
			<?php } ?>
            <div class="col-md-8 col-md-push-2 " >
                <div class="page-header"><h1>Bolsa</h1></div>
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
									$subtotal += $inventario->precio*$uno->cantidad;
																		
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
									
									echo ' <tr>
		                                <td>'.$im.'</td>
		                                <td>
		                                    <div>'.$producto->nombre.' '.$marca->nombre.'</div>
		                                    <div>'.$caracteristicas.'</div>
		                                </td>
		                                <td>'.$inventario->precio.' Bs.</td>
		                                <td>'.$uno->cantidad.'</td>
		                                <td>
		                                    <!-- <div>
		                                        <a href="">Editar</a>
		                                    </div> -->
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
                }else
				{
					echo "No tienes productos en el carrito. ¿Por qué no ves si algo te gusta? </br> <a href=http://telotengo.com/'".Yii::app()->baseUrl."/tienda'>Ir a la Tienda</a>" ;
				}
                ?>
                </section>
                <section class="col-sm-4">
                    
                    <div class="well">
                        <h3>Resumen</h3>
                        <hr>
                        <div class="text_align_center">
                            <div class="padding_xsmall">
                                Subtotal: <span><?php echo $subtotal; ?> Bs.</span>
                            </div>
                            <div class="padding_xsmall">
                                Envio: <span>0,00 Bs.</span>
                            </div>
                            <div class="padding_xsmall">
                                IVA: <span>0,00 Bs.</span>
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
                            <small>Fecha estimada de entrega 01/02/2014 - 03/02/2014</small>
                        </div>
                        <div>
                            <small><a href="#">Ver Políticias de Envíos y Devoluciones</a></small>
                        </div>
                    </div>
                </section>
                
            </div>
        </div>
        <!-- COLUMNA PRINCIPAL DERECHA OFF // -->
        <?php include('sidebar_admin.php') ?>

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
