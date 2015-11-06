    <div class="col-md-4">
        <article class="itemGridView">
        	<?php
        	if($way==0)
			{?>
				<a href="<?php echo Yii::app()->createUrl("site/detalle",array("producto_id"=>$modelado['id'], 'almacen_id'=>$inventario->almacen_id));?>">
			<?php
			}
			else 
			{?>
				<a href="<?php echo Yii::app()->createUrl("site/detalle",array("producto_id"=>$producto->id, 'almacen_id'=>$modelado['almacen_id']));?>">
			<?php
			}
        	?>
            <div class="img text-center">
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
            <div class="name clearfix">
                <?php 
                if($way==0)
                {
                	echo $modelado['nombre'];
                }
				else
				{
					echo $producto->nombre;
				}
                ?>
                
                            
            </div>
            <div class="priceHover text-right clearfix">
            	<span class="legend" style="display:block">Desde</span>
            	<?php
            	if($way==0)
				{?>
                    <span class="quantity"><?php echo $inventario->precio<10000?$inventario->precio:$inventario->precio;?><small> Bs</small></span>
				<?php
				}
				else 
				{?>
                    <span class="quantity"><?php echo $modelado['menor']<10000?$modelado['menor']:$modelado['menor'];?><small> Bs</small></span>
				<?php
				}
				?>
            </div>
            <div class="info clearfix">
                <div class="inventory"> 
                   <ul> 
                   	<?php
                   		if($way==0)
                   		{?>
                   			<li>Unidades: <?php echo $inventario->cantidad;?></li>
                   		<?php
						}
						else 
						{?>
							 <li>Unidades:  <?php echo $modelado['cantidad'];?></li>
						<?php
						} ?>
					<li>Proveedores: <?php echo $contador;?></li>
                   
                   </ul>
                   
                </div>
                <div class="price text-right">
                    <span class="legend">desde</span>
                                	<?php
            	if($way==0)
				{?>
                    <span class="quantity"><?php echo $inventario->precio;?> Bs</span>
				<?php
				}
				else 
				{?>
                    <span class="quantity"><?php echo $modelado['menor'];?> Bs</span>
				<?php
				}
				?>
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