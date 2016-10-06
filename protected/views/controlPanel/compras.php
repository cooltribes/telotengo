<style>
.naranja{background-color: #ff5b0b;}
.bolder{font-weight:bolder;}
.arriba{margin-top: -17px;}
</style>
<?php
$this->breadcrumbs=array(
  'Panel de Control',
);
?>


<div class="container-fluid">   
  <div>
  <h1 class="margin_bottom_medium">Panel de control de Pedidos</h1>
  <ul id="myTabs" class="nav nav-tabs margin_bottom" role="tablist">
      <li role="presentation" class=""><a href="<?php echo Yii::app()->baseUrl; ?>/user/admin/administrador">Miembros</a></li>
     <?php if(Yii::app()->authManager->checkAccess("comprador", Yii::app()->user->id) || Yii::app()->authManager->checkAccess("compraVenta", Yii::app()->user->id)): ?>
      <li role="presentation" class="active"><a href="<?php echo Yii::app()->baseUrl; ?>/controlPanel/compras">Compras</a></li>
  <?php endif;?>
    <?php if(Yii::app()->authManager->checkAccess("vendedor", Yii::app()->user->id) || Yii::app()->authManager->checkAccess("compraVenta", Yii::app()->user->id)): ?>
      <li role="presentation" class=""><a href="<?php echo Yii::app()->baseUrl; ?>/controlPanel/ventas">Ventas</a></li>
  <?php endif;?>
    </ul>
     <div class="clearfix stats">
         <div class="col-md-1 stat"> <!-- col-xs-1 stat -->
             <span class="value"><?php echo $todasOrdenes;?></span>
             <span class="legend">Totales</span>
         </div>
         <div class="col-md-1 stat">
                 <span class="value"><?php echo $todasOrdenesPendientes;?></span>
                 <span class="legend">Pendientes</span>
             </div>
         <div class="col-md-1 stat">
                 <span class="value"><?php echo $todasOrdenesRechazadas;?></span>
                 <span class="legend">Rechazados</span>
             </div>
             <div class="col-md-1 stat">
                 <span class="value"><?php echo $todasOrdenesAprobadas;?></span>
                 <span class="legend">Aprobados</span>
             </div>

     </div>  
 <hr>
  
  </div>
  
  <div class="row">
    <div class="col-md-6 col-md-offset-7 arriba">
​
      <form action="" class="form-inline">
        <div class="form-group">        
          <label class="control-label">Desde:</label>
              <input type="date" name="fechaIni" value="<?php echo $fechaIni;?>">
        </div>
        
        
        <div class="form-group">
          <label class="control-label">Hasta:</label>        
             <input type="date" name="fechaFinal" value="<?php echo $fechaFinal;?>">
        </div>
        <div class="form-group">
          <button type="submit" class="btn form-control btn-darkgray white naranja">Buscar</button>
        </div>
      </form> 
​
    </div>
  </div>
    
    
    
  <div class="charts-region">
   
    <h3 class="bolder">Pedidos registrados</h3>    
    <div class="row">
      <div class="col-md-11 col-md-offset-1">
​         <div id="ordenes"  style="width: 1000px;"></div>
      </div>      
    </div>
    <hr>
    
    <div class="row">    
      <div class="col-md-12">
          <h3 class="bolder col-md-6 chart_status col-md-offset3">Estadisticas</h3> 
​        <table class="table" width="100%" style="margin-top:69px;">
        <thead>
          <tr>
            <th>Metrica</th>
            <th>Valor</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Pedidos</td>
            <td><?php echo $todasOrdenes;?></td>
          </tr>
          <tr>
            <td>Promedio de productos por pedido</td>
            <td><?php  if($todasOrdenes>0){echo round($sumatoria/$todasOrdenes,2);}else {echo "0";} echo " Productos/Pedidos";?></td>
          </tr>
          <tr>
            <td>Valor medio de un pedido </td>
            <td><?php if($todasOrdenes>0){ echo Funciones::formatPrecio(round($sumatoriaMontos/$todasOrdenes,2), false);}else{echo "0";} echo " Bs"?></td>
          </tr>
          <tr>
            <td>Monto total de pedidos aprobados</td>
            <td><?php echo Funciones::formatPrecio($sumatoriaMontosAprobados, false); echo " Bs"?></td>
          </tr>
          <tr>
            <td>Monto total de pedidos rechazados</td>
            <td><?php echo Funciones::formatPrecio($sumatoriaMontosRechazados, false); echo " Bs"?></td>
          </tr>
          <tr>
            <td>Monto total de pedidos pendientes</td>
            <td><?php echo Funciones::formatPrecio($sumatoriaMontosPendientes, false); echo " Bs"?></td>
          </tr>
        </tbody>
      </table>
      </div>      
    </div>
​
    
  </div>
</div>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">

    google.charts.load('current', {'packages':['corechart']});

    google.charts.setOnLoadCallback(ordenes);


    function ordenes() 
    {
            var vectorOrdenAceptada=<?php echo json_encode($vectorOrdenAceptada);?>;
            var vectorOrdenPendiente=<?php echo json_encode($vectorOrdenPendiente);?>;
            var vectorOrdenCancelada=<?php echo json_encode($vectorOrdenCancelada);?>;
            var vectorFecha=<?php echo json_encode($vectorFecha);?>;
            var maxNumb=<?php echo $maxNumb;?>;

            var data = new google.visualization.DataTable();
        //data.addColumn('number', 'Usuarios');
        data.addColumn('string', 'Fecha');
        data.addColumn('number', 'Aprobado');
        data.addColumn('number', 'Pendiente');
        data.addColumn('number', 'Rechazado');

        for(i = 0; i < vectorFecha.length; i++)
          data.addRow([vectorFecha[i],vectorOrdenAceptada[i],vectorOrdenPendiente[i],vectorOrdenCancelada[i]]);

        if(maxNumb<4) // 4 es el numero minimo para que la grafica se vea bien
          maxNumb=4;

        var options = {
         // title: 'Usuarios',
          hAxis: {title: 'Fecha',  titleTextStyle: {color: '#333'}},
          vAxis: {title: 'Pedidos', minValue: 0, maxValue:maxNumb, format:'0'},
          legend: {position: 'top', alignment: 'center'},

        };

        var chart = new google.visualization.AreaChart(document.getElementById('ordenes'));
        chart.draw(data, options);
    }

</script>

