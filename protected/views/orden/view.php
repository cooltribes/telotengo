<div class="container-fluid" style="padding: 0 15px;">
    <div class="container">
        <div class="row">
            <!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->
            <div class="col-md-10 col-md-offset-1 main-content" role="main">
                    <div class="page-header">
                        <h1>
                           Compra confirmada
                        </h1>
                    </div>
                    <div class="alert alert-success lead">Tu compra se ha realizado con éxito, en los proximos seguntos recibirás una email con los datos</div>
                    <hr>
                    <section>
                        <h3>Resumen de la compra</h3>
                        <div>
                            <p class="well well-sm"> Número de pedido: <span><?php echo $model->id; ?></span> </p>
                            <div class="padding_xsmall">
                                Subtotal: <span><?php echo $model->total-$model->envio-$model->iva; ?> Bs.</span>
                            </div>
                            <div class="padding_xsmall">
                                Envio: <span><?php echo $model->envio; ?> Bs.</span>
                            </div>
                            <div class="padding_xsmall">
                                IVA: <span><?php echo $model->iva; ?> Bs.</span>
                            </div>
                            <div class="padding_xsmall">
                                Balance usado: <span><?php echo $model->balance; ?> Bs.</span>
                            </div>
                            <div class="">
                                <h3>
                                    Total: <strong><?php echo $model->total; ?> Bs.</strong>
                                </h3>
                            </div>
                            <div>  
                                <p class="text-muted">Fecha estimada de entrega <?php echo date('d/m/Y', strtotime($model->fecha.'+1 day'));?> - <?php echo date('d/m/Y', strtotime($model->fecha.'+1 week')); ?></p>
                            </div>                            
                        </div>                        
                        <div>
                            <h4>Detalles del pedido</h4>
                        <table class="table">
                            <thead>
                              <tr>
                                <th></th>
                                <th>Nombre del producto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($model->ordenHasInventarios as $orden_inventario) {
                                    $caracteristicas_nosql = Caracteristica::model()->findAllByAttributes(array('inventario_id'=>$orden_inventario->inventario->id));                                                     
                                    $caracteristicas = '';
                                    $cont = 1;
                                    foreach ($caracteristicas_nosql as $c_nosql) {
                                        if($cont == sizeof($caracteristicas_nosql)){
                                            $caracteristicas .= $c_nosql->valor;
                                        }else{
                                            $caracteristicas .= $c_nosql->valor.', ';
                                        }
                                        $cont++;
                                    }

                                    $principal = Imagenes::model()->findByAttributes(array('orden'=>1,'producto_id'=>$orden_inventario->inventario->producto_id));
                                                                        
                                    if($principal->getUrl())
                                        $im = CHtml::image(str_replace(".","_thumb.",$principal->getUrl()), "Preview", array("height"=>"100px", "width" => "100px",'class'=>'img-responsive'));
                                    else 
                                        $im = '<img src="http://placehold.it/100x100" width="100%">';   
                                    ?>
                                    <tr>
                                        <td><?php echo $im; ?></td>
                                        <td>
                                            <div><?php echo $orden_inventario->inventario->producto->nombre; ?></div>
                                        </td>

                                        <td><?php 
                                            if($orden_inventario->inventario->hasFlashSale()){
                                                echo $orden_inventario->inventario->flashSalePrice();
                                            }else{ // <td>'.$inventario->precio.' Bs.</td>
                                                echo $orden_inventario->precio;
                                            } 

                                        //echo $orden_inventario->precio; ?> Bs.</td>
                                        <td><?php echo $orden_inventario->cantidad; ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        </div>
                    </section>
                    <div class="col-sm-offset-5 padding_medium">
                        <a href="<?php echo Yii::app()->baseUrl; ?>" class="btn btn-success btn-lg">Seguir Comprando</a>
                    </div>

            </div> 
            <!-- COLUMNA PRINCIPAL DERECHA OFF // -->
        </div>
    </div>
</div>
