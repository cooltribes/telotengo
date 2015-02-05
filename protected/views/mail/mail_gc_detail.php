<div>  
    
<div style="color: #3c763d; background-color: #dff0d8; border-color: #d6e9c6; padding: 10px; text-align: center; margin-top: 20px; margin-bottom: 40px" >
    Gracias por comprar en nuestra tienda, a continuación te mostramos un resumen de tu orden.
</div>                        
                         <h1 style="margin-bottom: 1px; margin-left:1%">Pedido N° <?php echo $model->id; ?> </h1>
                         <hr style="margin-top:0px; border-top:#DDD"/> 
                         
                         <div style="width:100%;margin-top:15px">
                                <div style="width:25%; float:left; border:solid 1px #DDD; margin-left:1%; padding:7px">
                                    <div style="width:40%; float:left; text-align:right; padding-right:5px;">
                                        <p style="font-size:16px;"><b>Subtotal:</b></p>
                                        <p style="font-size:20px;"><b>Total:</b></p>
                                    </div>
                                    <div style="width:49%; float:left; text-align:left; padding-left:5px;">
                                        <p style="font-size:16px;"><?php echo $model->total; ?> Bs</p>
                                        <p style="font-size:20px;"><?php echo $model->total; ?> Bs</p>
                                    </div>
                                     
                                </div> 
                                <div style="width:37%; float:left; margin-left:2%">
                                     <hr style="margin-top:0px; border-top:#DDD;  margin-bottom:3px;"/>
                                    
                                          <?php                    
                                          /*Por los momentos una sola giftcard por Compra*/
                                          $giftcard = Giftcard::model()->findByAttributes(array("orden_id" => $model->id));
                                          $envio = new EnvioGiftcard();
                                          $envio->attributes = Yii::app()->getSession()->get('envio');
                                          ?>
                                      <strong>Monto</strong><br/>
                                      <div style="text-align:right"><?php  echo 'Bs. '.$giftcard->monto; ?></div> 
                                      <hr style="margin-top:2px; border-top:#DDD; margin-bottom:4px;"/>
                                      <strong>Enviado a</strong>  <br/>           
                                      <div style="text-align:right"><?php  echo $model->nombre; ?><br><?php  echo $model->email; ?></div>   
                                      <hr style="margin-top:2px; border-top:#DDD; margin-bottom:4px;"/>
                                      <strong>Mensaje</strong>  <br/>        
                                      <div style="text-align:right"><?php  echo $model->mensaje; ?></div>
                                      <hr style="margin-top: 2px; border-top:#DDD; margin-bottom:4px;"/>
                                </div> 
                                <div style="width:31%; float:left; margin-left:2%;">
                                 <img class="padding_left_medium" style="width:300px; max-width:100%" src='<?php echo Yii::app()->getBaseUrl(true)."/images/giftcards/GIFTCARD-xmas-470x288.jpg"; ?>'>
                                </div>    
                         </div>
                         
                         
                         
    
    
    
    
    </div> 
    