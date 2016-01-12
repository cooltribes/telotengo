
                      <span class="item">
                        <span class="title">Numero de orden:</span>
                        <span class="value"><?php echo $orden->id; ?></span>
                    </span>
                    <span class="item">
                        <span class="title">Vendido por:</span>
                        <span class="value"><?php echo $orden->almacen->empresas->razon_social; ?></span>
                    </span>
                    <span class="item">
                        <span class="title">Total:</span>
                        <span class="value"><?php echo Funciones::formatPrecio($orden->monto); ?></span>
                    </span>
                    <div class="goDetail"><a href="<?php echo Yii::app()->baseUrl;?>/orden/detalle/<?php echo $orden->id;?>">Ver Orden</a></div>
                    
                    <?php if (isset($separator)):?>
                        <div class="separator margin_top_small margin_bottom"></div>
                    <?php endif;?>
