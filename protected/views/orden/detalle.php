<?php $this->breadcrumbs=Yii::app()->user->isAdmin()?array('Ordenes'=>'../admin','Orden #'.$model->id):array('Mis Compras'=>'../misCompras','Orden #'.$model->id); ?> 
<div id="orderDetail" class="row-fluid margin_top">
    <h2>INTENCION DE COMPRA</h2>
    <div class="col-md-6 orderInfo no_horizontal_padding "> 
        <div class="row-fluid clearfix" >        
            <div class="col-md-6 padding_bottom_small" >
        <h3 class="margin_top_small">Estado actual: </h3>
                <?php
        if($model->estado==0)
		{?>
					<p class="estadoOrden"><span id="estado"><?php echo $model->estados($model->estado);?></span></p>
		<?php	
		}
		if($model->estado==1)
		{?>
					<p class="estadoOrden"><span id="estado" class="aceptado"><?php echo $model->estados($model->estado);?></span></p>
		<?php	
		}
		if($model->estado==2)
		{?>
					<p class="estadoOrden"><span id="estado" class="rechazado"><?php echo $model->estados($model->estado);?></span></p>
		<?php	
		}
		?>
		</div>
       </div>
        <div class="margin_top sellerInfo">
            <p>
                <span class="name">Información del Vendedor</span>
            </p>
            <p>
                <span class="name">N° de Orden:</span>
                <span class="value"><?php echo $model->id;?></span>
            </p>
            <p>
                <span class="name">Fecha de Emisión:</span>
                <span class="value"><?php $date = date_create($model->fecha);echo date_format($date, 'd/m/Y H:i:s');?></span>
            </p>
            <p>
                <span class="name">Proveedor:</span>
                <span class="value"><?php echo $model->almacen->empresas->razon_social;?></span>
            </p>
            <p>
                <span class="name">RIF:</span>
                <span class="value"><?php echo $model->almacen->empresas->rif;?></span>
            </p>
           <!-- <p>
                <span class="name">Dirección de Envío:</span>
                <span class="value">Edif. Los Mirtos, Piso 3 Oficina 3 San Cristóbal Edo. Táchira</span>
           </p> -->
            <p>
                <span class="name">Teléfono:</span>
                <span class="value"><?php echo $model->almacen->empresas->telefono;?></span>
            </p>
            <!--<p>
                <span class="name">Correo Electrónico:</span>
                <span class="value">falta definir cual correo</span>
            </p>-->
        </div>
    </div>
    <div class="col-md-6 orderActions no_horizontal_padding margin_top_small">
        <h3>Acciones pendientes</h3>
        <table width="100%" class="table-striped">
            <col width="30%">
            <col width="40%">
            <col width="30%">
            <thead>
                <tr>
                    <th>Estado</th>
                    <th>Usuario</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
            	<?php foreach($ordenEstado as $local): ?>
                <tr>
                    <td><?php echo $local->orden->estados($local->estado);?></td>
                    <td><?php echo $local->user->profile->first_name." ". $local->user->profile->last_name;?></td>
                    <td><?php $date = date_create($local->fecha);echo date_format($date, 'd/m/Y H:i:s');;?></td>
                </tr>
                
               <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="col-md-12 cart no_horizontal_padding">
        <div class="orderContainer margin_top_large margin_bottom">
                <div class="title clearfix">
                   <div class="row-fluid">
                      <div class="col-md-6 no_horizontal_padding">ORDEN #<?php echo $model->id;?></div>
                       <div class="col-md-6 no_horizontal_padding text-right"><?php echo $model->almacen->empresas->razon_social;?></div>
                   </div>
                </div>
                <div class="detail">
                    <table width="100%">
                        <colgroup>
                        <col width="10%">
                        <col width="30%">
                        <col width="10%">
                        <col width="10%">
                        <col width="10%">
                        <col width="10%">
                        <col width="10%">
                        <col width="10%">
                        </colgroup><thead>
                            <tr>
                                <th colspan="2">Producto</th>
                                <th class="text-center">Codigo TLT</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-center">Precio Unt.</th>
                                <th class="text-center">Sub Total</th>
                                 <th class="text-center">I. V. A.</th>
                                  <th class="text-center">Precio Total</th>
                               
                            </tr>
                        </thead>
                        
                        <tbody>
                        	
                        	<?php 
                        	$acumulado=0;
                        	foreach($productoOrden as $proc):
                        	$imagenPrincipal=Imagenes::model()->findByAttributes(array('producto_id'=>$proc->inventario->producto->id, 'orden'=>1));
                        	?>
                             <tr>
                             	<td class="img"><img width="100%" src="<?php echo Yii::app()->getBaseUrl(true).$imagenPrincipal->url;?>"/></td> 
                                <td class="name"> <?php echo $proc->inventario->producto->nombre;?></td>
                                <td class="number"><?php echo $proc->inventario->producto->tlt_codigo;?></td>
                                <td class="number"><?php echo $cantidad=$proc->cantidad;?></td>
                                <td class="number"><?php echo Funciones::formatPrecio($precio=$proc->inventario->precio);?></td>
                                <td class="number highlighted"><?php echo Funciones::formatPrecio($sub=$precio*$cantidad); ?></td>
                                <td class="number highlighted"><?php echo Funciones::formatPrecio($iva=$precio*$cantidad*0.12);?></td>
                                <td class="number highlighted"><?php echo Funciones::formatPrecio($tota=$sub+$iva);?></td>
                                 <?php $acumulado+=$tota; ?>
                                
                            </tr>
                            <?php endforeach;  ?>
                            
                       </tbody>
                    </table>
                </div>
               

                <div class="summary text-right">
                    
                    <span id="total">Total: <?php echo Funciones::formatPrecio($acumulado);?></span>
                   
                </div>
            </div>
    </div>
    
    
    
</div>

