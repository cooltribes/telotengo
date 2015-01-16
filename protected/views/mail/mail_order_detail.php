                         
<div style="color: #3c763d; background-color: #dff0d8; border-color: #d6e9c6;" >
    Gracias por comprar en nuestra tienda, a continuación te mostramos un resumen de tu orden.
</div>                        
                         
                         
                         
                         <h1>Pedido N° <?php echo $model->id; ?> </h1>
                         <hr style="margin-top:0px"/>
                         <div>
                            
                            <table>
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
                                <p>Fecha estimada de entrega<br/><?php echo date('d/m/Y', strtotime($model->fecha.'+1 day'));?> - <?php echo date('d/m/Y', strtotime($model->fecha.'+1 week')); ?></p>
                            </div>                            
                        </div>
                        
                                               
                        <div>
                            
                        <table>
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
                                        $im = CHtml::image($_SERVER['SERVER_NAME'].str_replace(".","_thumb.",$principal->getUrl()), "Preview", array("height"=>"100px", "width" => "100px",'class'=>'img-responsive'));
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