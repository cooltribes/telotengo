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
             <div class="col-xs-2 stat">
                 <span class="value"><?php echo count(Empresas::model()->findAll());?></span>
                 <span class="legend">Total de empresas registradas</span>
             </div>
             <div class="col-xs-2 stat">
                 <span class="value"><?php echo User::model()->countByAttributes(array('status'=>1, 'pendiente'=>0));?></span>
                 <span class="legend">Total de usuarios activos</span>
             </div>
             <div class="col-xs-3 stat">
                 <span class="value"><?php echo $sumatoria;?></span>
                 <span class="legend">Total de ingresos a la plataforma</span>
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
    <h3 class="bolder">Empresas registradas</h3>  
    <div class="row">
      <div class="col-md-12 ">
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
    
    <h4>Status</h4>    
    <hr>
    <div class="row">
      <div class="col-md-6 chart_status">
​
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

    google.charts.setOnLoadCallback(usuarios);
    google.charts.setOnLoadCallback(empresas);
    google.charts.setOnLoadCallback(login);

  

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


</script>

