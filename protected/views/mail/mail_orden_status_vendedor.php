<div style="font-size: 14px;">
    <div style=" margin-top: 15px; font-size: 14px;">Hola <?php echo $destinatario->profile->first_name." ".$destinatario->profile->last_name; ?>,</div>
<?php if($orden->estado==1):?>
   
    <div style=" margin-top: 4px;">Has aprobado la intención de compra <b>#<?php echo $orden->id;?></b>.</div>
    <?php echo $this->renderPartial("detalleMail", array('model'=>$orden, 'productoOrden'=>OrdenHasInventario::model()->findAllByAttributes(array('orden_id'=>$orden->id)), 'infoFrom'=>"Comprador"),true);?>
<? else: ?>

    <div style=" margin-top: 4px;">Has rechazado la intención de compra <b>#<?php echo $orden->id;?></b>.</div>
     <?php echo $this->renderPartial("detalleMail", array('model'=>$orden, 'productoOrden'=>OrdenHasInventario::model()->findAllByAttributes(array('orden_id'=>$orden->id)), 'infoFrom'=>"Comprador"),true);?>
<?php endif;?>
    <form action="<?php echo 'http://' . $_SERVER['HTTP_HOST'].Yii::app()->createUrl('orden/misVentas');?>">
	    <input   type="submit" value="Ver todas las Órdenes" style="
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: normal;
    line-height: 1.428571429;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    cursor: pointer;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    -o-user-select: none;
    user-select: none;
    background-color: #ff5b0b;
    height: 34px;
    border: solid 1px #FFF;
    font-weight: 600;
    border-radius: 0;
    color: #fff;
    margin-left: 41.6%;
"/>
	</form>
</div>
 
