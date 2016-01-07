    <div class="col-md-4">
        <article class="itemGridView">
        	<?php
        	if($way==0)
			{
				if($quitar==0):
				?>
					<a href="<?php echo Yii::app()->createUrl("site/detalle",array("producto_id"=>$modelado['id'], 'almacen_id'=>$inventario->almacen_id));?>">
			<?php
				endif;
				if($quitar==1):
				?>
					<a href="<?php echo Yii::app()->createUrl("site/detalle",array("producto_id"=>$modelado['id'], 'almacen_id'=>$inventario['almacen_id']));?>">
				<?php
				endif;	
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
				{
					if($quitar==0):
					?>
                    <span class="quantity"><?php echo strlen($inventario->formatPrecio)>7?"<small>".$inventario->formatPrecio."</small>":$inventario->formatPrecio; ?></span>
				<?php
					endif;
					if($quitar==1):
					?>
                    <span class="quantity"><?php echo strlen(Funciones::formatPrecio($inventario['menor']))>7?"<small>".Funciones::formatPrecio($inventario['menor'])."</small>":Funciones::formatPrecio($inventario['menor']); ?></span>
				<?php
					endif;
				}
				else 
				{
					if($quitar==0):
					?>
                    <span class="quantity"><?php echo strlen(Funciones::formatPrecio($modelado['menor']))>7?"<small>".Funciones::formatPrecio($modelado['menor'])."</small>":Funciones::formatPrecio($modelado['menor']); ?></span>
				<?php
					endif;
					if($quitar==1):
					?>
                    <span class="quantity"><<?php echo strlen(Funciones::formatPrecio($modelado['menoro']))>7?"<small>".Funciones::formatPrecio($modelado['menoro'])."</small>":Funciones::formatPrecio($modelado['menoro']); ?></span>
				<?php
					endif;
				}
				?>
            </div>
            <div class="info clearfix">
                <div class="inventory"> 
                   <ul> 
                   	<?php
                   		if($way==0)
                   		{
                   			if($quitar==0):
                   			?>
                   				<li><span>Unidades: <?php echo $inventario->cantidad;?></span></li>
                   		<?php
							endif;
							if($quitar==1):
                   			?>
                   				<li><span>Unidades: <?php echo $inventario['cantidad'];?></span></li>
                   		<?php
							endif;
						}
						else 
						{?>
							 <li><span>Unidades:  <?php echo $modelado['cantidad'];?></span></li>
						<?php
						} ?>
					<li><span>Proveedores: <?php echo $contador;?></span></li>
                   
                   </ul>
                   
                </div>
                <div class="price text-right">
                    <span class="legend">desde</span>
                                	<?php
            	if($way==0)
				{
					if($quitar==0):
					?>
                  	  <span class="quantity"><?php echo $inventario->formatPrecio;?> </span>
				<?php
					endif;
					if($quitar==1):
					?>
                  	  <span class="quantity"><?php echo Funciones::formatPrecio($inventario['menor']);?> </span>
				<?php
					endif;
				}
				else 
				{
					if($quitar==0):
					?>
                    <span class="quantity"><?php echo $modelado['menor'];?> </span>
				<?php
					endif;
					if($quitar==1):
					?>
                    <span class="quantity"><?php echo $modelado['menoro'];?> </span>
				<?php
					endif;
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