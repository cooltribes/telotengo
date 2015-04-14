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
                            Tu compra se ha realizado con éxito, en los proximos segundos recibirás una email con los datos. <br />

                            Debes realizar el deposito o transferencia electrónica en un máximo de 3 días a cualquiera de las siguientes <strong>cuentas corrientes</strong>:
                            <ul style="list-style-type:square" class="margin_top_small margin_left_small">
                                <li><strong>Banesco</strong> - 0134 0261 2026 1101 8222</li>
                                <li><strong>Venezuela</strong> - 0102 0129 2500 0008 9665</li>
                                <li><strong>Mercantil</strong> - 0105 0735 9417 3503 3014</li>
                                <li><strong>Banfoandes</strong> - 0007 0147 5600 0000 3292</li>
                                <li><strong>Sofitasa</strong> - 0137 0020 6200 0900 7231</li>
                                <li><strong>100% Banco</strong> - 0156 0015 2804 0019 1722</li>
                                <li><strong>BFC C.A</strong> - 0151 0135 1530 0004 2301</li>
                                <li><strong>Banco Activo</strong> - 0171 0018 1660 0037 0854</li>
                                <li><strong>Bancaribe</strong> - 0114 0430 8443 0005 2865</li>
                                <li><strong>Provincial</strong> - 0108 0098 6001 0005 7276</li>
                                <li><strong>Venezolano de Crédito </strong>- 0104 0033 3903 3008 3417.</li>
                                <li><strong>Corpbanca/BOD</strong>- 0121 0312 3700 1338 1504</li>
                                <li><strong>Banco Exterior</strong> - 0115 0114 1410 02398498</li>
                            </ul>

                            <h4 class="margin_top_small">Datos para la transferencia:</h4>
                            <ul style="list-style-type:square" class="margin_top_small margin_left_small">
                                <li><strong>Beneficiario/Razón Social</strong>: Sigmasys C.A.</li>
                                <li><strong>Correo electrónico:</strong> info@sigmatiendas.com</li>
                                <li><strong>RIF</strong>: J-29468637-0</li>
                                <li><strong>Dirección</strong>: Avenida libertador  C.C Las Lomas local 30,  San Cristóbal,  Edo. Táchira.
                                <li><strong>Teléfono</strong>:  02763442626</li>
                            </li>
                            </ul>
                        </div>   
                    </div>
                    
                    <div class="margin_top_xsmall alert alert-danger">
                        <strong>Importante</strong>: una vez realizado el pago debes notificarlo indicando los datos del depósito <a href="<?php echo Yii::app()->baseUrl.'/orden/detalleusuario/'.$model->id; ?>">Aquí</a>
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
