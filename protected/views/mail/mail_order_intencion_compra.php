<div style="font-size: 14px;">
    <div style=" margin-top: 15px; font-size: 14px;">Hola <?php echo $destinatario->profile->first_name." ".$destinatario->profile->last_name; ?>,</div>
    <div style=" margin-top: 4px;">Te informamos que <b><?php echo EmpresasHasUsers::model()->findByAttributes(array('users_id'=>Yii::app()->user->id))->empresas->razon_social;?></b> te ha enviado la intención de compra <b>#<?php echo $orden->id;?></b>.</div>
    <br>
    <?php echo $this->renderPartial("detalleMail", array('model'=>$orden, 'productoOrden'=>OrdenHasInventario::model()->findAllByAttributes(array('orden_id'=>$orden->id)), 'infoFrom'=>"Vendedor"),true);?>
   <div style="margin-top: 15px;"> 
  	 Para verificarla dirígete a tu administrador de órdenes. <br><br>
  	 ¡Gracias por vender en Telotengo!
   </div>

</div>