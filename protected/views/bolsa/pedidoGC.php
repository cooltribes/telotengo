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
                          <strong>Enviar a</strong>  <br/>           
                          <div class="text-right"><?php  echo $orden->email; ?></div>   
                          <hr class="margin_bottom_small no_margin_top"/> 
                          <strong>Mensaje</strong>  <br/>        
                          <div class="text-right"><?php  echo $orden->mensaje; ?></div>
                          <hr class="margin_bottom_small no_margin_top"/>          
                                    <!--<img src='<?php echo Yii::app()->baseUrl; ?>/images/giftcards/gift_card_one_x114.png' class='margin_bottom'>-->
                                   
                               
                        </div>
                        <div class="col-md-4 no_padding_right">
                        <img class="padding_left_medium" width="80%" src='<?php echo Yii::app()->baseUrl."/images/giftcards/GIFTCARD-xmas-470x288.jpg"; ?>'>
                               
                        </div>
                        
                        
                        
                    </section>
               
              <hr />

              <div>
                <div class="alert alert-info">Para completar la compra debes realizar el deposito o transferencia electrónica en un máximo de 3 días
                a cualquiera de las siguientes <strong>cuentas corrientes</strong>:</div>
                        <ul style="list-style-type:square" class="margin_top_small margin_left_small">
                            <li><strong>Banesco</strong> - 0134 0261 2026 1101 8222</li>
                            <li><strong>Venezuela</strong> - 0102 0129 2500 0008 9665</li>
                            <li><strong>Mercantil</strong> - 0105 0735 9417 3503 3014</li>
                            <li><strong>Banfoandes</strong> - 0007 0147 5600 0000 3292</li>
                            <li><strong>Sofitasa</strong> - 0137 0020 6200 0900 7231</li>
                            <li><strong>100% Banco</strong> - 0156 0015 2804 0019 1722</li>
                            <li><strong>BFC C.A</strong> - 0151 0135 1530 0004 2301</li>
                            <li><strong>Banco Activo</strong> - 0171 0018 1660 0037 0854</li>
                            <li><strong>Bancaribe</strong> - 0114 0430 8443 0005 2865</li>
                            <li><strong>Provincial</strong> - 0108 0098 6001 0005 7276</li>
                            <li><strong>Venezolano de Crédito </strong>- 0104 0033 3903 3008 3417.</li>
                            <li><strong>Corpbanca/BOD</strong>- 0121 0312 3700 1338 1504</li>
                            <li><strong>Banco Exterior</strong> - 0115 0114 1410 02398498</li>
                        </ul>

                        <h4 class="margin_top_small">Datos para la transferencia:</h4>
                        <ul style="list-style-type:square" class="margin_top_small margin_left_small">
                            <li><strong>Beneficiario/Razón Social</strong>: Sigmasys C.A.</li>
                            <li><strong>Correo electrónico:</strong> info@sigmatiendas.com</li>
                            <li><strong>RIF</strong>: J-29468637-0</li>
                            <li><strong>Dirección</strong>: Avenida libertador  C.C Las Lomas local 30,  San Cristóbal,  Edo. Táchira.
                            <li><strong>Teléfono</strong>:  02763442626</li>
                        </li>
                        </ul><br/> Si ya realizaste el depósito ingresa en la siguiente dirección para registrar tu pago <a href="http://telotengo.com/sigmatiendas/bolsa/registrarpagoGC/<?php echo $orden->id ?>" title="Registrar">Registrar Pago</a>
              </div>
            </div> 
            <!-- COLUMNA PRINCIPAL DERECHA OFF // -->
            
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
