<?php $this->breadcrumbs=array('Mis Compras'=>Yii::app()->createUrl('orden/misCompras'),'Orden #'.$model->id); ?> 
<div id="orderDetail" class="row-fluid margin_top">
    <h2>INTENCION DE COMPRA</h2>
    
    

    <div class="col-md-8 cart no_horizontal_padding margin_top_small">
        <div class="orderContainer margin_bottom">
                <div class="title clearfix">
                   <div class="row-fluid">
                      <div class="col-md-6 no_horizontal_padding">ORDEN #<?php echo $model->id;?></div>
                       <div class="col-md-6 no_horizontal_padding text-right"><?php echo $model->almacen->empresas->razon_social;?></div>
                   </div>
                </div>
                <div class="detail padding_left_small padding_right_small">
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
                                <td class="number"><?php echo $precio=$proc->inventario->precio;?> Bs</td>
                                <td class="number highlighted"><?php echo $sub=$precio*$cantidad; ?>Bs</td>
                                <td class="number highlighted"><?php echo $iva=$precio*$cantidad*0.12;?> Bs</td>
                                <td class="number highlighted"><?php echo $tota=$sub+$iva;?> Bs</td>
                                 <?php $acumulado+=$tota; ?>
                                
                            </tr>
                            <?php endforeach;  ?>
                            
                       </tbody>
                    </table>
                </div>
               

                <div class="summary text-right">
                    
                    <span id="total">Total: Bs. <?php echo $acumulado;?></span>
                   
                </div>
            </div>
    </div>
    
    
    <div class="col-md-4 margin_top_small">
        
        <div class="orderInfo no_horizontal_padding ">

          
           <h4>Estado actual </h4>
            <?php
            if($model->estado==0)
            {?>
         
                 
                   <p class="estadoOrden"><span id="estado" class="yellow-text"><?php echo $model->estados($model->estado);?></span></p> 
       
                    
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
        
       
            <div class="margin_top sellerInfo">
   
                    <h3>Información del Vendedor</h3>
          
               <ul>
                   <li>
        
                            <span class="name">N° de Orden:</span>
                            <span class="value"><?php echo $model->id;?></span>
                
                   </li>
            
                   <li>
                  
                            <span class="name">Fecha de Emisión:</span>
                            <span class="value"><?php $date = date_create($model->fecha);echo date_format($date, 'd/m/Y H:i:s');?></span>
              
                       
                   </li>
                   <li>
                
                            <span class="name">Empresa:</span>
                            <span class="value"><?php echo $model->almacen->empresas->razon_social;?></span>
                 
                   </li>
                   <li>
                    
                            <span class="name">RIF:</span>
                            <span class="value"><?php echo $model->almacen->empresas->rif;?></span>
                   
                   </li>
                   <li>
               
                            <span class="name">Teléfono:</span>
                            <span class="value"><?php echo $model->almacen->empresas->telefono;?></span>
                      
                       
                   </li>
                   <li>
                     
                            <span class="name">Correo Electrónico:</span>
                            <span class="value"><?php //echo $model->almacen->users->email;?></span>
                       
                   </li>
                   
                   
               </ul>
                
               
                
                
               <!-- <p>
                    <span class="name">Dirección de Envío:</span>
                    <span class="value">Edif. Los Mirtos, Piso 3 Oficina 3 San Cristóbal Edo. Táchira</span>
               </p> -->
                
               
            </div>
        </div>
        <div class="separator margin_top_small margin_bottom_small"></div>
        
        <div class=" orderActions no_horizontal_padding margin_top_small">
            <h4 class="margin_top_small">Acciones pendientes</h4>
            <table width="100%" class="table-striped" id="tabla">
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
        
        
        
        
        
    </div>
    
    
    
</div>

