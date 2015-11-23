<?php
$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/js/jquery.zoom.js');
?>
        <div class="breadcrumbs margin_top">
                <a><span>Inicio</span></a>/&nbsp;
                <a><span>Sub Categoria</span></a>/&nbsp;
                <a><span>Sub Categoria 1.1</span></a>/&nbsp;
                <a><span class="current">Producto</span></a>
        </div>
        

        

        

            
            
            <div class="col-md-9 main no_horizontal_padding">
                <div class="row-fluid">
                
                    <div class="col-md-4 no_left_padding">
                        <div class='imagen_principal' style="overflow:hidden; max-height: 300px;"> 
                           <img src="<?php echo Yii::app()->getBaseUrl(true).$imagenPrincipal->url;?>" width="100%" id="mainImage" />
                        </div>
                        
                         <div class="secondary_images">
                           <div id="myCarousel" class="carousel slide carouselSecs" data-ride="carousel">
                            <div class="control"><?php if(count($imagen)>5): ?> <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev"><span><</span><span class="sr-only">Previous</span> </a><?php endif; ?></div>
                              <!-- Wrapper for slides -->
                              <div class="carousel-inner" role="listbox">
                            <?php $key=0;
                                                       foreach($imagen as $image): 
                                                       
                                                         echo $key==0?"<div class='item miniSlide'>":"";?>
                                                  
                                                           
                                                         <div class="minislideImg"><img src="<?php echo str_replace('.jpg', '_x90.jpg', Yii::app()->getBaseUrl(true).$image->url);?>" width="100%" /></div>
                                                            
                                                   <?php 
                                                         if($key==4): echo "</div>"; $key=0; else: $key++; endif;
                                                   endforeach;
                                                       echo $key<4?"</div>":"";
                                                       ?>
                            
                              </div>
                            
                              <!-- Left and right controls -->
                              
                                
                                
                             
                              
                                <div class="control"><?php if(count($imagen)>5): ?> <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next"><span>></span><span class="sr-only">Next</span></a><?php endif; ?></div>
                                
                              
                            </div> 
                           
                           
                           
                       </div>
                        
                        
                        
                        
                    </div>
                    
                    
                    <div class="col-md-8 mainDetail">
                        
                        <h1 class="no_margin_top" style="height: auto">
                          <?php echo $model->nombre;?> 
                        </h1>
                        <div class="separator"></div>
                        <table width="100%" class="priceTable">
                            <col width="50%">
                            <col width="50%">
                            <tr>
                                <td class="title">Precio en tienda</td>
                                <td class="throughlined"><?php echo $inventario->precio;?> Bs</td>
                            </tr>
                            <tr>  
                                
                                <td class="title" width="22%">Estatus</td>
                                <?php
                                if($inventario->cantidad>0) 
                                {?>
                                	<td class="success"> En Stock</td>  
                                <?php	
                                }else
								{?>
									<td class="error"> Agotado</td>  
								<?php
								}	
                                ?>
                                	 
                                                   
                            </tr>

                        </table>
                        <div class="specs margin_top">
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
                        
                    </div>
                        
                    
                    
                    
                    <div class="col-md-12 no_padding_left margin_top">
                         <div class="moreDetails">                                       
                            <ul id="myTabs" class="nav nav-tabs" role="tablist">
                              <li role="presentation" class="active"><a href="#moreDetails" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">DETALLES DEL PRODUCTO</a></li>
                              <li role="presentation" class=""><a href="#specifications" role="tab" id="specifications-tab" data-toggle="tab" aria-controls="specifications" aria-expanded="false">CARACTERÍSTICAS GENERALES</a></li>
                           <!--   <li role="presentation" class=""><a href="#recommendations" role="tab" id="recommendations-tab" data-toggle="tab" aria-controls="recommendations" aria-expanded="false">RECOMENDACIONES DEL PRODUCTO</a></li>--></-->
                              
                            </ul>
                            <div id="myTabContent" class="tab-content">
                              <div role="tabpanel" class="tab-pane fade active in" id="moreDetails" aria-labelledby="home-tab">
                                 
                                <?php if(!is_null($busqueda))$this->renderPartial('more_details', array('busqueda'=>$busqueda,'solo_una'=>true));else echo "<div class='text-center margin_top'>No hay información disponible</div>" ?>
                              </div>
                              <div role="tabpanel" class="tab-pane padding_top padding_bottom" id="specifications" aria-labelledby="specifications-tab">
                                 <?php echo $model->descripcion; ?>
                             
                              </div>
                              
                            </div>
                        </div>
                    </div>  
                    
                       
                    
                </div>
                    

             
             </div>
        
            <div class="col-md-3 no_padding_right ">
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
                            	<?php
                            	$empre=Empresas::model()->findByPk((EmpresasHasUsers::model()->findByAttributes(array('users_id'=>Yii::app()->user->id))->empresas_id));
							    if($inventario->almacen->empresas->id==$empre->id):?> 
                               		<a href="#" class="btn-orange margin_bottom_small btn btn-danger btn-large orange_border form-control" data-toggle="tooltip"  title="No puede comprar productos de su propia empresa">Ordenar</
								<?php
								endif;
                            	 if(!Yii::app()->user->isAdmin() && $inventario->almacen->empresas->id!=$empre->id)
                                	echo CHtml::submitButton('ORDENAR', array('id'=>'ordenar','class'=>'btn-orange margin_bottom_small btn btn-danger btn-large orange_border form-control')); 
                           		?>	
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
                            	<?php
                            	if(!Yii::app()->user->isAdmin()): ?>
                            		<button class="btn btn-small btn-unfilled ordenarIndividual" id="<?php echo $data->id;?>"> ORDENAR</button>  
                            	<?php endif; ?>                   
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
            
   
            
           <?php //$this->renderPartial('preguntas_respuestas', array('model'=>$model, 'empresa_id'=>$empresa->id)); ?>
           
           
           
           <script>
           	$(document).ready(function() {
           		$('[data-toggle="tooltip"]').tooltip(); 
           
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


<!-- Imagenes y ZOOM -->           
   <script>
       

$(document).ready(function(){

        var source = $('#mainImage').attr("src");
        var imgZ = source.replace(".jpg","_orig.jpg");
        
        $('.imagen_principal').zoom({url: imgZ});
        
            $(".imagen_principal").hover(function(){ 
                var source = $('#mainImage').attr("src");
                var imgZ = source.replace(".jpg","_orig.");
                
                if(imgZ.indexOf(".png")> -1){ // consiguio png
                    zoom = imgZ.replace(".png",".jpg");
                    $('.imagen_principal').zoom({url: zoom});
                }else{
                    $('.imagen_principal').zoom({url: imgZ});
                }           
                
            });
        
    });
    
    
    $(".minislideImg>img").click(function(){
        var image = $('#mainImage');
        var thumbnail = $(this).attr("src");
        $('.imagen_principal').find('.zoomImg').remove(); 
        console.log(image);
        console.log(thumbnail);
        
        var cambio = thumbnail.replace("_x90.jpg",".jpg");

        // primero cargo la imagen del zoom y aseguro que al momento de hacer el cambio de imagen principal esté listo el zoom
        var source = cambio;
        var imgZ = source.replace(".jpg","_orig.jpg");
        
        // $('.imagen_principal').zoom({url: imgZ});
        
        if(imgZ.indexOf(".png")> -1){ // consiguio png
            zoom = imgZ.replace(".png",".jpg");
            $('.imagen_principal').zoom({url: zoom});
          //  $('.imagen_principal').html('<img src="'+zoom+'" width="100%"/>');   
        }else{
            $('.imagen_principal').zoom({url: imgZ});
          //  $('.imagen_principal').html('<img src="'+imgZ+'" width="100%"/>');  
        }        
          
        // cambio de la principal   
        $("#mainImage").fadeOut("slow",function(){
            $("#mainImage").attr("src", cambio);
        });

        $("#mainImage").fadeIn("slow",function(){});

    });
       
     function replaceSize(url,size){
         if(url.indexOf(".png")==-1&&url.indexOf(".jpg")==-1)
            return '';
         if(url.indexOf(".png")> -1)
            return url.replace(".png","_"+size+".png");
          else
            return url.replace(".jpg","_"+size+".jpg");
         
     }  
       
       
   </script>
           
           
           

<div class="modal fade" id="shippingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <?php $this->renderPartial('shipping_modal'); ?>
</div>
  <!-- Wrapper for slides -->
  
    

  
<script>
$(".item.miniSlide").first().addClass("active");
$(document).ready(function () {
$('#myCarousel').carousel({
   interval: 200000
});});
</script>  
