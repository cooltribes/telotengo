 <div><?php $user=User::model()->findByPk($model->user_id);  ?> 

               
                         <h2 style="margin-bottom: 1px; margin-left:1%; margin-top:35px">
                             ¡<?php echo $user->profile->first_name." ".$user->profile->last_name; ?> te ha enviado una Giftcard Sigma!
                         </h2>
                         <hr style="margin-top:0px; border-top:#DDD;"/> 
                         
                         <div style="width:100%; margin-top:35px">
                              <div style="width:45%; float:left; margin-left:2%;">
                                 <img class="padding_left_medium" style="width:300px; max-width:100%" src='<?php echo Yii::app()->getBaseUrl(true)."/images/giftcards/GIFTCARD-xmas-470x288.jpg"; ?>'>
                              </div>    
                                
                                
                                <div style="width:47%; float:left; margin-left:2%">
                                    
                                    
                                          <?php                    
                                          /*Por los momentos una sola giftcard por Compra*/
                                          $giftcard = Giftcard::model()->findByAttributes(array("orden_id" => $model->id));
                                          $envio = new EnvioGiftcard();
                                          $envio->attributes = Yii::app()->getSession()->get('envio');
                                          ?>
                                      <strong>Monto</strong><br/>
                                      <div style="text-align:right; font-size:18px"><?php  echo 'Bs. '.$giftcard->monto; ?></div> 
                                      <hr style="margin-top:2px; border-top:#DDD; margin-bottom:4px;"/>
                                      
                                      <strong>Mensaje</strong>  <br/>        
                                      <div style="text-align:right; font-size:18px"><?php  echo $model->mensaje; ?></div>
                                      <hr style="margin-top: 2px; border-top:#DDD; margin-bottom:4px;"/>
                                      
                                      
                                      
                                      <strong>Código</strong>  <br/>        
                                      <div style="text-align:right; font-size:18px"><?php  echo $giftcard->codigo; ?></div>
                                      <hr style="margin-top: 2px; border-top:#DDD; margin-bottom:4px;"/>
                                </div> 
                                  
                                <div style="width:100%; float:left; text-align: center; font-size: 16px">
                                     <br/>
                         <p>
                             Haz click <a href="<?php echo Yii::app()->getBaseUrl(true);?>">aquí</a> para usarla comprando entre nuestra
                              gran variedad de productos.
                         </p>
                                </div>
                         </div>
   </div>