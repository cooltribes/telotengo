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
  <h1 class="orderTitle">PANEL DE CONTROL DE ÓRDENES Y PEDIDOS</h1>
  <hr>
     <div class="clearfix stats">
         <div class="col-md-1 stat"> <!-- col-xs-1 stat -->
             <span class="value"><?php echo $todasOrdenes;?></span>
             <span class="legend">Totales</span>
         </div>
         <div class="col-md-1 stat">
                 <span class="value"><?php echo Orden::model()->countByAttributes(array('estado'=>0))?></span>
                 <span class="legend">Pendientes</span>
             </div>
         <div class="col-md-1 stat">
                 <span class="value"><?php echo Orden::model()->countByAttributes(array('estado'=>2))?></span>
                 <span class="legend">Rechazadas</span>
             </div>
             <div class="col-md-1 stat">
                 <span class="value"><?php echo Orden::model()->countByAttributes(array('estado'=>1))?></span>
                 <span class="legend">Aprobadas</span>
             </div>

     </div>  

  
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
    <!--<hr>
    <h3 class="bolder">Empresas registradas</h3>  
    <div class="row">
      <div class="col-md-12 ">
​        <div id="empresas"  style="width: 1000px;"></div>
        <div class="row margin_top_small">
              <div class="col-md-2 col-md-offset-3">
                <label class="control-label">Interval</label>    

              </div>
              <div class="col-md-6 text-rigth">
                

                <div class="btn-group" data-toggle="buttons">
                  <label class="btn btn-default ">
                    <input type="radio" name="interval" id="option1" value="years" autocomplete="off"> Año
                  </label>
                  <label class="btn btn-default ">
                    <input type="radio" name="interval" id="option2" value="months" autocomplete="off"> Mes
                  </label> 
                  <label class="btn btn-default active">
                    <input type="radio" name="interval" id="option2" value="days" autocomplete="off" checked=""> Dia
                  </label>          
                </div>

              </div>
        </div>

      </div>
           
    </div>-->
    <hr>
    <h3 class="bolder">Ordenes registradas</h3>    
    <div class="row">
      <div class="col-md-11 col-md-offset-1">
​         <div id="ordenes"  style="width: 1000px;"></div>
      </div>      
    </div>
    <hr>
    <h3 class="bolder">Pedidos generados por tipo de usuario</h3>    
    <div class="row">
      <div class="col-md-11 col-md-offset-1">
​         <div id="ordenesUsuarios"  style="width: 1000px;"></div>
      </div>          
    </div>
    
    <hr>
    
    <div class="row">
      <div class="col-md-6 chart_status col-md-offset3 ">
        <h3 class="bolder" style="margin-left: 16px;">Tasa de abandono</h3>   
​         <div id="tasaAbandonoIntencionCompra" style="margin-top:-31px;"></div>
      </div>      
      <div class="col-md-6">
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
            <td>Órdenes generadas</td>
            <td><?php echo $todasOrdenes;?></td>
          </tr>
          <tr>
            <td>Promedio de productos por orden</td>
            <td><?php echo round($sumatoria/$todasOrdenes,2); echo " Productos/Orden";?></td>
          </tr>
          <tr>
            <td>Valor medio de una orden </td>
            <td><?php echo Funciones::formatPrecio(round($sumatoriaMontos/$todasOrdenes,2), false); echo " Bs"?></td>
          </tr>
          <tr>
            <td>Monto total de órdenes aprobadas</td>
            <td><?php echo Funciones::formatPrecio($sumatoriaMontosAprobados, false); echo " Bs"?></td>
          </tr>
          <tr>
            <td>Monto total de órdenes rechazadas</td>
            <td><?php echo Funciones::formatPrecio($sumatoriaMontosRechazados, false); echo " Bs"?></td>
          </tr>
          <tr>
            <td>Monto total de órdenes pendientes</td>
            <td><?php echo Funciones::formatPrecio($sumatoriaMontosPendientes, false); echo " Bs"?></td>
          </tr>
          <tr>
            <td>Tasa de conversión</td>
            <td><?php echo round($todasOrdenes*100/$totaVisitaCompradorVendedor_Comprador,2); echo " %";?></td>
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
    google.charts.setOnLoadCallback(ordenesUsuarios);
    google.charts.setOnLoadCallback(tasaAbandonoIntencionCompra);

  

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
        data.addColumn('number', 'Aprobada');
        data.addColumn('number', 'Pendiente');
        data.addColumn('number', 'Rechazada');

        for(i = 0; i < vectorFecha.length; i++)
          data.addRow([vectorFecha[i],vectorOrdenAceptada[i],vectorOrdenPendiente[i],vectorOrdenCancelada[i]]);

        if(maxNumb<4) // 4 es el numero minimo para que la grafica se vea bien
          maxNumb=4;

        var options = {
         // title: 'Usuarios',
          hAxis: {title: 'Fecha',  titleTextStyle: {color: '#333'}},
          vAxis: {title: 'Ordenes', minValue: 0, maxValue:maxNumb, format:'0'},
          legend: {position: 'top', alignment: 'center'},

        };

        var chart = new google.visualization.AreaChart(document.getElementById('ordenes'));
        chart.draw(data, options);
    }

    function ordenesUsuarios() 
    {
            var vectorOrdenCompraVenta=<?php echo json_encode($vectorOrdenCompraVenta);?>;
            var vectorOrdenComprador=<?php echo json_encode($vectorOrdenComprador);?>;
            var vectorFecha=<?php echo json_encode($vectorFecha);?>;
            var maxNumbPorRol=<?php echo $maxNumbPorRol;?>;

            var data = new google.visualization.DataTable();
        //data.addColumn('number', 'Usuarios');
        data.addColumn('string', 'Fecha');
        data.addColumn('number', 'CompraVenta');
        data.addColumn('number', 'Comprador');

        for(i = 0; i < vectorFecha.length; i++)
          data.addRow([vectorFecha[i],vectorOrdenCompraVenta[i],vectorOrdenComprador[i]]);

        if(maxNumbPorRol<4) // 4 es el numero minimo para que la grafica se vea bien
          maxNumbPorRol=4;

        var options = {
         // title: 'Usuarios',
          hAxis: {title: 'Fecha',  titleTextStyle: {color: '#333'}},
          vAxis: {title: 'Pedidos', minValue: 0, maxValue:maxNumbPorRol, format:'0'},
          legend: {position: 'top', alignment: 'center'},

        };
        var chart = new google.visualization.AreaChart(document.getElementById('ordenesUsuarios'));
        chart.draw(data, options);
    }

        function tasaAbandonoIntencionCompra() 
      {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
          ['Intencion de compras abandonadas', <?php echo $intencionCompraAbandonada;?>],
          ['Intenciones de compra no abandonadas', <?php echo $intencionCompraTotal-$intencionCompraAbandonada;?>],
        ]);

        // Set chart options
var options = {
                       'width':400,
                       'height':400,'is3D':true,'legend':'right','chartArea': {'position':'top','width': '70%', 'height': '70%'}};


        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('tasaAbandonoIntencionCompra'));
        chart.draw(data, options);
      }





</script>

