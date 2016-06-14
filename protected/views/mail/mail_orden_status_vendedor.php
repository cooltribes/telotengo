<div style="font-size: 14px;">
    <div style=" margin-top: 15px; font-size: 14px;">Hola <?php echo $destinatario->profile->first_name." ".$destinatario->profile->last_name; ?>,</div>
<?php if($orden->estado==1):?>
   
    <div style=" margin-top: 4px;">Has aprobado la intención de compra <b>#<?php echo $orden->id;?></b>.</div>
    <?php echo $this->renderPartial("detalleMail", array('model'=>$orden, 'productoOrden'=>OrdenHasInventario::model()->findAllByAttributes(array('orden_id'=>$orden->id)), 'infoFrom'=>"Comprador"),true);?>
    <div style="text-align: center; margin-top: 15px;">¡Gracias por comprar en Telotengo!</div>
<? else: ?>

    <div style=" margin-top: 4px;">Has rechazado la intención de compra <b>#<?php echo $orden->id;?></b>.</div>
     <?php echo $this->renderPartial("detalleMail", array('model'=>$orden, 'productoOrden'=>OrdenHasInventario::model()->findAllByAttributes(array('orden_id'=>$orden->id)), 'infoFrom'=>"Comprador"),true);?>
    <div style="margin-top: 15px;">Si deseas comprobar su estado haz clic <a href="<?php echo Yii::app()->getBaseUrl(true)."/orden/detalleVendedor/".$orden->id;?>">aquí</a></div>
    <div style="text-align: center; margin-top: 15px;">¡Gracias por participar en Telotengo!</div>
<?php endif;?>
</div>
 
