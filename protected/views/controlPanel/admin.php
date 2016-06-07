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
<h1 class="orderTitle">Panel de control de empresas</h1>
<hr>

<div class="container-fluid">   
  <div class="row">
    <div class="clearfix stats">
             <div class="col-xs-1 stat">
                 <span class="value"><?php echo $sumatoria?></span>
                 <span class="legend">Registradas</span>
             </div>
             <div class="col-xs-1 stat">
                 <span class="value"><?php echo Empresas::model()->countByAttributes(array('rol'=>'compraVenta'));?></span>
                 <span class="legend">Compra-venta</span>
             </div>
              <div class="col-xs-1 stat">
                 <span class="value"><?php echo Empresas::model()->countByAttributes(array('rol'=>'vendedor'));?></span>
                 <span class="legend">Vendedoras</span>
             </div>
             <div class="col-xs-1 stat">
                 <span class="value"><?php echo Empresas::model()->countByAttributes(array('rol'=>'comprador'));?></span>
                 <span class="legend">Compradoras</span>
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
    <hr>
    <h3 class="bolder">Registradas</h3>  
    <div class="row">
      <div class="col-md-11 col-md-offset-1">
​        <div id="empresas"  style="width: 1000px;"></div>
        <!--
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
        </div>-->

      </div>
           
    </div>
    <!--
    <hr>
    <h3 class="bolder">Usuarios registrados</h3>    
    <div class="row">
      <div class="col-md-12">
​         <div id="usuarios"  style="width: 1000px;"></div>
      </div>      
    </div>
    <hr>
    <h3 class="bolder">Login de Usuarios</h3>    
    <div class="row">
      <div class="col-md-12">
​         <div id="login"  style="width: 1000px;"></div>
      </div>          
    </div>
     -->
    <hr>
   <h3 class="bolder">Estadisticas</h3>    
    <div class="row">
      <div class="col-md-6 chart_status col-md-offset-3">
​        <table class="table" width="100%">
        <thead>
          <tr>
            <th></th>
            <th>Compradora</th>
            <th>Compra/Venta</th>
            <th>Vendedora</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Empresas</td>
            <td><?php echo $totalEmpresasCompradoras;?></td>
            <td><?php echo $totalEmpresasCompraVenta;?></td>
            <td><?php echo $totalEmpresasVendedoras;?></td>
            <td><?php echo $sumatoria;?></td>
          </tr>
          <tr>
            <td>Almacenes</td>
            <td><?php echo $totalAlmacenComprador;?></td>
            <td><?php echo $totalAlmacenVendedor;?></td>
            <td><?php echo $totalAlmacenCompraVenta;?></td>
            <td><?php echo $totalAlmacenCompraVenta+$totalAlmacenVendedor+$totalAlmacenComprador;?></td>
          </tr>
        </tbody>
      </table>
      </div>      
      <div class="col-md-6">
​
      </div>      
    </div>
​    
    
  </div>
</div>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">

    google.charts.load('current', {'packages':['corechart']});

    google.charts.setOnLoadCallback(empresas);


      function empresas() 
      {
            var vectorEmpresasCompraVenta=<?php echo json_encode($vectorEmpresasCompraVenta);?>;
            var vectorEmpresasVendedor=<?php echo json_encode($vectorEmpresasVendedor);?>;
            var vectorEmpresasComprador=<?php echo json_encode($vectorEmpresasComprador);?>;
            var vectorFechaEmpresas=<?php echo json_encode($vectorFechaEmpresas);?>;
            var maxNumbEmpresas=<?php echo $maxNumbEmpresas;?>;

            var data = new google.visualization.DataTable();
        //data.addColumn('number', 'Usuarios');
        data.addColumn('string', 'Fecha');
        data.addColumn('number', 'Compra/Venta');
        data.addColumn('number', 'Vendedor');
        data.addColumn('number', 'Comprador');

        for(i = 0; i < vectorFechaEmpresas.length; i++)
          data.addRow([vectorFechaEmpresas[i],vectorEmpresasCompraVenta[i],vectorEmpresasVendedor[i],vectorEmpresasComprador[i]]);

        if(maxNumbEmpresas<4) // 4 es el numero minimo para que la grafica se vea bien
          maxNumbEmpresas=4;

        var options = {
         // title: 'Usuarios',
          hAxis: {title: 'Fecha',  titleTextStyle: {color: '#333'}},
          vAxis: {title: 'Empresas', minValue: 0, maxValue:maxNumbEmpresas, format:'0'},
          legend: {position: 'top', alignment: 'center'},

        };

        var chart = new google.visualization.AreaChart(document.getElementById('empresas'));
        chart.draw(data, options);
      }


</script>

