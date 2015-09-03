<style>
    

</style>

        <div class="breadcrumbs margin_top">
                <a><span>Inicio</span></a>/&nbsp;
                <a><span>Sub Categoria</span></a>/&nbsp;
                <a><span>Sub Categoria 1.1</span></a>/&nbsp;
                <a><span class="current">Producto</span></a>
        </div>
        
 
        
        
        

            
            
            <div class="col-md-9 main no_left_padding">
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
                        
                        <div class="shippingInfo margin_top">
                            <div class="row-fluid">
                                <div class="col-md-3 text-right">
                                    <span class="title">Envío:</span>
                                </div>
                                <div class="col-md-9">
                                	<?php 
                                	if($inventario->metodoEnvio==1)
									{?>
										<span class="price">Acordado con el cliente</span>
									<?php
									}
									else
									{?>
										<span class="price">A traves del servicio de TELOTENGO</span>
                                    	<a href="#">(en la región occidente) <span class="caret"></span></a>
                                    	<span class="estimated">Fecha estimada de entrega: 3-5 días</span>
									<?php	
									}
                                	?>

                                    
                                </div> 
                            </div>
                        </div>
                        
                        
                    </div>
                    <div class="col-md-8  col-md-offset-4 specs margin_top">
                        <h2>CARACTERÍSTICAS DEL PRODUCTO</h2>
                        <ul>
                        	<?php  
                        	$data = explode('*-*',$model->caracteristicas);
							foreach($data as $dato)
							{?>
								<li><span class="glyphicon glyphicon-ok"></span><?php echo $dato?></li>
							<?php
							}                      	
                        	?>
                        </ul>
                    </div>
                    <div class="col-md-12 no_padding_left slider">
                        <h1>OTROS PRODUCTOS DE ESTE PROVEEDOR</h1>
                           <?php $this->renderPartial('carousel_productos',array('data'=>NULL,'carousel'=>'proveedor')); ?>  
                     
                    </div>
             
             
             </div>
            </div>
            <div class="col-md-3 no_right_padding ">
                <div class="orderBox">
                    <table width="100%">
                        <tr>
                            <td width="50%" class="name">Cantidad:</td>
                            <td width="50%"><input type="number" class="quantity" /></td>
                        </tr>
                        <tr>
                            <td class="name">Precio:</td>
                            <td class="highlighted">150,000 Bs</td>
                        </tr>
                        <tr>
                            <td class="name">Envio:</td>
                            <td class="option emphasis">Gratis</td>
                        </tr>
                        <tr>
                            <td class="call" colspan="2">
                                <?php echo CHtml::submitButton('ORDENAR', array('class'=>'btn-orange margin_bottom_small btn btn-danger btn-large orange_border form-control')); ?>
                            </td>
                        </tr>
                    </table>
                    <div class="plainSeparator"></div>
                    <div class="sellerInfo">
                        <span class="title">Vendido y enviado por:</span>
                        <span class="name">Sigma System C.A.</span>
                        <span class="location">San Cristóbal (Táchira)</span>
                        <span>610 Transacciones</span>
                        <span>98% Feedbacks positivos</span>
                    </div>
                </div>
                <div class="moreOptions margin_top">
                    <div class="item">
                       <span class="title">Mas opciones de compra</span>                    
                        <div class="sellerInfo">
                            <span class="name">Compumall</span>
                            <span class="location">San Cristóbal (Táchira)</span>
                            <span><b>320.100 Bs.</b> + 1600 Bs. de Envío</span>
                            <button class="btn btn-small btn-unfilled"> ORDENAR</button>
                        </div>
                        
                    </div>
                    <div class="plainSeparator"></div>
                    <div class="item">              
                        <div class="sellerInfo">
                            <span class="name">Compumall</span>
                            <span class="location">San Cristóbal (Táchira)</span>
                            <span><b>320.100 Bs.</b> + 1600 Bs. de Envío</span>
                            <button class="btn btn-small btn-unfilled"> ORDENAR</button>
                        </div>
                        
                    </div>
                    <div class="plainSeparator"></div>
                    <div class="item">           
                        <div class="sellerInfo">
                            <span class="name">Compumall</span>
                            <span class="location">San Cristóbal (Táchira)</span>
                            <span><b>320.100 Bs.</b> + 1600 Bs. de Envío</span>
                            <button class="btn btn-small btn-unfilled"> ORDENAR</button>
                        </div>
                        
                    </div>

                    
                     
                </div>               
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
            
           
            <div class="col-md-12 no_horizontal_padding margin_top">
                <h2>PREGUNTAS Y RESPUESTAS</h2>
                <div class="moreDetails">
                    <div class="row-fluid clearfix questions">
                        <div class="col-md-9">
                            <b>HAZ UNA PREGUNTA</b>
                            <textarea rows="2" maxlength="500" placeholder="Escribe tu pregunta (Max 500 caracteres)"></textarea>
                            <input class="btn-orange btn btn-danger btn-small  orange_border margin_right_small" type="submit" name="yt1" value="Preguntar Publicamente">
                            <input class="btn-gray btn btn-danger btn-small" type="submit" name="yt1" value="Preguntar en Privado">
                            <div class="row-fluid clearfix margin_top question">
                                <div class="col-md-2 text-center userInfo">
                                    <img src="http://placehold.it/50x50"/>
                                  
                                    <span class="userName ellipsis"><b>Compumall CA</b></span>
                                    <span class="date">27/11/2014</span>
                               </div>
                                <div class="col-md-10 content">
                                    <span><b>¿Donec id aliquet nisl. Curabitur quis sodales turpis. Vivamus id tortor nibh?</b></span>
                                  
                                    <div class="links"><a href="#">Responder</a>|<a href="#">Reportar</a></div>                                   
                                </div>
                                
                            </div>
                            
                             <div class="row-fluid clearfix margin_top question">
                                <div class="col-md-2 text-center userInfo">
                                    <img src="http://placehold.it/50x50"/>
                                  
                                    <span class="userName ellipsis"><b>Compumall CA</b></span>
                                    <span class="date">27/11/2014</span>
                               </div>
                                <div class="col-md-10 content">
                                    <span><b>¿Donec id aliquet nisl. Curabitur quis sodales turpis. Vivamus id tortor nibh?</b></span>
                                    <span>Nulla porta nisi et eros fermentum luctus. Donec id aliquet nisl. Curabitur quis sodales turpis. Vivamus id tortor nibh. Nulla facilisi. Praesent nibh lorem, sollicitudin malesuada viverra eu, venenatis ac purus.</span> 
                                    <div class="links"><a href="#">Responder</a>|<a href="#">Reportar</a></div>                                   
                                </div>
                                
                            </div>
                            
                            <div class="row-fluid clearfix margin_top question">
                                <div class="col-md-2 text-center userInfo">
                                    <img src="http://placehold.it/50x50"/>
                                  
                                    <span class="userName ellipsis"><b>Compumall CA</b></span>
                                    <span class="date">27/11/2014</span>
                               </div>
                                <div class="col-md-10 content">
                                    <span><b>¿Donec id aliquet nisl. Curabitur quis sodales turpis. Vivamus id tortor nibh?</b></span>
                                    <span>Nulla porta nisi et eros fermentum luctus. Donec id aliquet nisl. Curabitur quis sodales turpis. Vivamus id tortor nibh. Nulla facilisi. Praesent nibh lorem, sollicitudin malesuada viverra eu, venenatis ac purus.</span> 
                                    <div class="links"><a href="#">Responder</a>|<a href="#">Reportar</a></div>                                   
                                </div>
                                
                            </div>
                           
                                                        
                        </div>
                        <div class="col-md-3">
                          <b>MEJORES RESPUESTAS</b>
                          <section class="margin_top">
                              <article class="best margin_bottom_large">
                                  <span><b>¿Donec id aliquet nisl. Curabitur quis sodales turpis. Vivamus id tortor nibh?</b></span>
                                  <span class="margin_top_small">Nulla porta nisi et eros fermentum luctus. Donec id aliquet nisl. Curabitur quis sodales turpis. Vivamus id tortor nibh. Nulla facilisi. Praesent nibh lorem, sollicitudin malesuada viverra eu, venenatis ac purus.</span>
                                  
                              </article>
                              
                              <article class="best margin_bottom_large">
                                  <span><b>¿Donec id aliquet nisl. Curabitur quis sodales turpis. Vivamus id tortor nibh?</b></span>
                                  <span class="margin_top_small">Nulla porta nisi et eros fermentum luctus. Donec id aliquet nisl. Curabitur quis sodales turpis. Vivamus id tortor nibh. Nulla facilisi. Praesent nibh lorem, sollicitudin malesuada viverra eu, venenatis ac purus.</span>
                                  
                              </article>
                              
                          </section>
                          
                          
                            
                        </div>
                    </div>                                  
                </div>  
                              
            </div>
            
