<div class="container">
    <div class="row-fluid">

        <!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->
        <?php if(Yii::app()->user->hasFlash('success')){?>
            <div class="alert in alert-block fade alert-success text_align_center col-md-12 margin_top_small">
                <?php echo Yii::app()->user->getFlash('success'); ?>
            </div>
        <?php } ?>
        <?php if(Yii::app()->user->hasFlash('error')){?>
            <div class="alert in alert-block fade alert-danger text_align_center col-md-12 margin_top_small">
                <?php echo Yii::app()->user->getFlash('error'); ?>
            </div>
        <?php } ?>

        <!-- OFERTAS -->
        <h3>Productos Destacados</h3>
        <hr class="no_margin_top" />
        <?php               
            $prod = new Producto;
            $productos = $prod->destacados(); 

            foreach($productos as $produc){
                $producto = Producto::model()->findByPk($produc);
                $inventario_menor_precio = Inventario::model()->getMenor($producto->id);
                ?>
                <article class="col-md-3">
                    <div class="caja"> 
                    <?php 

                    if($producto->mainimage){
                        $principal = Imagenes::model()->findByAttributes(array('orden'=>1,'producto_id'=>$producto->id)); ?>
                        <div class="productImage">
                        <?php
                            if($principal->getUrl())
                                $im = CHtml::image(str_replace(".","_thumb.",$principal->getUrl()), "Imagen ", array("width"=>"100%","style"=>"max-height:240px; overflow-y:hidden,max-width:240px; overflow-x:hidden"));
                            else 
                                echo '<img src="http://placehold.it/300x240" width="100%">';
                                 
                            echo "<a href='".$producto->getUrl()."'>".$im;  
                        ?>
                        </div>

                        <?php
                        $marca = Marca::model()->findByPk($producto->marca_id);
                        $a = "marcas/".$marca->nombre; ?>

                        <div class="namep">
                            <h3 class="productName no_margin_top no_margin_bottom">
                                <a href="<?php echo $producto->getUrl()?>"> <?php echo $producto->nombre; ?></a>
                            </h3>
                            <span>
                                <small>
                                    <span class="muted">por </span><?php echo CHtml::link($marca->nombre,array($a)); ?>
                                </small>
                            </span>
                        </div>        

                        <?php
                        echo '<p>Bs.<big>'.$inventario_menor_precio->precio.'</big><a role="button" href="'.Yii::app()->baseUrl.'/producto/detalle/'.$producto->id.'" class="btn btn-xs btn-danger pull-right">Comprar ahora »</a>';
                    }
                    ?>
                    </div>
                </article>
        <?php
            }
        ?>

    </div>
</div>