<div style="color: #3c763d; background-color: #dff0d8; border-color: #d6e9c6; padding: 10px; text-align: center; margin-top: 20px; margin-bottom: 40px" >
    Gracias por comprar en nuestra tienda, a continuación te mostramos un resumen de tu orden.
</div>                        
                         <h1 style="margin-bottom: 1px; ">Pedido N° <?php echo $model->id; ?> </h1>
                         <hr style="margin-top:0px"/>
                         
                            
                            <table width="100%" align="right" style="margin-bottom: 30px;">
                               <thead>
                                   <tr align="right">
                                       <th width="40%" align="left"><u>Enviado a</u></th>
                                       <th><u>Subtotal</u></th>
                                       <th><u>Envio</u></th>
                                       <th><u>IVA</u></th>
                                      
                                   <?php if($model->balance>0): ?>
                                       <th>Balance usado</th>
                                   <?php endif; ?>
                                       <th><u>Total</u></th>
                                       
                                   </tr>
                               </thead>
                               <tbody>
                                    <tr align="right">
                                        <td align="left">
                                        <?php if(isset($model->direccionEnvio)){
                                            echo $model->direccionEnvio->nombre."<br/>";
                                            echo $model->direccionEnvio->direccion_1."<br/>";
                                            if(strlen($model->direccionEnvio->direccion_2)>3)echo $model->direccionEnvio->direccion_2."<br/>";
                                            echo $model->direccionEnvio->ciudad->nombre." - ".$model->direccionEnvio->provincia->nombre."<br/>";
                                            echo $model->direccionEnvio->telefono."<br/>";
                                        }?>                                        
                                        Fecha estimada de entrega <?php echo date('d/m/Y', strtotime($model->fecha.'+1 day'));?> - <?php echo date('d/m/Y', strtotime($model->fecha.'+1 week')); ?>
                                        </td>
                                        <td><strong><?php echo $model->total-$model->envio-$model->iva; ?> Bs</strong></td>
                                        <td><strong><?php echo $model->envio; ?> Bs</strong></td>
                                        <td><strong><?php echo $model->iva; ?> Bs</strong></td>
                                        <?php if($model->balance>0): ?>                           
                                        <td><strong><?php echo $model->balance; ?> Bs</strong></td>                               
                                        <?php endif; ?>
                                        <td><strong><?php echo $model->total; ?> Bs</strong></td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                            
                                                    
                     
                        
                                               
                       
                        <h2 style="margin-bottom:1px; margin-top: 30px;">Detalle del pedido</h2>
                        <hr style="margin-top:0 0 20px 0"/>    
                        <table  width="100%"> 
                            <thead>
                              <tr>
               
                                <th colspan="2" align="left"></th>
                                <th align="right" width="15%"><u>Precio</u></th>
                                <th width="15%" title="Cantidad"><u>Cantidad</u></th>
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

                                        <td align="right">Bs <?php 
                                            if($orden_inventario->inventario->hasFlashSale()){
                                                echo $orden_inventario->inventario->flashSalePrice();
                                            }else{ // <td>'.$inventario->precio.' Bs</td>
                                                echo $orden_inventario->precio;
                                            } 

                                        //echo $orden_inventario->precio; ?></td>
                                        <td align="center"><?php echo $orden_inventario->cantidad; ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                       
                        
                    </section>