<style>
.btn-separator:after {
    content: ' ';
    display: block;
    float: left;
    background: #ff5b0b!important;
    margin: 0 10px;
    height: 86px;
    width: 1px;
}
</style>
<div class="row-fluid clearfix stats">
   <?php if(Yii::app()->authManager->checkAccess("vendedor", $identificador) || Yii::app()->authManager->checkAccess("comprador", $identificador)):?>

        <div class="col-md-2 stat no_left_padding">
            <span class="value"><?php 
            if(Yii::app()->authManager->checkAccess("vendedor", $identificador))
            {
              echo $totaAprobadaVendidas+$totaRechazadasVendidas+$totaPendienteVendidas;
              $mensaje="Ordenes";
            }
			     else
           {
              echo $totaAprobadaCompra+$totaRechazadasCompra+$totaPendienteCompra;
              $mensaje="Pedidos";  
           } 	
            ?></span>
            <span class="legend"><?php echo $mensaje;?></span>            
        </div>
        
        <div class="col-md-2 stat no_left_padding">
            <span class="value"><?php 
            if(Yii::app()->authManager->checkAccess("vendedor", $identificador))
            {
              echo $totaAprobadaVendidas;
              $mensaje="Ordenes Aprobadas";
            }
			     else
           {
             echo $totaAprobadaCompra;
             $mensaje="Pedidos Aprobados";  
           } 
            ?>
            </span>
            <span class="legend"><?php echo $mensaje;?></span>              
        </div>
        
        <div class="col-md-2 stat no_left_padding">
            <span class="value"><?php 

            if(Yii::app()->authManager->checkAccess("vendedor", $identificador))
            {
                echo $totaRechazadasVendidas;
                $mensaje="Ordenes Rechazadas";
            }
			     else
           {
                echo $totaRechazadasCompra;
                $mensaje="Pedidos Rechazados"; 
           } 
            ?></span>
            <span class="legend"><?php echo $mensaje;?></span>           
        </div>
        
         <div class="col-md-2 stat no_left_padding">
            <span class="value"><?php 
            if(Yii::app()->authManager->checkAccess("vendedor", $identificador))
            {
              echo $totaPendienteVendidas;
              $mensaje="Ordenes Pendientes";
            }
      			else
            {
              echo $totaPendienteCompra;
              $mensaje="Pedidos Pendientes";
            } 
            ?></span>
             <span class="legend"><?php echo $mensaje;?></span>            
        </div>
      <?php endif;?> 

      <?php if(Yii::app()->authManager->checkAccess("compraVenta", $identificador)): ?>
        <div class="col-md-9 no_right_padding">
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
		        <span class="btn-separator hidden-xs hidden-sm"></span>

		         <div class="col-md-2 stat no_left_padding">
		            <span class="value"><?php echo $totaAprobadaCompra;?></span>
		            <span class="legend"> Pedidos Aprobados para la compra</span>            
		        </div>
		        <div class="col-md-2 stat no_left_padding">
		            <span class="value"><?php echo $totaRechazadasCompra;?></span>
		            <span class="legend"> Pedidos Rechazados para la Compra</span>            
		        </div>
		        <div class="col-md-1 stat no_left_padding">
		            <span class="value"><?php echo $totaPendienteCompra;?></span>
		            <span class="legend"> Pedidos Pendientes para la Compra</span>            
		        </div>
		 </div>      
    </div>  
      <?php endif;?> 
      
      
        <?php if(Yii::app()->authManager->checkAccess("comprador", $identificador) || Yii::app()->authManager->checkAccess("compraVenta", $identificador)):?>
      	<div class="col-md-1 stat no_left_padding">
            <span class="value"><?php if($producComprados=="")echo "0"; else echo $producComprados;?></span>
            <span class="legend">Productos Comprados</span>            
        </div>
      <?php endif;?>
      
       <?php if(Yii::app()->authManager->checkAccess("vendedor", $identificador) || Yii::app()->authManager->checkAccess("compraVenta", $identificador)):?>
      	<div class="col-md-1 stat">
            <span class="value"><?php if($totalProduc=="")echo "0"; else echo $totalProduc;?></span>
            <span class="legend">Productos en Inventario</span>            
        </div>
      <?php endif;?>  
             <?php if(Yii::app()->authManager->checkAccess("vendedor", $identificador) || Yii::app()->authManager->checkAccess("compraVenta", $identificador)):?>
        <div class="col-md-1 stat">
            <span class="value"><?php if($producInventario=="")echo "0"; else echo $producInventario;?></span>
            <span class="legend">Unidades en Inventario</span>            
        </div>
      <?php endif;?>     
      
      
    </div>
    
