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

        	<div class="bg_color3 margin_bottom_small padding_small">
        		<div class="col-md-3">Ventas totales: <?php echo Yii::app()->numberFormatter->formatDecimal($sumatoria); ?> Bs.</div>
        		<div class="col-md-3">Usuarios registrados: <?php echo $usuarios; ?></div>
        		<div class="col-md-3">Promedio de venta: <?php echo Yii::app()->numberFormatter->formatDecimal($promedio); ?> Bs/Venta.</div>
        		<div class="col-md-3">Productos activos: <?php echo $productos_activos; ?></div>
        	</div>
	      
    	<div class="row">
        	<div class="col-lg-12 margin_top">
         		<div class="well"> 
					<h4>Últimas compras</h4>
					<hr class="no_margin_top" />
					<table class="table-striped table">
			    		<tr>
			    			<td>Cliente</td>
			    			<td>Estado</td>
			    			<td>Fecha</td>
			    			<td>Envio</td>
			    			<td>Total</td>
			    		</tr>
			    		<?php $ultimas_compras = Orden::model()->getLast();

			    		foreach($ultimas_compras as $orden){
			    			echo "<tr>";
			    			echo "<td>".$orden->users->profile->first_name." ".$orden->users->profile->last_name."</td>";
			    			echo $orden->getStatus($orden->estado);
			    			echo "<td>".date('d-m-Y',strtotime($orden->fecha))."</td>";
			    			echo "<td>".$orden->envio." Bs.</td>";
			    			echo "<td>".$orden->total." Bs.</td>";
			    			echo "</tr>";
			    		}
			    		?>
			    	</table>
				</div>

				<div class="well">
			    	<h4>Ultimos usuarios registrados</h4>
			    	<hr class="no_margin_top" />
			    	<table class="table-striped table">
			    		<tr>
			    			<td>Nombre</td>
			    			<td>Email</td>
			    			<td>Fecha de registro</td>
			    			<td>Estado</td>
			    		</tr>
			    		<?php $ultimos_usuarios = User::model()->getLast();

			    		foreach($ultimos_usuarios as $users){
			    			echo "<tr>";
			    			echo "<td>".$users->profile->first_name." ".$users->profile->last_name."</td>";
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
				</div>

				<div class="well">
			    	<h4>Ultimos productos añadidos</h4>
			    	<hr class="no_margin_top" />
			    	<table class="table-striped table">
			    		<tr>
			    			<td>Nombre</td>
			    			<td>Marca</td>
			    			<td>Destacado</td>
			    			<td>Precio</td>
			    			<td>Cantidad</td>
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
  
</div>
<!-- /container -->
