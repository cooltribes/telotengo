<?php
$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/js/jquery.zoom.js');
?>
<style>
    .moreOptions .item{
        width:95%;
        margin: 0 auto;
        padding:0px;
    }
    .item .title{
        color: #222;
        font-weight: 900;
        font-size: 18px;
        display:block;
        text-align: center;
    }
    .moreOptions .item .sellerInfo span{
        display: block;
    }
</style>
      <!--  <div class="breadcrumbs margin_top">
                <a><span>Inicio</span></a>/&nbsp;
                <a href="<?php ?>"><span><?php echo $categoria->nombre;?></span></a>/&nbsp;
                <a><span><?php echo $subCategoria->nombre;?></span></a>/&nbsp;
                <a><span class="current"><?php echo $model->nombre;?></span></a>
        </div>
       -->
        <?php 
        $this->breadcrumbs=array($categoria->nombre=>Yii::app()->createUrl('categoria/index', array('url'=>$categoria->seo->amigable)),
        						 $subCategoria->nombre=>Yii::app()->createUrl('tienda/index', array('categoria'=>$subCategoria->url_amigable)),
        						 $model->nombre); ?> 
        
 <div class="margin_top"></div>
            
            <div class="col-md-9 main no_horizontal_padding">
                <div class="row-fluid clearfix">
                
                    <div class="col-md-4 no_left_padding">
                        <div class='imagen_principal' style="overflow:hidden; max-height: 300px;"> 
                           <?php if($imagenPrincipal):?>
                           <img src="<?php echo Yii::app()->getBaseUrl(true).$imagenPrincipal->url;?>" width="100%" id="mainImage" />
                           <?php else: ?>
                                <img src="http://placehold.it/280x280" width="100%" id="mainImage" />
                           <? endif; ?>
                        </div>
                        
                         <div class="secondary_images">
                           <div id="myCarousel" class="carousel slide carouselSecs" data-ride="carousel">
                            <div class="control"><?php if(count($imagen)>5): ?> <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev"><span><</span><span class="sr-only">Previous</span> </a><?php endif; ?></div>
                              <!-- Wrapper for slides -->
                              <div class="carousel-inner" role="listbox">
                            <?php $key=0;
                                                       foreach($model->imagenes as $image): 
                                                       
                                                         echo $key==0?"<div class='item miniSlide'>":"";?>
                                                  
                                                           
                                                         <div class="minislideImg"><img src="<?php echo str_replace('.jpg', '_x90.jpg', Yii::app()->getBaseUrl(true).$image->url);?>" width="100%" /></div>
                                                            
                                                   <?php 
                                                         if($key==4): echo "</div>"; $key=0; else: $key++; endif;
                                                   endforeach;
                                                       echo $key<5&&$key!=0?"</div>":"";
                                                       ?>
                            
                              </div>
                            
                              <!-- Left and right controls -->
                              
                                
                                
                             
                              
                                <div class="control"><?php if(count($imagen)>5): ?> <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next"><span>></span><span class="sr-only">Next</span></a><?php endif; ?></div>
                                
                              
                            </div> 
                           
                           
                           
                       </div>
                        
                        
                        
                        
                    </div>
                    
                    
                    <div class="col-md-8 mainDetail">
                        
                        <h1 class="no_margin_top" style="height: auto">
                          <?php echo $model->nombre; ?> 
                        </h1>
                     <small>Marca:&nbsp;<?php echo $model->padre->idMarca->nombre; ?></small> 
                        <div class="separator"></div>
                        <table width="100%" class="priceTable">
                            <col width="50%">
                            <col width="50%"> 
                            <tr>
                                <td class="title">Precio en tienda</td>
                                <td><?php echo $inventario->formatPrecio;?></td>
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
                    <div class="col-md-12 margin_top">
                        <ul  class="nav nav-tabs">
                              <li class="active"><a class="pointer" onclick="goTo('#detalles')"  >DETALLES DEL PRODUCTO</a></li>
                              <li  class=""><a class="pointer" onclick="goTo('#caracteristicas')" >CARACTERÍSTICAS GENERALES</a></li>
                           <!--   <li role="presentation" class=""><a href="#recommendations" role="tab" id="recommendations-tab" data-toggle="tab" aria-controls="recommendations" aria-expanded="false">RECOMENDACIONES DEL PRODUCTO</a></li>--></-->
                              
                        </ul>
                    </div>   
            
                        
                    
                    
                    
                    <div class="col-md-12 no_padding_left margin_top">
                         <div class="moreDetails no_border">                                       
                            
                            
                              <div  id="detalles" aria-labelledby="home-tab" id="details">
                                 
                                <?php if(!is_null($busqueda))$this->renderPartial('more_details', array('busqueda'=>$busqueda,'solo_una'=>true));else echo "<div class='text-center margin_top'>No hay información disponible</div>" ?>
                              </div>
                              <div  class="padding_top padding_bottom" id="caracteristicas" aria-labelledby="specifications-tab">
                                 <?php echo $model->descripcion; ?>
                             
                              </div>
                              
                           
                        </div>
                    </div>  
                    
                       
                    
                </div>
                    

             
             </div>
        
            <div class="col-md-3 no_padding_right ">
                <div class="orderBox">
                    <table width="95%">
                        <tr>
                            <td class="name">Cantidad:</td>
                            <td><input id="cantidad"type="number" value="1" class="quantity" /></td>
                        </tr>
                        <tr>
                            <td class="name">Precio:</td>
                            <input type="hidden" id="precioUnitario" value="<?php echo  $inventario->precio;?>">
                            <input type="hidden" id="maximo" value="<?php echo  $inventario->cantidad;?>">
                            <input type="hidden" id="inventario_id" value="<?php echo  $inventario->id;?>">
                            <td class="highlighted" id="unitario"><?php echo $inventario->formatPrecio?></td>
                        </tr>
                        <tr>
                            <td class="name">Envio:</td>
                             <?php 
                                	if($inventario->metodoEnvio==1)
									{?>
										<td class="option">Acordado con el cliente</td>
									<?php
									}
									else
									{?>
										<td class="option">A traves del servicio de TELOTENGO</td>
									<?php	
									}
                                	?>
                        </tr>
                        <tr>
                            <td class="call" colspan="2">
                            	<?php
                              if(!Yii::app()->user->isAdmin())
                              {
                                 $empre=Empresas::model()->findByPk((EmpresasHasUsers::model()->findByAttributes(array('users_id'=>Yii::app()->user->id))->empresas_id));
                                if($inventario->almacen->empresas->id==$empre->id)
                                {?> 
                                    <a href="#" class="btn-orange margin_bottom_small btn btn-danger btn-large orange_border form-control" data-toggle="tooltip"  title="No puede comprar productos de su propia empresa">Ordenar</
                               <?php
                                }
                              } 
  
                            	 if(!Yii::app()->user->isAdmin()  && $inventario->almacen->empresas->id!=$empre->id)
                                	if(!Yii::app()->authManager->checkAccess("vendedor", Yii::app()->user->id))
                                		echo CHtml::submitButton('ORDENAR', array('id'=>'ordenar','class'=>'btn-orange margin_bottom_small white form-control'));          		
                           		if(Yii::app()->authManager->checkAccess("vendedor", Yii::app()->user->id)):?>
									<a href="#" class="btn-orange margin_bottom_small btn btn-danger btn-large orange_border form-control" data-toggle="tooltip"  title="No puede comprar ya que es un usuario Vendedor">Ordenar</
                           		<?php endif;?>
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
                       <?php foreach($otros as $key=>$data)
                       {?>
                       	  <div class="sellerInfo">
                            <span class="name"><b><?php echo $data->almacen->empresas->razon_social;?></b></span>
                            <span class="location"><?php echo $data->almacen->ciudad->nombre; ?></span>
                            <span><b><?php echo $data->formatPrecio;?></b> 
                            <span><small>Envío <?php if($inventario->metodoEnvio==1) echo "acordado con el cliente"; else echo "a través del servicio de TELOTENGO"; ?></span></small></span>
                            	<?php
                            	if(Yii::app()->authManager->checkAccess("comprador", Yii::app()->user->id) || Yii::app()->authManager->checkAccess("compraVenta", Yii::app()->user->id)): 
                  					 ?>
                            	<div class="text-right">	<a href="detalle?producto_id=<?php echo $data->producto_id?>&almacen_id=<?php echo $data->almacen_id;?>" class="btn btn-small btn-unfilled ordenarIndividual" id="<?php echo $data->id;?>">Ver producto</a>  </div>
                            	<?php endif; ?>                   
                        </div>
                        <?php if($key<count($otros)-1): ?>
                         <div class="plainSeparator"></div> 
                       <?php
                       endif;
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
	           		$('#unitario').html(formatPrice(unitario));
	           		//alert('epaa');
	           	}
	           	else
	           	{
	           		if(cantidad>=maximo)
	           		{
	           			alert("El maximo de unidades es "+maximo);
	           			$('#cantidad').val(maximo);
	           			$('#unitario').html(formatPrice(maximo*unitario));
	           			
	           		}
	           		else
	           		{
	           			$('#unitario').html(formatPrice(cantidad*unitario));
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

$('.nav.nav-tabs li').click(function(){
    $('.nav.nav-tabs li').removeClass('active');
    $(this).addClass('active');
});

function formatPrice(x){

    x = x.toString();
    x=x.replace('.',',');
    var pattern = /(-?\d+)(\d{3})/;
    while (pattern.test(x))
        x = x.replace(pattern, "$1.$2");
    return "Bs "+x;
    
}

function goTo(id){
    $(window).scrollTop($(id).position().top+200);
}
</script>  
