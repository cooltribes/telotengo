<style>
.reducirNombre{font-size:20px;}
</style>
<?php 
if(!Yii::app()->user->isAdmin())
  $this->breadcrumbs=array('Mis Compras'=>Yii::app()->createUrl('orden/misCompras'),'Orden #'.$model->id); 
else
  $this->breadcrumbs=array('Ordenes'=>Yii::app()->createUrl('orden/admin'),'Orden #'.$model->id);   
?> 
<div id="orderDetail" class="row-fluid margin_top">
    <h2>INTENCION DE COMPRA</h2>
    
    

    <div class="col-md-8 cart no_horizontal_padding margin_top_small">
        <div class="orderContainer margin_bottom">
                <div class="title clearfix"> 
                   <div class="row-fluid">
                      <div class="col-md-10 no_horizontal_padding reducirNombre"><?php echo $model->almacen->empresas->razon_social;?></div>
                      <div class="col-md-2 no_horizontal_padding text-right">ORDEN #<?php echo $model->id;?></div>
                   </div>
                </div>
                <div class="detail padding_left_xsmall padding_right_xsmall">
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
                              <!--   <th class="text-center">I. V. A.</th>
                                  <th class="text-center">Precio Total</th> -->
                               
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
                                <td class="number"><?php $precio=$proc->monto; echo Funciones::formatPrecio($precio);?></td>
                                <td class="number highlighted"><?php $sub=$precio*$cantidad; echo Funciones::formatPrecio($sub); ?></td>
                                <?php /*
                                <td class="number"><?php $iva=$precio*$cantidad*Yii::app()->params['IVA']['value']; echo Funciones::formatPrecio($iva);?></td>
                                <td class="number highlighted"><?php $tota=$sub+$iva; echo Funciones::formatPrecio($tota);?></td> 
                                 $iva=$precio*$cantidad*Yii::app()->params['IVA']['value'];
                                 $tota=$sub+$iva;
                                 $acumulado+=$tota; */
                                 $acumulado+=$sub; ?>
                                
                            </tr>
                            <?php endforeach;  ?>
                            
                       </tbody>
                    </table>
                </div>
               

                <div class="summary text-right">
                    
                    <span id="SubTotal">SubTotal: <?php echo Funciones::formatPrecio($acumulado);?></span><br>
                    <span id="total">IVA: <?php $iva=$acumulado*Yii::app()->params['IVA']['value']; echo Funciones::formatPrecio($iva);?></span><br>
                    <span id="total">Total: <?php echo Funciones::formatPrecio($acumulado+$iva);?></span>
                   
                </div>
            </div>
    </div>
    
    
    <div class="col-md-4 margin_top_small">
        
        <div class="orderInfo no_horizontal_padding ">

          
           <div class="padding_left" style="border:1px solid #CCC">
                   <h4 class="margin_top_small">Estado actual </h4>
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
        </div>
       
            <div class="margin_top sellerInfo">
   
                    <h3>Información del Vendedor</h3>
          
               <ul>
               <?php 
                  if(!Yii::app()->user->isAdmin()): ?>
                     <li>
                              <span class="name">Fecha de Emisión:</span>
                              <span class="value"><?php $date = date_create($model->fecha);echo date_format($date, 'd/m/Y H:i:s');?></span>
                     </li>
                  <?php
                  endif; ?> 
                   <li>
                            <span class="name">Empresa:</span>
                            <span class="value"><?php echo $model->almacen->empresas->razon_social;?></span>
                   </li>
                   <li>
                            <span class="name">Almacen:</span>
                            <span class="value"><?php echo $model->almacen->alias;?></span>
                   </li>
                  <li>
                            <span class="name">Estado:</span>
                            <span class="value"><?php echo $model->almacen->provincia->nombre;?></span>
                   </li>
                  <li>
                            <span class="name">Ciudad:</span>
                            <span class="value"><?php echo $model->almacen->ciudad->nombre;?></span>
                   </li>
                   <li>
                            <span class="name">Direccion:</span>
                            <span class="value"><?php echo $model->almacen->ubicacion;?></span>
                   </li>
                   <li>
                            <span class="name">RIF:</span>
                            <span class="value"><?php echo $model->almacen->empresas->rif;?></span>                   
                   </li>
                   <li>
                            <span class="name">Teléfono:</span>
                            <span class="value"><?php echo $model->almacen->empresas->telefono;?></span>                       
                   </li>
                   <?php 
                   if(!$model->estado==0):
                   ?>
                       <li>
                               <span class="name"><?php if($model->estado==1)echo"Aprobado por:";else echo"Rechazado por:"?></span>
                               <span class="value"><?php echo Profile::model()->retornarNombreCompleto($model->vendedor->id);?></span>  
                       </li>

                      <li>
                               <span class="name">Correo Electrónico:</span>
                               <span class="value"><?php echo $model->vendedor->email;?></span>
                       </li>
                   <?php 
                   endif;
                   ?>
                   
               </ul>
              <?php 
                if(Yii::app()->user->isAdmin()): ?>
                    <br>
                      <h3>Información del Comprador</h3>
            
                 <ul>

                     <li>
                              <span class="name">Fecha de Emisión:</span>
                              <span class="value"><?php $date = date_create($model->fecha);echo date_format($date, 'd/m/Y H:i:s');?></span>  
                     </li>
                     <li>
                              <span class="name">Empresa:</span>
                              <span class="value"><?php echo $model->empresa->razon_social;?></span>
                     </li>
                     <li>
                              <span class="name">Estado:</span>
                              <span class="value"><?php echo $model->empresa->city->provincia->nombre;?></span>
                     </li>
                    <li>
                              <span class="name">Ciudad:</span>
                              <span class="value"><?php echo $model->empresa->city->nombre;?></span>
                     </li>
                     <li>
                              <span class="name">Direccion:</span>
                              <span class="value"><?php echo $model->empresa->direccion;?></span>
                     </li>
                     <li>
                              <span class="name">RIF:</span>
                              <span class="value"><?php echo $model->empresa->rif;?></span>
                     </li>
                     <li>
                              <span class="name">Teléfono:</span>
                              <span class="value"><?php echo $model->empresa->telefono;?></span> 
                     </li>
                     <li>
                              <span class="name">Generado por</span>
                              <span class="value"><?php echo Profile::model()->retornarNombreCompleto($model->users->id);?></span>  
                     </li>
                      <li>
                            <span class="name">Correo Electrónico:</span>
                            <span class="value"><?php echo $model->users->email;?></span>  
                   </li>
                     
                     
                 </ul>


                <?php
                endif; ?>

               <!-- <p>
                    <span class="name">Dirección de Envío:</span>
                    <span class="value">Edif. Los Mirtos, Piso 3 Oficina 3 San Cristóbal Edo. Táchira</span>
               </p> -->
                
               
            </div>
        </div>
        <div class="separator margin_top_small margin_bottom_small"></div>
        
        <div class=" orderActions no_horizontal_padding margin_top_small">
            <h4 class="margin_top_small">Acciones</h4>
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

