<div class="container-fluid" style="padding: 0 15px;">
    <div class="container">
        <div class="row-fluid">
            <!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->
            <div class="main-content" role="main">
                    <div class="margin_top_small margin_bottom_small">
                        <div class="alert alert-success">
                            <h2>
                               Compra confirmada
                            </h2>
                            Tu compra se ha realizado con éxito, en los proximos segundos recibirás una email con los datos
                        </div>   
                    </div>
                    
              
                    <section class="row-fluid">
                        
                         <h1>Pedido N° <?php echo $model->id; ?> </h1>
                         <hr class="no_margin_top"/>
                         <div class="col-md-4 well" style="background: #FFF" >
                            
                            <table class="table" id="summary">
                                <tr>
                                    <td>Subtotal</td>
                                    <td><strong><?php echo $model->total-$model->envio-$model->iva; ?> Bs</strong></td>
                                </tr>
                                <tr>
                                    <td>Envio</td>
                                    <td><strong><?php echo $model->envio; ?> Bs</strong></td>
                                </tr>
                                <tr>
                                    <td>IVA</td>
                                    <td><strong><?php echo $model->iva; ?> Bs</strong></td>
                                </tr>
                                <?php if($model->balance>0): ?>
                                <tr>
                                    <td> Balance usado</td>
                                    <td><strong><?php echo $model->balance; ?> Bs</strong></td>
                                </tr>
                                <?php endif; ?>
                                <tr>
                                    <td class="total">Total</td>
                                    <td class="total"><strong><?php echo $model->total; ?> Bs</strong></td>
                                </tr>
                            </table>
                            
                            <div>  
                                <p class="text-muted">Fecha estimada de entrega<br/><?php echo date('d/m/Y', strtotime($model->fecha.'+1 day'));?> - <?php echo date('d/m/Y', strtotime($model->fecha.'+1 week')); ?></p>
                            </div>                            
                        </div>
                        
                                               
                        <div class="col-md-8 no_padding_right">
                            
                        <table class="table" id="orderDetail">
                            <thead>
                              <tr>
               
                                <th colspan="2">Producto</th>
                                <th>Precio</th>
                                <th title="Cantidad">Cant.</th>
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
                                            }else{ // <td>'.$inventario->precio.' Bs</td>
                                                echo $orden_inventario->precio;
                                            } 

                                        //echo $orden_inventario->precio; ?> Bs</td>
                                        <td align="center"><?php echo $orden_inventario->cantidad; ?></td>
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
