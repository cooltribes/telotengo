<article class="col-md-4">

       <div class="caja">
            <?php
               
                $inventario_menor_precio = Inventario::model()->getMenor($data->id);
                $principal = Imagenes::model()->findByAttributes(array('orden'=>1,'producto_id'=>$data->id));
                                        
            if($principal->getUrl()){
                    echo '<div class="productImage">';
                       $im = CHtml::image(str_replace(".","_thumb.",$principal->getUrl()), "Imagen",array('style'=>'width:100%'));
                    echo "<a href='".Yii::app()->baseUrl."/producto/detalle/".$data->id."''>".$im."</a>";
                    echo "</div>";
                }
            echo '<h3 class="productName no_margin_top no_margin_bottom"> '.$data->nombre.' </h3></a>';
            $marca = Marca::model()->findByPk($data->marca_id);
           
            if($data->hasFlashsale()){
                $a = "marcas/".$marca->nombre;
                echo '<small><span class="muted">por </span>'.CHtml::link($marca->nombre,array($a)).'<p class="lead">Aplica oferta.</p></small>';
            }else{
                $a = "marcas/".$marca->nombre;
                echo '<small><span class="muted">por </span>'.CHtml::link($marca->nombre,array($a)).'</small>';
            }
                                    
            echo '<p>Bs.<big>'.$inventario_menor_precio->precio.'</big><a role="button" href="'.Yii::app()->baseUrl.'/producto/detalle/'.$data->id.'" 
                    class="btn btn-xs btn-danger pull-right">Comprar ahora »</a>';
                                    
        ?>
        </div>
</article>