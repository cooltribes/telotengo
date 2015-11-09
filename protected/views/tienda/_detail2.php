<div class="row-fluid clearfix itemListView no_horizontal_padding padding_top_small margin_bottom_small">
     <div class="col-md-2 img no_horizontal_padding">
                <?php
            	if($way==0)
				{
					$imagenPrincipal=Imagenes::model()->findByAttributes(array('producto_id'=>$modelado['id'], 'orden'=>1));
				}
				else
				{
					$imagenPrincipal=Imagenes::model()->findByAttributes(array('producto_id'=>$producto->id, 'orden'=>1));
				}
					?>
               <?php
               if(isset($imagenPrincipal))
               {?>
               		<img  width="90" height="90" src="<?php echo Yii::app()->getBaseUrl(true).$imagenPrincipal->url;?>"/>
               <?php
               }
               else
               {?>
               		<img src="http://placehold.it/200x200" width="90" height="90"/>
			   <?php
			   }?>
                                       
        </div>
         <div class="col-md-6 description padding_top">
         	

                <?php 
                if($way==0)
                {?>
                	<a href="<?php echo Yii::app()->createUrl("site/detalle",array("producto_id"=>$modelado['id'], 'almacen_id'=>$inventario->almacen_id));?>">
         		<?php echo $modelado['nombre'];?>
         	 		</a>	
                <?php	
                }
				else
				{?>
					<a href="<?php echo Yii::app()->createUrl("site/detalle",array("producto_id"=>$producto->id, 'almacen_id'=>$modelado['almacen_id']));?>"
					<?php
					echo $producto->nombre;
					?>
					</a>	
				<?php
				}
                ?>
         </div>
          <div class="col-md-2 details padding_top text-center">
                <span class="quantity">Proveedores: <?php echo $contador;?></span>
                
                <span class="legend">
                	<?php
                	    if($way==0)
                   		{?>
                   			 <?php echo $inventario->cantidad;?>
                   		<?php
						}
						else 
						{?>
							 <?php echo $modelado['cantidad'];?>
						<?php
						} ?>
						unidades
                </span>
                                       
          </div>
          <div class="col-md-2 price padding_top text-right no_padding_right">
               <span class="legend">Desde</span>
                           	<?php
            	if($way==0)
				{?>
                    <span class="quantity"><?php echo $inventario->precio;?> BS</span>
				<?php
				}
				else 
				{?>
                    <span class="quantity"><?php echo $modelado['menor'];?> BS</span>
				<?php
				}
				?>
         </div>
</div>