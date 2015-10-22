
        <div class="breadcrumbs margin_top">
                <a><span>Inicio</span></a>/&nbsp;
                <a><span>Sub Categoria</span></a>/&nbsp;
                <a><span>Sub Categoria 1.1</span></a>/&nbsp;
                <a><span class="current">Producto</span></a>
        </div>
        

        
       
        

            
            
            <div class="col-md-9 main no_horizontal_padding">
                <div class="row-fluid">
                
                    <div class="col-md-4 no_left_padding">
                       <img src="<?php echo Yii::app()->getBaseUrl(true).$imagenPrincipal->url;?>" width="100%" />
                       <div class="miniSlide">
                           <div class="control"><span><</span></div>
                           <?php 
                           foreach($imagen as $image)
						   {
							   	if($image->orden!=1)
								{
							   	?>
							   <div class="item"><img src="<?php echo Yii::app()->getBaseUrl(true).$image->url;?>" width="80" height="80" /></div>
							   <?php
								}	
						   }
						   ?>
                           <div class="control"><span>></span></div>
                       </div>
                    </div>
                    
                    
                    
                    
                    
                    
                    <div class="col-md-8 mainDetail">
                        <h1 class="no_margin_top">
                          <?php echo $model->nombre;?> 
                        </h1>
                        <div class="separator"></div>
                        <table width="100%" class="priceTable">
                            <tr>
                                <td class="title" width="25%">Precio en tienda</td>
                                <td width="33%" class="throughlined"><?php echo $inventario->precio;?> Bs</td>
                                <td class="title" width="22%">Estatus</td>
                                <?php
                                if($inventario->cantidad>0) 
                                {?>
                                	<td class="success" width="20%"> En Stock</td>  
                                <?php	
                                }else
								{?>
									<td class="error" width="20%"> Agotado</td>  
								<?php
								}	
                                ?>
                                	 
                                                   
                            </tr>
                            
                            <tr>
                                <td class="title">Precio al mayor</td>
                                
                                <td ><span class="highlighted"><?php echo $inventario->precio;?></span> Bs por und.</td> <!-- NO hay precio con descuento-->
                                <td class="title">Disponibilidad</td>
                                <td > <?php echo $inventario->cantidad;?></td>                        
                            </tr>
                            
                            <tr>
                                <td  class="title">Días de Crédito</td>
                                <td  >7</td>
                                <td  class="title" >Empaque</td>
                                <td  >10 und. / 1 caja</td>                        
                            </tr>
                            
                            <tr>
                                <td class="title">Descuento Adicional</td>
                                <td >5% desde 100 und.</td>
                                <td class="title">Orden mínima</td>
                                <td >50 und. / 5 cajas</td>                        
                            </tr>
                            
                            
                        </table>
                        
                     <?php  /* <div class="shippingInfo margin_top">
                            <div class="row-fluid">
                                <div class="col-md-3 text-right">
                                    <span class="title">Envío:</span>
                                </div>
                                <div class="col-md-9">
                                	<?php 
                                	if($inventario->metodoEnvio!=1)
									{?>
										<span class="price">Acordado con el cliente</span>
									<?php
									}
									else
									{?>
										<span class="price">A traves del servicio de TELOTENGO</span>
                                    	<a href="#"  data-toggle="modal" data-target="#shippingModal">(en la región occidente) <span class="caret"></span></a>
                                    	<span class="estimated">Fecha estimada de entrega: 3-5 días</span>
									<?php	
									}
                                	?>

                                    
                                </div> 
                            </div>
                        </div>*/
                        ?>
                        
                    </div>
                    <div class="col-md-8  col-md-offset-4 specs margin_top">
                        <h2>CARACTERÍSTICAS DEL PRODUCTO</h2>
                        <ul>
                        	<?php  
                        	$data = explode('*-*',$model->caracteristicas);
							foreach($data as $dato)
							{
								if($dato!="")
								{
								?>
								<li><span class="glyphicon glyphicon-ok"></span><?php echo $dato?></li>
							<?php
								}
							}                      	
                        	?>
                        </ul>
                    </div>
                    <div class="col-md-12 no_padding_left slider">
                        <h1>PRODUCTOS SIMILIARES</h1>
                           <?php $this->renderPartial('carousel_productos',array('data'=>$similares,'carousel'=>'proveedor', 'similares'=>1)); ?>  
                     
                    </div>
             
             
             </div>
            </div>
             </div>
            <div class="col-md-3 no_horizontal_padding ">
                <div class="orderBox">
                    <table width="80%" style="width:80%; max-width: 80%;">
                        <tr>
                            <td width="50%" class="name">Cantidad:</td>
                            <td width="50%"><input id="cantidad"type="number" value="1" class="quantity" /></td>
                        </tr>
                        <tr>
                            <td class="name">Precio:</td>
                            <input type="hidden" id="precioUnitario" value="<?php echo  $inventario->precio;?>">
                            <input type="hidden" id="maximo" value="<?php echo  $inventario->cantidad;?>">
                            <input type="hidden" id="inventario_id" value="<?php echo  $inventario->id;?>">
                            <td class="highlighted" id="unitario"><?php echo $inventario->precio?></td>
                        </tr>
                        <tr>
                            <td class="name">Envio:</td>
                             <?php 
                                	if($inventario->metodoEnvio==1)
									{?>
										<td class="option emphasis">Acordado con el cliente</td>
									<?php
									}
									else
									{?>
										<td class="option emphasis">A traves del servicio de TELOTENGO</td>
									<?php	
									}
                                	?>
                        </tr>
                        <tr>
                            <td class="call" colspan="2">
                                <?php echo CHtml::submitButton('ORDENAR', array('id'=>'ordenar','class'=>'btn-orange margin_bottom_small btn btn-danger btn-large orange_border form-control')); ?>
                            </td>
                        </tr>
                    </table>
                    <div class="plainSeparator"></div>
                    <div class="sellerInfo">
                        <span class="title">Vendido y enviado por:</span>
                        <span class="name"><?php echo $empresa->razon_social;?></span>
                        <span class="location"><?php echo $almacen->ciudad->nombre;?></span>
                        <!--<span>610 Transacciones</span>
                        <span>98% Feedbacks positivos</span> -->
                    </div>
                </div>
                <?php 
                if(!empty($otros))
                {
                	?>
                  <div class="moreOptions margin_top">
                    <div class="item">
                       <span class="title">Mas opciones de compra</span>    
                       <?php foreach($otros as $data)
                       {?>
                       	  <div class="sellerInfo">
                            <span class="name"><?php echo $data->almacen->empresas->razon_social;?></span>
                            <span class="location"><?php echo $data->almacen->ciudad->nombre; ?></span>
                            <span><b><?php echo $data->precio;?> Bs.F</b> <?php if($inventario->metodoEnvio==1) echo "Acordado con el cliente"; else echo "A traves del servicio de TELOTENGO"; ?></span>
                            <button class="btn btn-small btn-unfilled ordenarIndividual" id="<?php echo $data->id;?>"> ORDENAR</button>
                        </div>
                         <div class="plainSeparator"></div> 
                       <?php
                       }
                       ?>                
   
                    </div>
                    
                   
                
                </div> 
                <?php	
                }
                ?>
    
                           
            </div>
            
            <div class="col-md-12 no_horizontal_padding margin_top">
                <div class="moreDetails">
                    
                                       
                    <ul id="myTabs" class="nav nav-tabs" role="tablist">
                      <li role="presentation" class="active"><a href="#moreDetails" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">DETALLES DEL PRODUCTO</a></li>
                      <li role="presentation" class=""><a href="#specifications" role="tab" id="specifications-tab" data-toggle="tab" aria-controls="specifications" aria-expanded="false">CARACTERÍSTICAS GENERALES</a></li>
                      <li role="presentation" class=""><a href="#recommendations" role="tab" id="recommendations-tab" data-toggle="tab" aria-controls="recommendations" aria-expanded="false">RECOMENDACIONES DEL PRODUCTO</a></li>
                      
                    </ul>
                    <div id="myTabContent" class="tab-content">
                      <div role="tabpanel" class="tab-pane fade active in" id="moreDetails" aria-labelledby="home-tab">
                        <?php $this->renderPartial('more_details', array('busqueda'=>$busqueda)); ?>
                      </div>
                      <div role="tabpanel" class="tab-pane fade" id="specifications" aria-labelledby="specifications-tab">
                       <?php $this->renderPartial('more_details', array('busqueda'=>$busqueda)); ?>
                      </div>
                        
                      <div role="tabpanel" class="tab-pane fade" id="recommendations" aria-labelledby="recommendations-tab">
                        <?php $this->renderPartial('more_details', array('busqueda'=>$busqueda)); ?>
                      </div>
                      
                    </div>
                
                </div>  
                              
            </div>
            
           <?php $this->renderPartial('preguntas_respuestas', array('model'=>$model, 'empresa_id'=>$empresa->id)); ?>
           
           
           
           <script>
           	$(document).ready(function() {
           
	           	$('#cantidad').change(function() {
	           	var cantidad=$('#cantidad').val();
	           	cantidad=parseInt(cantidad);
	           	var maximo=$('#maximo').val();
	           	maximo=parseInt(maximo);
	           	var unitario=$('#precioUnitario').val();
	           	if(cantidad<=0)
	           	{
	           		$('#cantidad').val('1');
	           		$('#unitario').html(unitario);
	           		//alert('epaa');
	           	}
	           	else
	           	{
	           		if(cantidad>=maximo)
	           		{
	           			alert("El maximo de unidades es "+maximo);
	           			$('#cantidad').val(maximo);
	           			$('#unitario').html(maximo*unitario);
	           			
	           		}
	           		else
	           		{
	           			$('#unitario').html(cantidad*unitario);
	           		}

	           	}
	           	
	           	});
	           	
	           	$('#ordenar').click(function() {
	           		var inventario=$('#inventario_id').val();
	           		var cantidad=$('#cantidad').val();
	           		cantidad=parseInt(cantidad);
	           		var unitario=$('#precioUnitario').val();
	           		var maximo=$('#maximo').val();
	           		maximo=parseInt(maximo);
	           		
	           		$.ajax({
			         url: "<?php echo Yii::app()->createUrl('Bolsa/agregarCarrito') ?>",
		             type: 'POST',
			         data:{
		                    cantidad:cantidad, unitario:unitario, inventario:inventario, maximo:maximo
		                   },
			        success: function (data) {
			        	
						window.location.href = '<?php echo Yii::app()->createUrl('site/carrito') ?>';
			       	}
			       })
	           		
	           		
	           	});
	           	
	           	$('.ordenarIndividual').click(function() {
	           		var id=$(this).attr('id');
	           		$.ajax({
			         url: "<?php echo Yii::app()->createUrl('Bolsa/carritoIndividual') ?>",
		             type: 'POST',
			         data:{
		                    id:id
		                   },
			        success: function (data) {
			        	
						window.location.href = '<?php echo Yii::app()->createUrl('site/carrito') ?>';
			       	}
			       })
	           	});
           	
           	});
           	
           </script>

<div class="modal fade" id="shippingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <?php $this->renderPartial('shipping_modal'); ?>
</div>

            
