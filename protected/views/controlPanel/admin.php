<?php
 
$this->breadcrumbs=array(
	'Panel de Control',
);

$usuarios = User::model()->count();
$productos_activos = Producto::model()->countByAttributes(array('estado'=>1));
$ordenes = Orden::model()->findAll();
$sumatoria = 0;
$ventas = 0;
	
	foreach($ordenes as $orden){
		if($orden->estado != 5){
			$sumatoria = $sumatoria + $orden->total;
			$ventas++;
		}	
	}

if($sumatoria != 0)
	$promedio = $sumatoria / $ventas;
else
	$promedio = 0;
?>
<div class="container">
	<h1>Panel de Control</h1>
  	<div class="row-fluid">
    	<div class="col-lg-12">

    		<?php if(Yii::app()->user->hasFlash('success')){?>
			    <div class="alert in alert-block fade alert-success text_align_center">
			        <?php echo Yii::app()->user->getFlash('success'); ?>
			    </div>
			<?php } ?>
			<?php if(Yii::app()->user->hasFlash('error')){?>
			    <div class="alert in alert-block fade alert-danger text_align_center">
			        <?php echo Yii::app()->user->getFlash('error'); ?>
			    </div>
			<?php } ?>
                
        	<div class="row-fluid">
        	    
        	    
        	           <div class="col-md-2 text-right">
        	               <h3 class="no_margin_bottom"><?php echo $usuarios; ?></h3>
        	               <h4>Usuarios registrados</h4>
        	           </div>
        	           <div class="col-md-2 text-right">
                           <h3 class="no_margin_bottom"><?php echo $ventas ?></h3>
                           <h4>Ventas Registradas</h4>
                       </div>
                       <div class="col-md-2 text-right">
                           <h3 class="no_margin_bottom"><?php echo Yii::app()->numberFormatter->formatDecimal($sumatoria); ?><small> Bs</small></h3>
                           <h4>Total Vendido</h4>
                       </div>
                       <div class="col-md-3 text-right">
                           <h3 class="no_margin_bottom"><?php echo Yii::app()->numberFormatter->formatDecimal($promedio); ?><small> Bs/Venta</small></h3>
                           <h4>Promedio de venta</h4>
                       </div>
                       <div class="col-md-2 text-right">
                            <h3 class="no_margin_bottom"><?php echo $productos_activos; ?></h3>
                            <h4>Productos activos</h4>
                       </div>
        	            
        	            
        	            
        	                 	            
        	            
        	           
          	       
                  
                       
                        
                                                
                        
                      
           
            </div>
	      
    	<div class="row">
        	<div class="col-lg-12 margin_top">
         		
					<h4 class="margin_top">Últimas compras</h4>
					<hr class="margin_top_xsmall_minus"/>

					<table class="table-striped table">
			    		<tr>
			    			<td class="no_border bg_white no_padding_bottom"><b>Cliente</b></td>
			    			<td class="no_border bg_white no_padding_bottom"><b>Estado</b></td>
			    			<td class="no_border bg_white no_padding_bottom"><b>Fecha</b></td>
			    			<td class="no_border bg_white no_padding_bottom"><b>Envio</b></td>
			    			<td class="no_border bg_white no_padding_bottom"><b>Total</b></td>
			    		</tr>
			    		<?php $ultimas_compras = Orden::model()->getLast();

			    		foreach($ultimas_compras as $orden){
			    			echo "<tr>";
			    			echo "<td><a href='".Yii::app()->baseUrl."/orden/detalle/".$orden->id."'>".$orden->users->profile->first_name." ".$orden->users->profile->last_name."</a></td>";
			    			echo $orden->getStatus($orden->estado);
			    			echo "<td>".date('d-m-Y',strtotime($orden->fecha))."</td>";
			    			echo "<td>".$orden->envio." Bs.</td>";
			    			echo "<td>".$orden->total." Bs.</td>";
			    			echo "</tr>";
			    		}
			    		?>
			    	</table>
			

			
			    	<h4 class="margin_top">Ultimos usuarios registrados</h4>
			    	<hr class="margin_top_xsmall_minus"/>
	
			    	<table class="table-striped table">
			    		<tr>
			    			<td class="no_border bg_white no_padding_bottom"><b>Nombre</b></td>
			    			<td class="no_border bg_white no_padding_bottom"><b>Email</b></td>
			    			<td class="no_border bg_white no_padding_bottom"><b>Fecha de registro</b></td>
			    			<td class="no_border bg_white no_padding_bottom"><b>Estado</b></td>
			    		</tr>
			    		<?php $ultimos_usuarios = User::model()->getLast();

			    		foreach($ultimos_usuarios as $users){
			    			echo "<tr>";
	echo "<td><a href='".Yii::app()->baseUrl."/user/profile/profile/id/".$users->id."'>".$users->profile->first_name." ".$users->profile->last_name."</a></td>";
			    			echo "<td>".$users->email."</td>";
			    			echo "<td>".date('d-m-Y',strtotime($users->create_at))."</td>";
			    			echo "<td>";
								switch ($users->status) {
									case User::STATUS_NOACTIVE:
										echo 'Inactivo';
										break;
									case User::STATUS_ACTIVE:
										echo 'Activo';
										break;
									case User::STATUS_BANNED:
										echo 'Suspendido';
										break;
									default:
										echo 'Desconocido';
										break;
								}
							echo "</td>";
			    			echo "</tr>";
			    		}
			    		?>
			    	</table>
			

			    	<h4 class="margin_top">Ultimos productos añadidos</h4>
			    	<hr class="margin_top_xsmall_minus"/>
			    	<table class="table-striped table">
			    		<tr>
			    			<td class="no_border bg_white no_padding_bottom"><b>Nombre</b></td>
			    			<td class="no_border bg_white no_padding_bottom"><b>Marca</b></td>
			    			<td class="no_border bg_white no_padding_bottom"><b>Destacado</b></td>
			    			<td class="no_border bg_white no_padding_bottom"><b>Precio</b></td>
			    			<td class="no_border bg_white no_padding_bottom"><b>Cantidad</b></td>
			    		</tr>
			    		<?php $ultimos_productos = Producto::model()->getLast();

			    		foreach($ultimos_productos as $producto){
			    			echo "<tr>";
			    			echo "<td><a href='".$producto->getUrl()."'>".$producto->nombre."</a></td>";
			    			echo "<td>".$producto->marca->nombre."</td>";
			    			echo $producto->destacado == 0 ? "<td> No </td>" : "<td> Si </td>" ;
			    			echo "<td>".$producto->inventarios->precio." Bs.</td>";
			    			echo "<td>".$producto->inventarios->cantidad."</td>";
			    			echo "</tr>";
			    		}
			    		?>

			    	</table>
		

		</div>
      </div>
    </div>
  </div>
  
</div>
<!-- /container -->
