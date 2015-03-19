<article class="col-md-4">

       <div class="caja">
            <?php
               $item=Producto::model()->findByPk($data['id']);
                $inventario_menor_precio = Inventario::model()->getMenor($item->id);
                $principal = Imagenes::model()->findByAttributes(array('orden'=>1,'producto_id'=>$item->id));
                
                                        
            if($principal->getUrl()){
                    echo '<div class="productImage">';
                       $im = CHtml::image(str_replace(".","_thumb.",$principal->getUrl()), "Imagen");
                    echo "<a href='".$item->getUrl()."''>".$im."</a>";
                    echo "</div>";
                }
           // echo '<a href="'.Yii::app()->baseUrl.'/producto/detalle/'.$item->id.'"><h3 class="productName no_margin_top no_margin_bottom"> '.$item->nombre.' </h3></a>';
            $marca = Marca::model()->findByPk($item->marca_id);
            $a = "marcas/".$marca->nombre;?>

                            <div class="namep">
                            <h3 class="productName no_margin_top no_margin_bottom">
                                <a href="<?php echo $item->getUrl()?>"> <?php echo $item->nombre; ?></a>
                               
                            </h3>
                            <span> <small><span class="muted">por </span><?php echo CHtml::link($marca->nombre,array($a)); ?></small></span>
                            </div>
                            
                             
                      <div class="lead margin_bottom_small">
                      <?php      if($item->hasFlashsale())
                                     echo 'Aplica oferta'; ?>
                
                       </div>           

               <?php                        

            echo '<p>Bs.<big>'.$inventario_menor_precio->precio.'</big><a role="button" href="'.Yii::app()->baseUrl.'/producto/detalle/'.$item->id.'" 
                    class="btn btn-xs btn-danger pull-right">Comprar ahora »</a>';
                                    
        ?>
        </div>
</article>
