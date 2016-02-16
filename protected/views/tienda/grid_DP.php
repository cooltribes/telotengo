<?php 
$inventario=Inventario::model()->findByAttributes(array('producto_id'=>$data->id, 'precio'=>$data->minPrice));
                $contador=Inventario::model()->countByAttributes(array('producto_id'=>$data->id));

?>    
    
    <div class="col-md-4">
        <article class="itemGridView">
        	
        	
					<a href="<?php echo Yii::app()->createUrl("site/detalle",array("producto_id"=>$data->id, 'almacen_id'=>$inventario->almacen_id));?>">
		
            <div class="img text-center">
            	<?php
            	
				
					$imagenPrincipal=Imagenes::model()->findByAttributes(array('producto_id'=>$data->id, 'orden'=>1));
				
               
               if(isset($imagenPrincipal))
               {?>
               		<img  width="180" height="180" src="<?php echo Yii::app()->getBaseUrl(true).$imagenPrincipal->url;?>"/>
               <?php
               }
               else
               {?>
               		<img src="http://placehold.it/200x200" width="180" height="180"/>
			   <?php
			   }?>
                
            </div>
            <div class="name clearfix">
                <?php 
               
					echo $data->nombre;
				
                ?>
                
                            
            </div>
            <div class="priceHover text-right clearfix">
            	<span class="legend" style="display:block">Desde</span>
            	
					
                    <span class="quantity"><?php echo strlen($inventario->formatPrecio)>7?"<small>".$inventario->formatPrecio."</small>":$inventario->formatPrecio; ?></span>
				
					
            </div>
            <div class="info clearfix">
                <div class="inventory"> 
                   <ul> 
                  
                   		
                   				<li><span>Unidades: <?php echo $inventario->cantidad;?></span></li>
                   		
				
					<li><span>Proveedores: <?php echo $contador;?></span></li>
                   
                   </ul>
                   
                </div>
                <div class="price text-right">
                    <span class="legend">desde</span>
               
                  	  <span class="quantity"><?php echo $inventario->formatPrecio;?> </span>
				
                </div>
                <!--
                <div class="logos">
                    <img src="http://placehold.it/20x20"/>
                    <img src="http://placehold.it/20x20"/>
                    <img src="http://placehold.it/20x20"/>
                    <img src="http://placehold.it/20x20"/>
                    <img src="http://placehold.it/20x20"/>
                </div> -->
            </div>
        </a>
        </article>
     </div> 
