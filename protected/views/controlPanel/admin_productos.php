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
<h1 class="orderTitle">Panel de control de Productos</h1>
<hr>

<div class="container-fluid">   
  <div class="row">
     <div class="row-fluid clearfix stats">
         <div class="col-md-1 stat"> <!-- col-xs-1 stat -->
             <span class="value"><?php echo $todosPadres;?></span>
             <span class="legend">Productos Padres</span>
         </div>
       <div class="col-md-1 stat"> <!-- col-xs-1 stat -->
             <span class="value"><?php echo $todosPadresActivos;?></span>
             <span class="legend">Productos Padres Activos</span>
         </div>
       <div class="col-md-1 stat"> <!-- col-xs-1 stat -->
             <span class="value"><?php echo $todosPadresInactivos;?></span>
             <span class="legend">Productos Padres Inactivos</span>
         </div>
       <div class="col-md-1 stat"> <!-- col-xs-1 stat -->
             <span class="value"><?php echo $variaciones;?></span>
             <span class="legend">Variaciones</span>
         </div>
      <div class="col-md-1 stat"> <!-- col-xs-1 stat -->
             <span class="value"><?php echo $variacionesActivas;?></span>
             <span class="legend">Variaciones Activas</span>
         </div>
      <div class="col-md-1 stat"> <!-- col-xs-1 stat -->
             <span class="value"><?php echo $variacionesInactivas;?></span>
             <span class="legend">Variaciones Inactivas</span>
         </div>
      <div class="col-md-1 stat"> <!-- col-xs-1 stat -->
             <span class="value"><?php echo $variacionesPendientes;?></span>
             <span class="legend">Variaciones Pendientes</span>
         </div>


     </div>  

  
  </div>
  <!--
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
    -->
    
    
  <div class="charts-region">
    <div class="row">
      <div class="col-md-12">
​       <table class="table" width="100%" style="margin-top:37px;">
        <thead>
          <tr>
            <th>Codigo TLT</th>
            <th>Nombre del producto</th>
            <th>Numero de Visitas</th>
            <th>Cantidad Vendida</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($productosVisitas as $each):
          $model=Producto::model()->findByPk($each['producto_id'])
        ?>
          <tr>
            <td><?php echo $model->tlt_codigo;?></td>
            <td><?php echo $model->nombre;?></td>
            <td><?php echo $each['cantidad'];?></td>
            <td><?php echo $this->retornarProducto($each['producto_id']);?></td>
          </tr>
        <?php endforeach;?>
        </tbody>
      </table>
      </div>      
    </div>
    <!--
    <hr>
    <h3 class="bolder">Ordenes Generadas por tipo de usuario</h3>    
    <div class="row">
      <div class="col-md-11 col-md-offset-1">
​         <div id="ordenesUsuarios"  style="width: 1000px;"></div>
      </div>          
    </div>
    
    <hr>
    
    <div class="row">
      <div class="col-md-6 chart_status col-md-offset3 ">
        <h3 class="bolder">Tasa de abandono</h3>   
​         <div id="tasaAbandonoIntencionCompra" style="margin-top:-31px;"></div>
      </div>      
      <div class="col-md-6">
          <h3 class="bolder col-md-6 chart_status col-md-offset3">Estadisticas</h3> 
      </div>      
    </div> -->
​
    
  </div>
</div>


