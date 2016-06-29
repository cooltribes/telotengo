<style>
          .admini{
             padding-top:21px;
          }
</style>
<?php $this->breadcrumbs=array('Mi Perfil'); ?> 

<div class="col-md-3 profile-leftBar">
    <?php $this->renderPartial('left_bar',array('model'=>$model, 'identificador'=>$identificador)); ?> 
</div>
<?php if($avatar===true):
    echo "<script>$('#layout-avatar').attr('src','".Yii::app()->getBaseUrl(true);
     if(strpos($model->avatar_url, ".png")==-1)
        echo str_replace(".jpg", "_thumb.jpg", $model->avatar_url);
    else
        echo str_replace(".png", "_thumb.png", $model->avatar_url); 

     
     echo "');</script>"; 
     endif;  
     if(!Yii::app()->authManager->checkAccess("admin", $identificador))
     { ///cambio la manera como se muestra para el admin y para el usuario 
    ?>
        <div class="col-md-9 profile-center">
<?php
    }else
    {?>
        <div class="col-md-9 profile-center">
            <h1>Ultimas Acciones</h1>
        <div class="admini">
    <?php
    }?>
    

<?php if($entro==0): ?>
    <h1>Panel de Control</h1>
    <h3>Ordenes</h3>
    
    <?php $this->renderPartial('status', array(
    	    'model'=>$model,
			'totaPendienteCompra'=>$totaPendienteCompra,
			'totaRechazadasCompra'=>$totaRechazadasCompra,
			'totaAprobadaCompra'=>$totaAprobadaCompra,
			'totaPendienteVendidas'=>$totaPendienteVendidas,
			'totaRechazadasVendidas'=>$totaRechazadasVendidas,
			'totaAprobadaVendidas'=>$totaAprobadaVendidas,
			'producComprados'=>$producComprados,
			'producInventario'=>$producInventario,
			'entro'=>$entro,
			'identificador'=>$identificador,
	
	));?>

   <div class="row-fluid clearfix cards margin_top">
       <div class="col-md-6 no_padding_left">
          <div class="card row-fluid clearfix">
             <span class="title col-md-7"> <?php echo $empresa->razon_social;?></span>
              <span class="col-md-7"><?php echo $empresa->rif;?></span>
             <span class="col-md-5 text-right">
                 <a class="showInfo"  onclick="showInfo('#info1')" id="info1-show">Mostrar Información</a> 
             </span>
             <p class="hide col-md-12" id="info1">
             	 <?php echo $empresa->telefono;?><br/>
                 <?php echo $empresa->direccion;?><br/>
                 <?php echo $empresa->web;?><br/>

                 
             </p>
          </div> 
       </div>
       <div class="col-md-6 no_padding_right">
          <div class="card row-fluid clearfix">
             <span class="title col-md-7">Almacenes</span>
             <span class="col-md-7"><?php echo count($almacen);?></span>
             <span class="col-md-5 text-right">
                 <a class="showInfo" onclick="showInfo('#info2')" id="info2-show">Mostrar Información</a>
             </span>
             <p class="hide col-md-12" id="info2">
             	<?php 
             	foreach($almacen as $almacenes)
             	{
             		echo $almacenes->alias."<br/>"; //TODO DEFINIR SI ES EL ALIAS O EL NOMBRE
             	}
                ?>
             </p>
             
          </div> 
       </div>
   </div>
   <?php endif; 
   if(!Yii::app()->authManager->checkAccess("admin", $identificador)):?>
    <h1>Ultimas Acciones</h1>
<?php endif;?>
    <table class="table table-striped" width="100%">
        <thead>
            <tr>
                <th class="col-md-2">Fecha</th>
                <th class="col-md-2">Hora</th>
                <th class="col-md-9">Acción</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($ultimosLog as $ult):?>
             <tr>
             <?php $fecha=explode(" ", Funciones::invertirFecha($ult->fecha));?>
                <td ><?php echo $fecha[0];?></td>
                <td><?php echo $fecha[1];?></td>
                <td><?php echo Log::model()->retornarAcciones($ult->id_user,$ult->id_orden, $ult->id_empresa, $ult->id_producto, 
                $ult->id_email_invitacion, $ult->id_masterData, $ult->id_inbound, $ult->id_almacen, $ult->fecha, $ult->accion, 
                $ult->id_admin, $ult->id_producto_padre, $ult->id_marca, $ult->id_color, $ult->id_unidad, $ult->id_atributo, 
                $ult->id_categoria);?></td>
            </tr>
        <?php endforeach;?>
        </tbody>
        
    </table>
</div>
<?php 
if(!Yii::app()->authManager->checkAccess("admin", $identificador)):?>
    </div>
<?php endif;?>
<script>
    
    function showInfo(id){
        if($(id).hasClass('hide')){
            $(id).removeClass('hide');
            $(id+'-show').html('Ocultar Información');           
        }            
        else{
            $(id).addClass('hide');
            $(id+'-show').html('Mostrar Información');
        }
            
    }
</script>