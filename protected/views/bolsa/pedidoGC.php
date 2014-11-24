<?php

$this->setPageTitle(Yii::app()->name . " - Resumen de la orden");
if (!Yii::app()->user->isGuest) { // que este logueado
    $user = User::model()->findByPk(Yii::app()->user->id);
?>
<?php //echo "xPagar".$orden->getxPagar()." SumxOrden".Detalle::model()->getSumxOrden($orden->id);  ?>
<style>
	#voucher div table{
		border: solid 25px #FFF;
	margin: 0 auto;
	outline: solid 1px;
	}
</style>
  <div class="container margin_top">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <?php
          if ($orden->estado == 3) { // Listo el pago
        ?>    
          <div class='alert alert-success margin_top_medium margin_bottom'>
            <h1>Tu orden ha sido completada satisfactoriamente.</h1>
              <p>Hemos recibido los datos de tu compra <br/>
                 Tu tarjeta será enviada y estará disponible para ser aplicada al momento de confirmar el pago</p>
          </div>
          <?php
          }else if($orden->estado == 1){ // Por pagar aun
          ?>
          <div class='alert alert-success margin_top_medium margin_bottom'>
            <h1>Tu Gift Card se ha creado satisfactoriamente.</h1>
              <p>Hemos recibido los datos de tu compra<br/>
              Tu tarjeta será enviada y estará disponible para ser aplicada al momento de confirmar el pago</p>
          </div>
          <?php
          }

          ?>
          <section class="bg_color3 margin_top  margin_bottom_small padding_small box_1">
            <h3> Resumen de la compra: </h3>
              <p class="well well-small"><strong>Número de confirmación:</strong> <?php echo $orden->id; ?></p>                    
              <hr/>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <th class="text_align_left"><?php  echo Yii::t('contentForm','Subtotal'); ?>:</th>
                    <td><?php echo 'Bs. ' . Yii::app()->numberFormatter->formatCurrency($orden->total, ''); ?></td>
                  </tr>           
                  <tr>
                    <th class="text_align_left"><h4>Total:</h4></th>
                    <td><h4><?php echo 'Bs. ' . Yii::app()->numberFormatter->formatCurrency($orden->total, ''); ?></h4></td>
                  </tr>
              </table>
              <hr/> 
              <p>Hemos enviado una notificación de pago a tu correo electrónico: <strong><?php echo $user->email; ?></strong> </p>
              <p>
              <a href="<?php echo Yii::app()->baseUrl; ?>/bolsa/registrarpagoGC" class="btn btn-danger" title="Registrar pago">Registrar Pago</a>
              </p>      
             	<?php

              if(Yii::app()->getSession()->get('tipoPago') == 2){ ?>
                <p><?php echo Yii::t('contentForm','Reference').": ".$referencia; ?></p>	
                  <div style="margin: 0 auto; " id="voucher"><?php echo CHtml::decode($voucher); ?></div>
                    <?php } ?>

                    <h3 class="margin_top">Detalle de la Orden.</h3>
                    <div>
                        <table class='table' width='100%' >
                            <thead>                                
                              <tr>
                                <th colspan='2'>Gift Card</th>
                                <th>Monto</th>
                                <th></th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php                    
                              /*Por los momentos una sola giftcard por Compra*/
                              $giftcard = Giftcard::model()->findByAttributes(array("orden_id" => $orden->id));
                              $envio = new EnvioGiftcard();
                              $envio->attributes = Yii::app()->getSession()->get('envio');
                              ?>
                              <tr>
                              <td>
                                <!--<img src='<?php echo Yii::app()->baseUrl; ?>/images/giftcards/gift_card_one_x114.png' class='margin_bottom'>-->
                                <img src='<?php echo Yii::app()->baseUrl."/images/giftcards/gift_card_one_x470.jpg"; ?>' class='margin_bottom'>
                                    </td>
                                    <td></td><td><?php 
                                    /*
                                      <td>
                                        <strong><?php echo Yii::t('contentForm','Code');  ?>:</strong> <?php echo $giftcard->getMascaraCodigo(); ?><br/>
                                        <strong><?php echo Yii::t('contentForm','Validity');  ?>:</strong> <?php echo Yii::t('contentForm','From1')." <i>".date("d-m-Y", $giftcard->getInicioVigencia()).
                                                "</i>".Yii::t('contentForm','To')." <i>".date("d-m-Y", $giftcard->getFinVigencia())."</i>"; ?><br/>
                                        <?php 
                                        //si hay para y mensaje
                                        if($entrega == 2){ ?>
                                        <strong><?php echo Yii::t('contentForm','Sent to:');  ?></strong> <?php echo $envio->email; ?><br/>
                                        <?php } ?>
                                      </td>
                                    */
                                    echo 'Bs. '.$orden->total; ?></td>
                                    <td>
                                    <?php /*
                                    //si era para imprimir
                                        $this->widget("bootstrap.widgets.TbButton", array(
                                           'buttonType' => "link" ,
                                           'type' => "danger" ,
                                           'icon' => "print white" ,
                                           'label' => "Imprimir",
                                           'url' => "javascript:print()" ,
                                        ));
                                    
                                    //si era para enviar
                                        echo "<br/><i>Además será enviada al correo electrónico</i>";  */
                                    ?> 
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section> 
                <hr/>
                <a href="<?php echo Yii::app()->baseUrl; ?>/tienda/index" class="btn btn-danger" title="seguir comprando">Volver a la tienda</a> </div>
        </div>
    </div> 
    <!-- /container -->
<?php
}// si esta logueado
else {
    // redirecciona al login porque se murió la sesión
//	header('Location: /user/login');
    $url = CController::createUrl("/user/login");
    header('Location: ' . $url);
}
?>
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