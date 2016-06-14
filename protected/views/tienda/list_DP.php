
<?php 
$inventario=Inventario::model()->findByAttributes(array('producto_id'=>$data->id, 'precio'=>$data->minPrice));
                $contador=Inventario::model()->countByAttributes(array('producto_id'=>$data->id)); ?>




<div class="row-fluid clearfix itemListView padding_top_small margin_bottom_small">
     <div class="col-md-2 img no_horizontal_padding">
                <?php
             
                    $imagenPrincipal=Imagenes::model()->findByAttributes(array('producto_id'=>$data->id, 'orden'=>1));
                
                    ?>
               <?php
               if(isset($imagenPrincipal))
               {?>
                   <a href="<?php echo Yii::app()->createUrl("producto/detalle",array("producto_id"=>$data->id, 'almacen_id'=>$inventario->almacen_id));?>"> <img width="90" height="90" src="<?php echo Yii::app()->getBaseUrl(true).$imagenPrincipal->url;?>"/> </a>
               <?php
               }
               else
               {?>
                    <img src="http://placehold.it/200x200" width="90" height="90"/>
               <?php
               } 
               
               
               
               
          ?> 
                                       
        </div>
         <div class="col-md-6 description padding_top">
            
        
     
                
                    <a href="<?php echo Yii::app()->createUrl("producto/detalle",array("producto_id"=>$data->id, 'almacen_id'=>$inventario->almacen_id));?>">
                    <?php
                    echo $data->nombre;
                    ?>
                    </a>    
              
             
         </div>
          <div class="col-md-2 details padding_top text-center">
                <span class="quantity">Proveedores: <?php echo $contador;?></span>
                
                <span class="legend">
            
                             <?php 
                                  $sql='select sum(cantidad) as cant from tbl_inventario where producto_id="'.$inventario->producto_id.'"';
                                  $sumatoria=Yii::app()->db->createCommand($sql)->queryRow(); echo $sumatoria=$sumatoria['cant'];?>
                       
                        unidades
                </span>
                                       
          </div>
          <div class="col-md-2 price padding_top text-right no_padding_right">
               <span class="legend">Desde</span>
            
                    <span class="quantity"><?php echo Funciones::formatPrecio($inventario->precio);?></span>
       
                   
                
         </div>
</div>
