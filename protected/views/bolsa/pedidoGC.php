<div class="container-fluid" style="padding: 0 15px;">
    <div class="container">
        <div class="row-fluid">
            <!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->
            <div class="main-content" role="main">
                    <div class="margin_top_small margin_bottom_small">
                        <?php
        if ($orden->estado == 3) { // Listo el pago
      ?>    
        <div class='alert alert-success margin_top_medium margin_bottom'>
          <h1>Tu orden ha sido completada satisfactoriamente.</h1>
            <p>Hemos recibido los datos de tu compra <br/> Tu tarjeta será enviada y estará disponible para ser aplicada al momento de confirmar el pago</p>
        </div>
        <?php
        }else if($orden->estado == 1){ // Por pagar aun
        ?>
        <div class='alert alert-success margin_top_small margin_bottom_small'>
          <h1>Tu Gift Card se ha creado satisfactoriamente.</h1>
            <p>Hemos recibido los datos de tu compra<br/> Tu tarjeta será enviada y estará disponible para ser aplicada al momento de confirmar el pago</p>
        </div>
        <?php
        }
        
        ?>
                    </div>
                    
              
                    <section class="row-fluid">
                        
                         <h1 class="col-md-8">Pedido N° <?php echo $orden->id; ?> </h1>
                         <div class="col-md-4 text-right margin_top_small">
                               <a href="<?php echo Yii::app()->baseUrl; ?>" class="btn btn-success btn-lg">Seguir Comprando</a>
                         </div>
                         <div class="no_margin_top col-md-12 margin_bottom">
                             <hr class="no_margin_top" />
                         </div>
                         
                         <div class="col-md-4 well " style="background: #FFF" >
                            
                            <table class="table" id="summary">
                                <tr>
                                    <td>Subtotal</td>
                                    <td><strong><?php echo $orden->total; ?> Bs</strong></td>
                                </tr>
                              
                              
                               
                                <tr>
                                    <td class="total">Total</td>
                                    <td class="total"><strong><?php echo $orden->total; ?> Bs</strong></td>
                                </tr>
                            </table>
                            
                            <div>  
                                <?php    $user = User::model()->findByPk(Yii::app()->user->id);?>
                                 <p>Hemos enviado una notificación de pago a tu correo electrónico: <strong><?php echo $user->email; ?></strong> </p>
                            </div>                            
                        </div>
                        
                                               
                        <div class="col-md-4 no_padding_right">
                            <hr class="no_margin_top margin_bottom_xsmall"/>
                        
                              <?php                    
                              /*Por los momentos una sola giftcard por Compra*/
                              $giftcard = Giftcard::model()->findByAttributes(array("orden_id" => $orden->id));
                              $envio = new EnvioGiftcard();
                              $envio->attributes = Yii::app()->getSession()->get('envio');
                              ?>
                          <strong>Monto</strong><br/>
                          <div class="text-right"><?php  echo 'Bs. '.$orden->total; ?></div> 
                          <hr class="margin_bottom_small no_margin_top"/>
                          <strong>Enviado a</strong>  <br/>           
                          <div class="text-right"><?php  echo $orden->email; ?></div>   
                          <hr class="margin_bottom_small no_margin_top"/> 
                          <strong>Mensaje</strong>  <br/>        
                          <div class="text-right"><?php  echo $orden->mensaje; ?></div>
                          <hr class="margin_bottom_small no_margin_top"/>          
                                    <!--<img src='<?php echo Yii::app()->baseUrl; ?>/images/giftcards/gift_card_one_x114.png' class='margin_bottom'>-->
                                   
                               
                        </div>
                        <div class="col-md-4 no_padding_right">
                        <img class="padding_left_medium" width="100%" src='<?php echo Yii::app()->baseUrl."/images/giftcards/GIFTCARD-xmas-470x288.jpg"; ?>'>
                               
                        </div>
                        
                        
                        
                    </section>
               

            </div> 
            <!-- COLUMNA PRINCIPAL DERECHA OFF // -->
        </div>
    </div>
</div>
<script type="text/javascript">
/*<![CDATA[*/
    function printElem(elem)
    {
        popup($(elem).html());
    }

    function popup(data) 
    {        
        
        var h = 600;
        var w = 800;
        var left = (screen.width - w)/2;
        var top = (screen.height - h)/2 - 30;
        var mywindow = window.open('', 'GiftCard Personaling', 'height='+h+',width='+w+', left='+left+', top='+top);
        mywindow.document.write('<html><head><title>GiftCard</title>');
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</ body></html>');

        mywindow.print();
        mywindow.close();

        return true;
    }
/*]]>*/
</script> 
