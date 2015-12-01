<?php $this->breadcrumbs=array('Mis Ventas'=>'misVentas','Orden #'.$model->id); ?> 
<div id="orderDetail" class="row-fluid margin_top">
    <h2>INTENCION DE COMPRA</h2>
    <div class="col-md-6 orderInfo no_horizontal_padding margin_top_small">

       <div class="row-fluid clearfix" >        
           <div class="col-md-6 padding_bottom_small" style="border:1px solid #CCC">
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
        
        <?php
        if($model->estado==0)
        {
            echo CHtml::submitButton('Aceptar', array('id'=>'aceptar','name'=>$model->id,'class'=>'btn-orange btn btn-danger btn-large orange_border margin_left')); 
            echo CHtml::submitButton('Cancelar', array('id'=>'cancelar','name'=>$model->id,'class'=>'btn-orange btn btn-danger btn-large orange_border margin_left')); 
        }
        ?>
           </div>
       </div>
   
      
      

        <div class="margin_top sellerInfo">
            <p>
                <span class="name">Información del Comprador</span>
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
                <span class="name">Empresa:</span>
                <span class="value"><?php echo $model->empresa->razon_social;?></span>
            </p>
            <p>
                <span class="name">RIF:</span>
                <span class="value"><?php echo $model->empresa->rif;?></span>
            </p>
           <!-- <p>
                <span class="name">Dirección de Envío:</span>
                <span class="value">Edif. Los Mirtos, Piso 3 Oficina 3 San Cristóbal Edo. Táchira</span>
           </p> -->
            <p>
                <span class="name">Teléfono:</span>
                <span class="value"><?php echo $model->empresa->telefono;?></span>
            </p>
           <p>
                <span class="name">Correo Electrónico:</span>
                <span class="value"><?php echo $model->users->email;?></span>
           </p>
        </div>
    </div>
    
    <div class="col-md-6 orderActions no_horizontal_padding margin_top_small">
        <h3 class="margin_top_small">Acciones pendientes</h3>
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
    
    
    
</div>
<script>
		$(document).ready(function() {
			$('#aceptar').click(function() {
				var id=$(this).attr("name");
				var estado=1;
				cambio(id, estado);

			});
			
			$('#cancelar').click(function() {
				var id=$(this).attr("name");
				var estado=2;
				cambio(id, estado);

			});
			
			function cambio(id, estado)
			{
					$.ajax({
			         url: "<?php echo Yii::app()->createUrl('Orden/cambiarEstado') ?>",
		             type: 'POST',
			         data:{
		                    id:id, estado:estado
		                   },
			        success: function (data) {
			        	
			        	$('#aceptar').hide();
			        	$('#cancelar').hide();
			        	var user="<?php echo User::model()->FindByPk(Yii::app()->user->id)->profile->first_name." ".User::model()->FindByPk(Yii::app()->user->id)->profile->last_name;?>";     	 
			        	var fecha="<?php $date = date_create(date("Y-m-d H:i:s"));echo date_format($date, 'd/m/Y H:i:s');?>" ; 
			        	if(data==1)
			        	{
			        		$('#estado').addClass('aceptado');
			        		$('#estado').html('Aceptada');
			        		var variable="Aprobada";

			        			
			        	}else
			        	{
				        	$('#estado').addClass('rechazado');
				        	$('#estado').html('Rechazada');
				        	var variable="Rechazada";
			        	}
						$('#tabla').append('<tr> <td> '+variable+' </td> <td>'+user+' </td> <td>'+fecha+' </td> </tr>');

			       	}
			    })
			}
		
		});

</script>
