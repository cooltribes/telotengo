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
<h1 class="orderTitle">Panel de control de usuarios</h1>
<hr>

<div class="container-fluid">   
  <div class="row">
    <div class="clearfix stats">
             <div class="col-xs-1 stat">
                 <span class="value"><?php echo $todosUsers;?></span>
                 <span class="legend">Total</span>
             </div>
             <div class="col-xs-1 stat">
                 <span class="value"><?php echo $totaUsuariosActivos;?></span>
                 <span class="legend">Activos</span>
             </div>
             <div class="col-xs-2 stat">
                 <span class="value"><?php echo $sumatoria;?></span>
                 <span class="legend">Ingresos a la plataforma</span>
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
    <h3 class="bolder">Usuarios registrados</h3>    
    <div class="row">
      <div class="col-md-11 col-md-offset-1">
​         <div id="usuarios"  style="width: 1000px;"></div>
      </div>      
    </div>
    <hr>
    <h3 class="bolder">Login de Usuarios</h3>    
    <div class="row">
      <div class="col-md-11 col-md-offset-1">
​         <div id="login"  style="width: 1000px;"></div>
      </div>          
    </div>
    
    <hr>
    
    <div class="row">
      <div class="col-md-6 chart_status col-md-offset3 ">
        <h3 class="bolder">Tasa de retorno</h3>   
​         <div id="tasaDeRetorno" style="margin-top:-31px;"></div>
      </div>      
      <div class="col-md-6">
          <h3 class="bolder col-md-6 chart_status col-md-offset3">Estadisticas</h3> 
​        <table class="table" width="100%" style="margin-top:69px;">
        <thead>
          <tr>
            <th></th>
            <th>Comprador</th>
            <th>Compra/Venta</th>
            <th>Vendedor</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Activos</td>
            <td><?php echo $usuariosCompradoresActivos;?></td>
            <td><?php echo $usuariosVendedoresActivos;?></td>
            <td><?php echo $usuariosCompraVentaActivos;?></td>
            <td><?php echo $totaUsuariosActivos;?></td>
          </tr>
          <tr>
            <td>Inactivos</td>
            <td><?php echo $usuariosCompradoresInactivos;?></td>
            <td><?php echo $usuariosVendedoresInactivos;?></td>
            <td><?php echo $usuariosCompraVentaInactivos;?></td>
            <td><?php echo $usuariosCompradoresInactivos+$usuariosVendedoresInactivos+$usuariosCompraVentaInactivos;?></td>
          </tr>
          <tr>
            <td>Numero de login</td>
            <td><?php echo $sumatoriaLoginCompradores;?></td>
            <td><?php echo $sumatoriaLoginVendedores;?></td>
            <td><?php echo $sumatoriaLoginCompraVenta;?></td>
            <td><?php echo $sumatoriaLoginCompradores+$sumatoriaLoginVendedores+$sumatoriaLoginCompraVenta;?></td>
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

    google.charts.setOnLoadCallback(usuarios);
    google.charts.setOnLoadCallback(login);
    google.charts.setOnLoadCallback(tasaDeRetorno);
  

    function usuarios() 
    {
            var vectorUsuarioCompraVenta=<?php echo json_encode($vectorUsuarioCompraVenta);?>;
            var vectorUsuarioVendedor=<?php echo json_encode($vectorUsuarioVendedor);?>;
            var vectorUsuarioComprador=<?php echo json_encode($vectorUsuarioComprador);?>;
            var vectorFecha=<?php echo json_encode($vectorFecha);?>;
            var maxNumb=<?php echo $maxNumb;?>;

            var data = new google.visualization.DataTable();
        //data.addColumn('number', 'Usuarios');
        data.addColumn('string', 'Fecha');
        data.addColumn('number', 'Compra/Venta');
        data.addColumn('number', 'Vendedor');
        data.addColumn('number', 'Comprador');

        for(i = 0; i < vectorFecha.length; i++)
          data.addRow([vectorFecha[i],vectorUsuarioCompraVenta[i],vectorUsuarioVendedor[i],vectorUsuarioComprador[i]]);

        if(maxNumb<4) // 4 es el numero minimo para que la grafica se vea bien
          maxNumb=4;

        var options = {
         // title: 'Usuarios',
          hAxis: {title: 'Fecha',  titleTextStyle: {color: '#333'}},
          vAxis: {title: 'Usuarios', minValue: 0, maxValue:maxNumb, format:'0'},
          legend: {position: 'top', alignment: 'center'},

        };

        var chart = new google.visualization.AreaChart(document.getElementById('usuarios'));
        chart.draw(data, options);
      }


      function login() 
      {
            var vectorLoginCompraVenta=<?php echo json_encode($vectorLoginCompraVenta);?>;
            var vectorLoginVendedor=<?php echo json_encode($vectorLoginVendedor);?>;
            var vectorLoginComprador=<?php echo json_encode($vectorLoginComprador);?>;
            var vectorFechaLogin=<?php echo json_encode($vectorFechaLogin);?>;
            var maxNumbLogin=<?php echo $maxNumbLogin;?>;

            var data = new google.visualization.DataTable();
        //data.addColumn('number', 'Usuarios');
        data.addColumn('string', 'Fecha');
        data.addColumn('number', 'Compra/Venta');
        data.addColumn('number', 'Vendedor');
        data.addColumn('number', 'Comprador');

        for(i = 0; i < vectorFechaLogin.length; i++)
          data.addRow([vectorFechaLogin[i],vectorLoginCompraVenta[i],vectorLoginVendedor[i],vectorLoginComprador[i]]);

        if(maxNumbLogin<4) // 4 es el numero minimo para que la grafica se vea bien
          maxNumbLogin=4;

        var options = {
         // title: 'Usuarios',
          hAxis: {title: 'Fecha',  titleTextStyle: {color: '#333'}},
          vAxis: {title: 'Login', minValue: 0, maxValue:maxNumbLogin, format:'0'},
          legend: {position: 'top', alignment: 'center'},

        };

        var chart = new google.visualization.AreaChart(document.getElementById('login'));
        chart.draw(data, options);
      }

      function tasaDeRetorno() 
      {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
          ['Mas de tres visitas', <?php echo $usuarioMasTresVisitas;?>],
          ['Menos o igual a tres visitas', <?php echo $usuarioMenosIgualTresVisitas;?>],
        ]);

        // Set chart options
                var options = {
                       'width':400,
                       'height':400,'is3D':true,'legend':'right','chartArea': {'position':'top','width': '70%', 'height': '70%'}};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('tasaDeRetorno'));
        chart.draw(data, options);
    }


</script>

