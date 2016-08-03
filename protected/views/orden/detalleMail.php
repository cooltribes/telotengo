<div id="orderDetail" class="row-fluid" style="font-size:14px;">
    <h2 style="font-size: 22px; font-weight: bolder; margin: 20px 0;">Detalle de la solicitud</h2>
    <div class="col-md-7 orderInfo no_horizontal_padding">

        <div class="margin_top sellerInfo" style="font-size: 14px;">
            <table width="60%">
                 <colgroup>
                        <col width="20%">
                        <col width="20%">
                        <col width="30%">
                        <col width="30%">                     
                 </colgroup>
                 <tr>
                    <td colspan="4" align="left" style="font-weight: 900; padding:5px 10px;">Estado</td>
                 </tr> 
                 <tr><td colspan="4" align="left" style="font-weight: 900; padding:5px 10px;">
                        <?php 
                                switch($model->estado){
                                    case 0:
                                        echo "<span style='color:#f4a611; font-size: 16px;'>Pendiente</span>";
                                    break;
                                    case 1:
                                        echo "<span style='color:#3ca13c; font-size: 16px;'>Aprobada</span>";
                                    break;
                                    case 2:
                                        echo "<span style='color:#ea2424; font-size: 16px;'>Rechazada</span>";
                                    break;
                                    default:
                                        echo " N/D ";
                                    break;
                                    
                                }
                        ?>
                    </td>                    
                </tr>                
                 
                <tr>
                    <td colspan="2" align="left" style="font-weight: 900; padding:5px 10px;">N° de Orden</td>
                    <td colspan="2" align="left" style="font-weight: 900; padding:5px 10px;">Fecha de emisión</td>                    
                </tr>
                
                <tr>
                    <td colspan="2" align="left" style="padding:2px 10px;"><?php echo $model->id;?></td>
                    <td colspan="2" align="left" style="padding:2px 10px;"><?php echo date_format(date_create($model->fecha), 'd/m/Y H:i:s');?></td>                    
                </tr>
                <tr>
                    <td colspan="4" style="font-weight: 900; padding:8px 10px; text-transform: uppercase; text-decoration: underline">Información del <?php echo $infoFrom ?></td>
                </tr
                <tr>
                    <td colspan="2" align="left" style="font-weight: 900; padding:5px 10px;">Razón Social</td>
                    <td align="left" style="font-weight: 900; padding:5px 10px;">RIF</td> 
                    <td align="left" style="font-weight: 900; padding:5px 10px;">Teléfono</td> 
               
                </tr>
            <?php if($infoFrom=="Vendedor"): ?>
                <tr>
                    <td colspan="2" align="left" style="padding:5px 10px;"><?php echo $model->almacen->empresas->razon_social;?></td>
                    <td align="left" style="padding:2px 10px;"><?php echo $model->almacen->empresas->rif;?></td>   
                    <td align="left" style="padding:2px 10px;"><?php echo $model->almacen->empresas->telefono;?></td>                    
                </tr>
             <?php endif; ?>  
              <?php if($infoFrom=="Comprador"): ?>
                <tr>
                    <td colspan="2" align="left" style="padding:5px 10px;"><?php echo $model->empresa->razon_social;?></td>
                    <td align="left" style="padding:2px 10px;"><?php echo $model->empresa->rif;?></td>   
                    <td align="left" style="padding:2px 10px;"><?php echo $model->empresa->telefono;?></td>                    
                </tr>
             <?php endif; ?>  
            </table>
            
            
        </div>
    </div>

    <div class="col-md-12 cart no_horizontal_padding">
        <div class="orderContainer" style="margin-top: 4.68em!important; margin-bottom: 2.18em!important;">
                <div style="border: solid 1px #666; font-size: 21px; padding: 10px 5%">
                   <div style="width:100%; height:30px; line-height:30px; vertical-align:middle">
                      <div style="width:50%; float:left">ORDEN #<?php echo $model->id;?></div>
                      <div style="width:50%; float:left; text-align:right"><?php echo $model->almacen->empresas->razon_social;?></div>
                   </div>
                </div>
                <div style="border-left: solid 1px #666; border-right: solid 1px #666; padding: 10px 5%;">
                    <table width="100%" style="font-size: 14px; color: #222; max-width:100%">
                        <colgroup>
                        <col width="10%">
                        <col width="30%">
                        <col width="10%">
                        <col width="10%">
                        <col width="10%">
                        <col width="10%">
                        <col width="10%">
                        <col width="10%">
                        </colgroup>
                       <thead>
                            <tr>
                                <th colspan="2" style="background-color: #000; color: #FFF; padding-top: 12px; padding-bottom: 12px;">Producto</th>
                                <th style="background-color: #000; color: #FFF; padding-top: 12px; padding-bottom: 12px; text-align:center">Codigo TLT</th>
                                <th style="background-color: #000; color: #FFF; padding-top: 12px; padding-bottom: 12px; text-align:center" class="text-center">Cantidad</th>
                                <th style="background-color: #000; color: #FFF; padding-top: 12px; padding-bottom: 12px; text-align:center" class="text-center">Precio Unt.</th>
                                <th style="background-color: #000; color: #FFF; padding-top: 12px; padding-bottom: 12px; text-align:center" class="text-center">Sub Total</th>
                               <!--  <th style="background-color: #000; color: #FFF; padding-top: 12px; padding-bottom: 12px; text-align:center" class="text-center">I. V. A.</th>
                                  <th style="background-color: #000; color: #FFF; padding-top: 12px; padding-bottom: 12px; text-align:center" class="text-center">Precio Total</th> -->
                               
                            </tr>
                        </thead>
                        
                        <tbody>
                        	
                        	<?php 
                        	$acumulado=0;
                        	foreach($productoOrden as $proc):
                        	$imagenPrincipal=Imagenes::model()->findByAttributes(array('producto_id'=>$proc->inventario->producto->id, 'orden'=>1));
                        	?>
                             <tr>
                             	<td style="text-align: center; font-weight: bolder; font-size: 12px; color: #222; padding-top: 12px; padding-bottom: 12px;"><img width="100%" src="<?php echo Yii::app()->getBaseUrl(true).$imagenPrincipal->url;?>"/></td> 
                                <td style="font-weight: 900; padding: 0 10px; padding-top: 12px; padding-bottom: 12px;"> <?php echo $proc->inventario->producto->nombre;?></td>
                                <td style="text-align: center; font-weight: bolder; padding-top: 12px; padding-bottom: 12px;"><?php echo $proc->inventario->producto->tlt_codigo;?></td>
                                <td style="text-align: center; font-weight: bolder; padding-top: 12px; padding-bottom: 12px;"><?php echo $cantidad=$proc->cantidad;?></td>
                                <td style="text-align: center; font-weight: bolder; padding-top: 12px; padding-bottom: 12px;"><?php echo Funciones::formatPrecio($precio=$proc->inventario->precio);?></td>
                                <td style="text-align: center; font-weight: bolder; padding-top: 12px; padding-bottom: 12px; color: #ec1f24;"><?php echo Funciones::formatPrecio($sub=$precio*$cantidad); ?></td>
                                <?php /*
                                <td style="text-align: center; font-weight: bolder; padding-top: 12px; padding-bottom: 12px; color: #ec1f24;"><?php echo Funciones::formatPrecio($iva=$precio*$cantidad*0.12);?></td>
                                <td style="text-align: center; font-weight: bolder; padding-top: 12px; padding-bottom: 12px; color: #ec1f24;"><?php echo Funciones::formatPrecio($tota=$sub+$iva);?></td>
                                 <?php $acumulado+=$tota; */
                                        $acumulado+=$sub;?>
                                
                            </tr>
                            <?php endforeach;  ?>
                            
                       </tbody>
                    </table>
                </div>
               

                <div class="summary text-right" style="text-align: right; border: solid 1px #666; height:30px; line-height:30px; vertical-align:middle; padding: 10px 5%">
                    
                    <span id="total" style="font-size: 20px; font-weight: bolder;">SubTotal: <?php echo Funciones::formatPrecio($acumulado);?></span><br>
                    <span id="total" style="font-size: 20px; font-weight: bolder;">IVA: <?php $iva=$acumulado*Yii::app()->params['IVA']['value']; echo Funciones::formatPrecio($iva);?></span><br>
                    <span id="total" style="font-size: 20px; font-weight: bolder;">Total: <?php echo Funciones::formatPrecio($acumulado+$iva);?></span>
                   
                </div>
            </div>
    </div>
    
    
    
</div>

