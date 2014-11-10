<?php
 
$this->breadcrumbs=array(
	'Control Panel',
);
?>

<?php

$usuarios = User::model()->count();
// $ventas = Orden::model()->count();
$productos = Producto::model()->count();
$productos_activos = Producto::model()->countByAttributes(array('estado'=>1));
$productos_aprobar = Producto::model()->countByAttributes(array('estado'=>0));
$tiendas = Empresas::model()->countByAttributes(array('tipo'=>2,'estado'=>2));
$reclamos = Reclamo::model()->countByAttributes(array('user_id'=>Yii::app()->user->id));

$ordenes = Orden::model()->findAll();
$sumatoria = 0;
$ventas = 0;
	
	foreach($ordenes as $orden){
		if($orden->estado != 5){
			$sumatoria = $sumatoria + $orden->total;
			$ventas++;
		}	
	}

$sql2 = "select count(*) as total, c.razon_social as razon from tbl_orden_has_inventario a, tbl_inventario b, tbl_empresas c, tbl_almacen d where a.inventario_id=b.id and b.almacen_id=d.id and d.empresas_id=c.id GROUP BY c.id";
$empresa = Yii::app()->db->createCommand($sql2)->queryRow();

$sql = "SELECT sum(total) as total FROM tbl_orden where estado != 5";
$dinero_ventas = Yii::app()->db->createCommand($sql)->queryScalar();

if($sumatoria != 0)
	$promedio = $sumatoria / $ventas;
else
	$promedio = 0;
?>

<div class="container margin_top">
  <div class="page-header">
    <h1>Panel de Control</h1>
  </div>
  <div class="row">
    <div class="col-lg-12">
         <div class="bg_color3 margin_bottom_small padding_small box_1"> <img src="<?php echo Yii::app()->baseUrl; ?>/images/graph.jpg" alt="estadisticas"/> </div>
      
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
	      
      <div class="row">
        <div class="col-lg-5 margin_top">
         <div class="well"> 
			<h4>Notificaciones</h4>
       
         <table width="100%" border="0" class="table table-bordered table-condensed"  cellspacing="0" cellpadding="0">
            <tr>
              <td><strong>Ventas Totales</strong>:</td>
              <td><?php echo Yii::app()->numberFormatter->formatDecimal($sumatoria); ?> Bs.</td>
            </tr>
            <tr>
              <td><strong> Promedio de Ventas</strong>:</td>
              <td><?php echo Yii::app()->numberFormatter->formatDecimal($promedio); ?> Bs/Venta.</td>
            </tr>
            <tr>
              <td><strong>Numero de Usuarios registrados</strong>:</td>
              <td><?php echo $usuarios; ?></td>
            </tr>
            <tr>
              <td><strong> Tienda Más Vendedora</strong>:</td>
              <td><?php echo $empresa['razon']." (".$empresa['total'].") "; ?></td>
            </tr>
            <tr>
              <td><strong>Total de Tiendas Activas</strong>:</td>
              <td><?php echo $tiendas; ?></td>
            </tr>
            <tr>
              <td><strong> Total de Productos Activos</strong>:</td>
              <td><?php echo $productos_activos; ?></td>
            </tr>
         </table>
          
          <h4 class="margin_top">ACCIONES PENDIENTES</h4>
          <table width="100%" border="0" class="table table-bordered table-condensed"  cellspacing="0" cellpadding="0">
            <tr>
              <td><strong>Productos por aprobar</strong>:</td>
              <td><?php echo $productos_aprobar; ?></td>
            </tr>
            <tr>
              <td><strong>Reclamos por gestionar</strong>:</td>
              <td><?php echo $reclamos; ?></td>
            </tr>
          </table>
</div>

<div class="well">
	<div>
		<div> 
	    	<h4>Pagos</h4>
	    		<div>
	    			<?php
	    				$pagos = DetalleOrden::model()->findAllByAttributes(array('estado'=>1));
						$total=0;
						foreach($pagos as $pago){
							$total+=$pago->monto;
						}
	    			?>
	    			<strong>Pagos totales efectuados</strong>: <?php echo $total; ?> Bs.
	    		</div>
	    		<div>
	    			<?php $monto = Yii::app()->db->createCommand("select MAX(monto) from tbl_detalle_orden")->queryScalar(); ?>
	    		
	    			<strong>Monto más alto pagado</strong>: <?php echo $monto; ?> Bs.
	    		</div>
		</div>
	</div>
</div>



</div>



        <div class="col-lg-7 margin_top">
			<div class="well">
			<div class="padding_left_medium padding_right_medium">
          	
          	<h4 class="margin_bottom_small">Emails con Vendedores</h4>
          	<hr/>
          	
        		<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
				'id'=>'email-form',
				'enableAjaxValidation'=>false,
				'enableClientValidation'=>true,
				'type'=>'horizontal',
				'clientOptions'=>array(
					'validateOnSubmit'=>true, 
				),
				'htmlOptions' => array(
			        'enctype' => 'multipart/form-data',
			    ),
			)); ?>
        		
        		<div class="form-group">
					<label>Empresas</label> 
					<?php              
						$list = CHtml::listData($empresas,'id', 'razon_social'); 
								
						echo CHtml::dropDownList('empresa', '', $list, array('empty' => 'Seleccione una empresa.', 'class' => 'form-control')); 
					?>
				</div>    
        		
        		<div class="form-group">
					<?php echo $form->textFieldRow($mensaje,'asunto',array('class'=>'form-control','maxlength'=>45,'placeholder'=>'Asunto del email')); ?>
				</div>
        		
        		<div class="form-group">
					<label>Descripción</label>
					<?php $this->widget('ext.yiiredactor.widgets.redactorjs.Redactor', array( 'model' => $mensaje, 'attribute' => 'mensaje' )); ?>
					<?php echo $form->error($mensaje,'mensaje'); ?> 
				</div>
        		
        		<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'htmlOptions'=>array('class'=>'btn btn-primary btn-lg'),
					'label'=>'Enviar',
				)); ?>
        		
        		<?php $this->endWidget(); ?>
			
					</div>
				</div>
			</div>
			
      </div>
    </div>
  </div>
  
</div>
<!-- /container -->
