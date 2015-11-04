<div class="row-fluid clearfix stats">
   <?php if(Yii::app()->authManager->checkAccess("vendedor", Yii::app()->user->id) || Yii::app()->authManager->checkAccess("comprador", Yii::app()->user->id)):?>

        <div class="col-md-2 stat no_left_padding">
            <span class="value"><?php 
            if(Yii::app()->authManager->checkAccess("vendedor", Yii::app()->user->id))
				echo $totaAprobadaVendidas+$totaRechazadasVendidas+$totaPendienteVendidas;
			else 
				echo $totaAprobadaCompra+$totaRechazadasCompra+$totaPendienteCompra;	
            ?></span>
            <span class="legend">  Ordenes</span>            
        </div>
        
        <div class="col-md-2 stat no_left_padding">
            <span class="value"><?php 
            if(Yii::app()->authManager->checkAccess("vendedor", Yii::app()->user->id))
				echo $totaAprobadaVendidas;
			else 
				echo $totaAprobadaCompra;	
            ?>
            </span>
            <span class="legend">Ordenes Aprobadas</span>            
        </div>
        
        <div class="col-md-2 stat no_left_padding">
            <span class="value"><?php 
            if(Yii::app()->authManager->checkAccess("vendedor", Yii::app()->user->id))
				echo $totaRechazadasVendidas;
			else 
				echo $totaRechazadasCompra;	
            ?></span>
            <span class="legend">Ordenes Rechazadas</span>            
        </div>
        
         <div class="col-md-2 stat no_left_padding">
            <span class="value"><?php 
            if(Yii::app()->authManager->checkAccess("vendedor", Yii::app()->user->id))
				echo $totaPendienteVendidas;
			else 
				echo $totaPendienteCompra;	
            ?></span>
            <span class="legend">Ordenes Pendientes</span>            
        </div>
      <?php endif;?> 

      <?php if(Yii::app()->authManager->checkAccess("compraVenta", Yii::app()->user->id)): ?>
        <div class="col-md-8 no_right_padding">
        	  <div class="row-fluid clearfix stats"> 
		         <div class="col-md-2 stat no_left_padding">
		            <span class="value"><?php echo $totaAprobadaVendidas;?></span>
		            <span class="legend"> Ordenes Aprobadas para la Venta</span>            
		        </div>
		        <div class="col-md-2 stat no_left_padding">
		            <span class="value"><?php echo $totaRechazadasVendidas; ?></span>
		            <span class="legend"> Ordenes Rechazadas para la Venta</span>            
		        </div>
		        <div class="col-md-2 stat no_left_padding">
		            <span class="value"><?php echo $totaPendienteVendidas;?></span>
		            <span class="legend"> Ordenes Pendientes para la Venta</span>            
		        </div>
		        
		         <div class="col-md-2 stat no_left_padding">
		            <span class="value"><?php echo $totaAprobadaCompra;?></span>
		            <span class="legend"> Ordenes Aprobadas para la Compra</span>            
		        </div>
		        <div class="col-md-2 stat no_left_padding">
		            <span class="value"><?php echo $totaRechazadasCompra;?></span>
		            <span class="legend"> Ordenes Rechazadas para la Compra</span>            
		        </div>
		        <div class="col-md-2 stat no_left_padding">
		            <span class="value"><?php echo $totaPendienteCompra;?></span>
		            <span class="legend"> Ordenes Pendientes para la Compra</span>            
		        </div>
		 </div>      
    </div>  
      <?php endif;?> 
      
      
        <?php if(Yii::app()->authManager->checkAccess("comprador", Yii::app()->user->id) || Yii::app()->authManager->checkAccess("compraVenta", Yii::app()->user->id)):?>
      	<div class="col-md-1 stat no_left_padding">
            <span class="value"><?php echo $producComprados;?></span>
            <span class="legend">Productos Comprados</span>            
        </div>
      <?php endif;?>
      
       <?php if(Yii::app()->authManager->checkAccess("vendedor", Yii::app()->user->id) || Yii::app()->authManager->checkAccess("compraVenta", Yii::app()->user->id)):?>
      	<div class="col-md-1 stat">
            <span class="value"><?php echo $producInventario;?></span>
            <span class="legend">Productos en Inventario</span>            
        </div>
      <?php endif;?>     
      
      
    </div>
    
