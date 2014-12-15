<div class="container">
    <div class="row">
    <!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->
        <div>

    <?php
    $this->breadcrumbs=array(
        'Pedidos'=>array('admin'),
        'Detalle'=>array('detalle','id'=>$model->id),
        'Productos'
    );
    ?>
        <div class="margin_top">
            <h4>Productos del pedido</h4>
                <table class="table table-striped table-hover">
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
                                <div><?php echo $caracteristicas; ?></div>
                            </td>
                            <td><?php echo $orden_inventario->precio; ?> Bs.</td>
                            <td><?php echo $orden_inventario->cantidad; ?></td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
   	</div>	 
 </div>                        
