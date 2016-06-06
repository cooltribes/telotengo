<?php
Yii::app()->clientScript->registerLinkTag('stylesheet','text/css','https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,400,300,600,700',null,null);
Yii::import('application.components.*');
/*require_once "mercadopago-sdk/lib/mercadopago.php";
$mp = new MP ("8356724201817235", "vPwuyn89caZ5MAUy4s5vCVT78HYluaDk");
$mp->sandbox_mode(TRUE);*/

$this->setPageTitle(Yii::app()->name . " - Confirmar compra"); 

if (!Yii::app()->user->isGuest) { // que este logueado

?>
<style>
    .progreso_compra_giftcard {
        width: 268px;
    }
    .progreso_compra_giftcard .last-done {
        text-align: center;
    }
</style>

<div class="container margin_top">
    <div class="row-fluid">
        <div class="col-md-12">
            <h2>Confirmar compra de Gift Card</h2>
            <hr/>
        </div>
    </div>
    <input type="hidden" id="tarjeta" value="<?php echo(Yii::app()->getSession()->get('idTarjeta')); ?>" />
        <div class="row margin_top_xsmall">
            <section class="col-md-3"> 
                <div class="well">
                    <h4 class="braker_bottom">Información de la compra</h4>
                    <div class="margin_bottom_small">
                        <img src="<?php echo Yii::app()->baseUrl; ?>/images/giftcards/GIFTCARD-xmas-200x123.jpg">
                    </div>
                    <?php 
                        //datos de todas las giftcards de la bolsa
                        //Temporalmente solo una
                    ?>
                    <p>
                        <strong>Monto del Gift Card</strong><br/>
                        <span class="muted small"><?php echo $giftcard->monto.' Bs.'; ?></span>
                    </p>
                    <p>
                        <strong>Fechas válidas:</strong> <br/>
                        <?php echo 'Desde '.date("d/m/Y"); ?> <br/>
                        <?php echo "Hasta "; ?>
                        <?php $now = date('Y-m-d', strtotime('now'));
                            echo date("d/m/Y", strtotime($now." + 1 year")); ?>
                    </p>
                </div>
            </section>
            <section class="col-md-6">
                <div class="well">
                    <h4>Método de pago seleccionado</h4>
                        <div class=" margin_bottom">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
                            <?php 
                              	if(Yii::app()->getSession()->get('tipoPago')==1){
                                    echo "<tr class='deptran'><td valign='top'><i class='icon-exclamation-sign'></i> Depósito o Transferencia bancaria.</td></tr>
                                    <tr><td>".TipoPago::model()->datosDeposito()."</td></tr>
                                    ";
                                }else if(Yii::app()->getSession()->get('tipoPago')==4){
                                    echo "<tr class='mp'><td valign='top'><i class='icon-exclamation-sign'></i>".Yii::t('contentForm','MercadoPago').".</td></tr>";
                                }else if(Yii::app()->getSession()->get('tipoPago')==2){
                                    echo "<tr class='mp'>
                                        <td valign='top'><i class='icon-exclamation-sign'></i>  ".Yii::t('contentForm','Credit Card').".</td>
                                        </tr>";

                                    $tarjeta = TarjetaCredito::model()->findByPk($idTarjeta);

                                    $rest = substr($tarjeta->numero, -4);
                                    echo "<tr class='mp'><td>";
                                        echo "<b> ".Yii::t('contentForm','Name').":</b> ".$tarjeta->nombre."
                                        </br><b> ".Yii::t('contentForm','Number').":</b> XXXX - XXXX - XXXX - ".$rest."                            
                                        </br><b> ".Yii::t('contentForm','Expiration').":</b> ".$tarjeta->vencimiento;
                                    echo "</td></tr>";        
                                }
                            ?>
                            </table>
                        </div>
                </div>
            </section>
            <section class="col-md-3"> 
            <!-- Resumen de Productos ON -->
                <div class="well">
                    <h5>Total de Gift Cards: 1</h5>
                    <div class="margin_bottom_xsmall">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed">
                            <tr>
                                <th class="text_align_left"><?php echo Yii::t('contentForm','Subtotal'); ?> :</th>
                                <td><?php echo 'Bs. '.Yii::app()->numberFormatter->formatCurrency($monto, ''); ?></td>
                            </tr>
                            <tr>
                                <th class="text_align_left"><h4><?php echo Yii::t('contentForm','Total'); ?> :</h4></th>
                                <td><h4><?php echo 'Bs. '.Yii::app()->numberFormatter->formatCurrency($monto, ''); ?></h4></td>
                            </tr>
                        </table>
                        <?php
                        $tipo_pago = Yii::app()->getSession()->get('tipoPago');
                        /*Para mercadopago*/
                        if($tipo_pago == 4){
                      	    $user = User::model()->findByPk(Yii::app()->user->id);
        				    $profile = Profile::model()->findByPk(Yii::app()->user->id);
                      	    $preference = array (
                                "items" => array (
                                    array (
                                        "title" => "Look seleccionado + productos individuales",
                                        "quantity" => 1,
                                        "currency_id" => "VEF",
                                        "unit_price" => $total
                                        //"unit_price" => 23
                                    )
                                ),
                                "payer" => array(
                                    "name" => $profile->first_name,
                                    "surname" => $profile->last_name,
                                    "email" => $user->email
                                ),
                                "back_urls" => array(
                                    "success" => 'http://personaling.com'.Yii::app()->baseUrl.'/bolsa/successMP',
                                    "failure" => 'http://personaling.com'.Yii::app()->baseUrl.'/bolsa/successMP',
                                    "pending" => 'http://personaling.com'.Yii::app()->baseUrl.'/bolsa/successMP'
                                ),
                            );
                            $preferenceResult = $mp->create_preference($preference);
                        ?>
                    <a href="<?php echo $preferenceResult['response']['sandbox_init_point']; ?>" name="MP-Checkout" id="boton_mp"
                        class="blue-L-Rn-VeAll" mp-mode="modal"><?php echo Yii::t('contentForm','Pay MercadoPago'); ?></a>
                    <?php
                    }
                    /*DEPOSITO O TRANSFERENCIA*/ 
                    else if($tipo_pago == 1  || $tipo_pago == 2){ 
                          
                        $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            			    'id'=>'form-Comprar',
            			    'action'=>Yii::app()->createUrl('bolsa/comprarGC'),
            			    'htmlOptions'=>array('class'=>'well'),
            			)); 
                        }
                        $tipo_pago = Yii::app()->getSession()->get('tipoPago');
                        echo CHtml::hiddenField('codigo_randon',rand());
                        
                        $this->widget('bootstrap.widgets.TbButton', array(
                            'type'=>'danger',
                            'buttonType'=>'submit',
                            //'buttonType'=>'button',
                            'size'=>'large',
                            'label'=>$tipo_pago==2?'Pagar con tarjeta de crédito' : 'Completar compra',
                            //'url'=>Yii::app()->createUrl('bolsa/comprar'), // action
                            'icon'=>'',
                            'loadingText'=>'Cargando',
                            'htmlOptions'=>array(
                                //'onclick'=>'js:enviar_pago();',
                                'id'=>'btnPagarTDC',
                                )
                        ));

                        $this->endWidget(); 
                    ?>
                </div>
                <p><i class="icon-calendar"></i>
                    <?php echo 'Fecha estimada de entrega' ?>:<br/><?php echo date('d/m/Y', strtotime('+1 day'));?>  - <?php echo date('d/m/Y', strtotime('+1 week'));  ?> </p>
            </div>
                <p><a href="<?php echo Yii::app()->getBaseUrl(); ?>/site/politicas_de_devoluciones" title="Políticas de Envios y Devoluciones" target="_blank">
                    <?php //echo 'Ver politicas de envíos y devoluciones'; ?>
                    </a>
                </p>
                <p class="muted"><i class="icon-comment"></i>
                    <?php echo 'Contactanos para asistencia: Lunes a Viernes 8:30 am | 5:00 pm'; ?></p>
            <!-- Resumen de Productos OFF --> 
        </section>
    </div>
</div>
<!-- /container -->
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModal','htmlOptions'=>array('class'=>'modal_grande hide fade','tabindex'=>'-1','role'=>'dialog','aria-labelleby'=>'myModalLabel','aria-hidden'=>'true'))); ?>
<?php $this->endWidget(); ?>

<?php 

}// si esta logueado 
else{
	// redirecciona al login porque se murió la sesión
	//header('Location: /site/user/login');	
	$url = CController::createUrl("/user/login");
    header('Location: '.$url);	
}
?>
<script>
$(document).ready(function(){
    $("#btnPagarTDC").click(function(e){
	$(this).attr("disabled", true);
        $(this).html('<i class="icon-lock icon-white"></i> Procesando pago...');
        $("body").addClass("aplicacion-cargando");
        $("#form-Comprar").submit();
        
    });
});

function enviar_pago(){
    $(this).html("Procesando el Pago...");
    $(this).attr("disabled", true);                               
}

function enviar()
{
        $('#boton_completar').attr("disabled", true);
        var idDireccion = $("#idDireccion").attr("value");
        var tipoPago = $("#tipoPago").attr("value");
        var subtotal = $("#subtotal").attr("value");
        var descuento = $("#descuento").attr("value");
        var envio = $("#envio").attr("value");
        var iva = $("#iva").attr("value");
        var total = $("#total").attr("value");
        var usar_balance = $("#usar_balance").attr("value");
        var seguro = $("#seguro").attr("value");
        var tipo_guia = $("#tipo_guia").attr("value");
        var peso = $("#peso").attr("value");

        $.ajax({
        type: "post",
        dataType: 'json',
        url: "comprar", // action 
        data: { 'idDireccion':idDireccion, 'tipoPago':tipoPago, 'subtotal':subtotal, 'descuento':descuento, 'envio':envio, 'iva':iva, 'total':total, 'usar_balance':usar_balance,
                        'seguro':seguro, 'tipo_guia':tipo_guia, 'peso':peso }, 
        success: function (data) {
            //console.log('Total: '+data.total+' - Descuento: '+data.descuento);
            if(data.status=="ok")
            {

                    window.location=data.url;
            }else if(data.status=='error'){
                    //console.log(data.error);
            }
        }//success
       })

}
	
function registrarCompra(){

    $.ajax({
        type: "post",
        dataType: 'json',
        url: "comprarGC", // action 
        data: { 'idDireccion':idDireccion, 'tipoPago':tipoPago, 'subtotal':subtotal,
                        'descuento':descuento, 'envio':envio, 'iva':iva, 'total':total,
                        'usar_balance':usar_balance, 'idDetalle':data.idDetalle,'seguro':seguro,'tipo_guia':tipo_guia, 'peso':peso
                        }, 
        success: function (data) {
                        if(data.status=="ok")
                        {
                                window.location="pedido/"+data.orden+"";
                        }
        }//success
    })

}
        
        
function enviarTarjeta()
{
    $('#boton_pago_tarjeta').attr("disabled", true);

    var idDireccion = $("#idDireccion").attr("value");
    var tipoPago = $("#tipoPago").attr("value");
    var subtotal = $("#subtotal").attr("value");
    var descuento = $("#descuento").attr("value");
    var envio = $("#envio").attr("value");
    var iva = $("#iva").attr("value");
    var total = $("#total").attr("value");
    var seguro = $("#seguro").attr("value");
    var usar_balance = $("#usar_balance").attr("value");
    var tipo_guia = $("#tipo_guia").attr("value");
    var peso = $("#peso").attr("value");
    var tarjeta = $("#tarjeta").attr("value");
    //var total_cobrar = "<?php //echo $total; ?>";
    var total_cobrar = "<?php echo 0; ?>";
    /* lo de la tarjeta */
    /*
    var idCard = $("#idTarjeta").attr("value"); // por ahora siempre 0, luego deberia ser el id del escogido
    var nom = $("#nombre").attr("value");
    var num = $("#numero").attr("value");
    var cod = $("#codigo").attr("value");
    var mes = $("#mes").attr("value");
    var ano = $("#ano").attr("value");
    var dir = $("#direccion").attr("value");
    var ciud = $("#ciudad").attr("value");
    var est = $("#estado").attr("value");
    var zip = $("#zip").attr("value");
    */
    if(tarjeta!="0") // el id de la tarjeta de credito que esta temporal en la pagina anterior
    {
                    $.ajax({
            type: "post",
            dataType: 'json',
            url: "credito", // action 
           /* data: { 'tipoPago':tipoPago, 'total':total, 'idCard':idCard,'nom':nom,'num':num,'cod':cod,
                            'mes':mes,'ano':ano,'dir':dir,'ciud':ciud, 'est':est,'zip':zip
                            }, */
            data: { 'tipoPago':tipoPago, 'total':total_cobrar, 'tarjeta':tarjeta
                            }, 		
            success: function (data) {

                            if(data.status==201) // pago aprobado
                            {

                                    $.ajax({
                                    type: "post",
                                    dataType: 'json',
                                    url: "comprar", // action 
                                    data: { 'idDireccion':idDireccion, 'tipoPago':tipoPago, 'subtotal':subtotal,
                                                    'descuento':descuento, 'envio':envio, 'iva':iva, 'total':total,
                                                    'usar_balance':usar_balance, 'idDetalle':data.idDetalle,'seguro':seguro,'tipo_guia':tipo_guia, 'peso':peso
                                                    }, 
                                    success: function (data) {
                                                    if(data.status=="ok")
                                                    {
                                                            window.location="pedido/"+data.orden+"";
                                                    }
                                    }//success
                                  })
                            }
                            else
                            {
                                    // no pasó la tarjeta

                                    if(data.status==400)
                                    {
                                            if(data.mensaje=="Credit card has Already Expired"){
                                                    //alert('La tarjeta que intentó usar ya expiró.');
                                                    window.location="error/1";
                                            }

                                            if(data.mensaje=="The CardNumber field is not a valid credit card number."){
                                                    //alert('El número de tarjeta que introdujó no es un número válido.');
                                                    window.location="error/2";
                                            }
                                            if(data.mensaje=="CVC Number Invalid"){
                                                    //alert('El número de tarjeta que introdujó no es un número válido.');
                                                    window.location="error/6";
                                            }							
                                    }

                                    if(data.status==401)
                                    {
                                            //alert('error de autenticacion');
                                            window.location="error/3";
                                    }

                                    if(data.status==403)
                                    {
                                            //alert('No pudimos completar su operación: '+data.mensaje);
                                            window.location="error/5";
                                    }

                                    if(data.status==503)
                                    {
                                            //alert('error interno');
                                            window.location="error/4";
                                    }
                            }

            }//success
           })

            //}
    }
    else
    {

            $.ajax({
            type: "post",
            dataType: 'json',
            url: "credito", // action 
            data: { 'tipoPago':tipoPago, 'total':total, 'idCard':idCard }, 
            success: function (data) {

                            if(data.status==201) // pago aprobado
                            {

                                    $.ajax({
                                    type: "post",
                                    dataType: 'json',
                                    url: "comprar", // action 
                                    data: { 'idDireccion':idDireccion, 'tipoPago':tipoPago, 'subtotal':subtotal,
                                                    'descuento':descuento, 'envio':envio, 'iva':iva, 'total':total,
                                                    'usar_balance':usar_balance, 'idDetalle':data.idDetalle,'seguro':seguro,'tipo_guia':tipo_guia, 'peso':peso
                                                    }, 
                                    success: function (data) {
                                                    if(data.status=="ok")
                                                    {
                                                            window.location="pedido/"+data.orden+"";
                                                    }
                                    }//success
                                  })
                            }
                            else
                            {
                                    // no pasó la tarjeta			
                                    if(data.status==400){

                                            if(data.mensaje=="Credit card has Already Expired"){
                                                    //alert('La tarjeta que intentó usar ya expiró.');
                                                    window.location="error/1";
                                            }

                                            if(data.mensaje=="The CardNumber field is not a valid credit card number."){
                                                    //alert('El número de tarjeta que introdujó no es un número válido.');
                                                    window.location="error/2";
                                            }
                                    }

                                    if(data.status==401){
                                            //alert('error de autenticacion');
                                            window.location="error/3";
                                    }

                                    if(data.status==403){
                                            //alert('No pudimos completar su operación: '+data.mensaje);
                                            window.location="error/5";
                                    }

                                    if(data.status==503){
                                            //alert('error interno');
                                            window.location="error/4";
                                    }
                            }

            }//success
           })

    }

}
	
function enviar_mp(json)
{
        $('#boton_mp').attr("disabled", true);
        //alert("return");
        var idDireccion = $("#idDireccion").attr("value");
        var tipoPago = $("#tipoPago").attr("value");
        var subtotal = $("#subtotal").attr("value");
        var descuento = $("#descuento").attr("value");
        var envio = $("#envio").attr("value");
        var iva = $("#iva").attr("value");
        var total = $("#total").attr("value");
        var seguro = $("#seguro").attr("value");
        var tipo_guia = $("#tipo_guia").attr("value");
        var peso = $("#peso").attr("value");

         if (json.collection_status=='approved'){
            alert ('Pago acreditado');
        } else if(json.collection_status=='pending'){
            alert ('El usuario no completó el pago');
            $.ajax({
                type: "post",
                dataType: 'json',
                url: "comprar", // action 
                data: { 'idDireccion':idDireccion, 'tipoPago':tipoPago, 'subtotal':subtotal, 'descuento':descuento, 'envio':envio, 'iva':iva, 'total':total, 'id_transaccion':json.collection_id,'seguro':seguro,'tipo_guia':tipo_guia, 'peso':peso}, 
                success: function (data) {

                                if(data.status=="ok")
                                {
                                        window.location="pedido/"+data.orden+"";
                                }
                }//success
           })
        } else if(json.collection_status=='in_process'){    
            alert ('El pago está siendo revisado');    

        } else if(json.collection_status=='rejected'){
            alert ('El pago fué rechazado, el usuario puede intentar nuevamente el pago');
        } else if(json.collection_status==null){
            alert ('El usuario no completó el proceso de pago, no se ha generado ningún pago');
        }

}
	
</script> 