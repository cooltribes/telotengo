<!-- tipopago 1: transferencia
     tipopago 2: Tarjeta credito
     tipopago 3: puntos o tarjeta de regalo -->
<?php
Yii::app()->clientScript->registerLinkTag('stylesheet','text/css','https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,400,300,600,700',null,null);
$this->setPageTitle(Yii::app()->name . " - Método de pago");

if (!Yii::app()->user->isGuest) { // que este logueado 
?>
<style>
    .progreso_compra_giftcard {
        width: 268px;
    }
    .progreso_compra_giftcard .last-not_done {
        text-align: center;
    }
</style>

<div class="container margin_top">
    <div class="row">
        <section class="col-md-offset-2 col-md-8">
        <!-- Forma de pago ON -->
        <div class="box_1 padding_small margin_bottom">
            <h3 class="braker_bottom_small">Escoge el método de pago</h3>
            <hr/>
                <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                        'id'=>'tarjeta-form', 
                        'enableAjaxValidation'=>false,
                        'enableClientValidation'=>true,
                        'clientOptions'=>array(
                                'validateOnSubmit'=>true, 
                        ),
                        'htmlOptions'=>array('class'=>''),
                    )); 
                ?>      
                
       <div class="accordion" id="accordion2">	
            <!-- DEPOSITO O TRANSFERENCIA -->
            <div class="accordion-group">
                <div class="accordion-heading">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo" id="btn_deposito">
                        <label class="radio">
                            <input type="radio" name="optionsRadios" id="deposito" value="option1"> 
                            Depósito o Transferencia
                        </label>
                    </a>
                </div>
                <div class="padding_left margin_bottom_medium collapse" id="collapseTwo">
                    <div class="well well-small" >
                        <?php  
                            $datos = TipoPago::model()->datosDeposito();
                            echo $datos;
                        ?>
                    </div>
                </div>
            </div>
                
                <?php 
                //INSTAPAGO
                /*
                if(Yii::app()->params['metodosPago']['instapago']){                 
                ?>
                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTree" id="btn_tarjeta">
                                <label class="radio">
                                    <input type="radio" name="optionsRadios" id="tarjeta" value="option2"> 
                                    <?php echo Yii::t('contentForm', 'Credit Card'); ?>

                                </label>
                            </a>
                        </div>
                        <div class="collapse" id="collapseTree">
                            <div class="well well-small" >
                                <!-- Haz click en "Completar compra" para continuar. <?php //echo 'Pago: '.Yii::app()->getSession()->get('tipoPago');  ?> -->
                                <h5 class="braker_bottom"><?php echo Yii::t('contentForm', 'Details of your credit card'); ?></h5>            
                                <div class="control-group"> 
                                    <div class="controls">
                                        <?php echo $form->textFieldRow($tarjeta, 'nombre', array('class' => 'span5', 'placeholder' => Yii::t('contentForm', 'Name printed on the credit card')));
                                        ?>
                                        <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
                                    </div>
                                </div>

                                <div class="control-group"> 
                                    <div class="controls">
                                        <?php echo $form->textFieldRow($tarjeta, 'numero', array('class' => 'span5', 'placeholder' => Yii::t('contentForm', 'Card numbers')));
                                        ?>
                                        <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
                                    </div>
                                </div>

                                <div class="control-group"> 
                                    <div class="controls">
                                        <?php echo $form->textFieldRow($tarjeta, 'codigo', array('class' => 'span2', 'placeholder' => Yii::t('contentForm', 'Security Code')));
                                        ?>
                                        <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <?php echo Yii::t('contentForm', 'Expiration'); ?> *
                                    <div class="controls">
                                        <?php echo $form->dropDownList($tarjeta, 'month', array('0' => 'Mes', '01' => '01', '02' => '02', '03' => '03', '04' => '04', '05' => '05', '06' => '06', '07' => '07', '08' => '08', '09' => '09', '10' => '10', '11' => '11', '12' => '12'), array('class' => 'span1', 'placeholder' => Yii::t('contentForm', 'Month'))); ?>
                                        <?php echo $form->dropDownList($tarjeta, 'year', array('0' => 'Año', '2014' => '2014', '2015' => '2015', '2016' => '2016', '2017' => '2017', '2018' => '2018', '2019' => '2019', '2020' => '2020', '2021' => '2021'), array('class' => 'span1', 'placeholder' => Yii::t('contentForm', 'Year'))); ?>
                                        <?php echo $form->hiddenField($tarjeta, 'vencimiento'); ?> 
                                        <?php echo $form->error($tarjeta, 'vencimiento'); ?>

                                    </div>
                                </div>

                                <div class="control-group"> 
                                    <div class="controls">
                                        <?php echo $form->textFieldRow($tarjeta, 'ci', array('class' => 'span5', 'placeholder' => Yii::t('contentForm', 'Identity card')));
                                        ?>
                                        <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
                                    </div>
                                </div>

                                <div class="control-group"> 
                                    <div class="controls">
                                        <?php echo $form->textFieldRow($tarjeta, 'direccion', array('class' => 'span5', 'placeholder' => Yii::t('contentForm', 'Address')));
                                        ?>

                                    </div>
                                </div>            	

                                <div class="control-group"> 
                                    <div class="controls">
                                        <?php echo $form->textFieldRow($tarjeta, 'ciudad', array('class' => 'span5', 'placeholder' => Yii::t('contentForm', 'City')));
                                        ?>

                                    </div>
                                </div>			

                                <div class="control-group"> 
                                    <div class="controls">
                                        <?php echo $form->textFieldRow($tarjeta, 'estado', array('class' => 'span5', 'placeholder' => Yii::t('contentForm', 'Province')));
                                        ?>
                                        <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
                                    </div>
                                </div>	

                                <div class="control-group"> 
                                    <div class="controls">
                                        <?php echo $form->textFieldRow($tarjeta, 'zip', array('class' => 'span2', 'placeholder' => Yii::t('contentForm', 'Zip code')));
                                        ?>
                                        <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
                                    </div>
                                </div>		          					

                                <?php echo CHtml::hiddenField('idDireccion', Yii::app()->getSession()->get('idDireccion'));
                                $direccion = Direccion::model()->findByPk(Yii::app()->getSession()->get('idDireccion'));
                                ?>
                                <div class="text_center_align">
                                    <p><?php echo Yii::t('contentForm', 'This transaction will be processed securely through the platform:'); ?>:</p>	
                                    <img src="<?php echo Yii::app()->baseUrl ?>/images/Instapago-logo.png" width="77">
                                    <img src="<?php echo Yii::app()->baseUrl ?>/images/Banesco-logo.png" width="77">
                                </div>								
                                <div class="form-actions">
                                    <?php
                                    $this->widget('bootstrap.widgets.TbButton', array(
                                        'buttonType' => 'submit',
                                        'type' => 'warning',
                                        'size' => 'large',
                                        'label' => Yii::t('contentForm', 'Next'),
                                    ));
                                    //  <a href="Proceso_de_Compra_3.php" class="btn-large btn btn-danger">Usar esta dirección</a> 
                                    ?>
                                </div>


                            </div>	
                        </div>
                    </div>
                <?php } */?>
                
           </div> 
           <input type="hidden" id="tipo_pago" name="tipo_pago" value="5" />
            <?php 
             $this->endWidget();
            ?>
        </div>
    </section>

    <div class="col-md-offset-2 col-md-8">
        <div>
            <div id="resumen" class="well">
                <h4>Resumen de la compra</h4>
                    <div class=" margin_bottom">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed " id="tabla_resumen">
                    <tr>
                        <th class="text_align_left"><?php echo Yii::t('contentForm','Subtotal'); ?>:</th>
                        <td>
                        <?php
                            echo 'Bs. '.Yii::app()->numberFormatter->formatCurrency($total, '');
                        ?>
                        </td>
                    </tr> 
                    <tr>
                        <th class="text_align_left"><h4>Total:</h4></th>
                        <td class="text_align_right">
                            <h4 id="precio_total">
                            <?php echo 'Bs. '.Yii::app()->numberFormatter->formatCurrency($total, ''); ?>
                            </h4>
                        </td>
                    </tr>
                </table>
            <div class="form-actions">
                <?php $this->widget('bootstrap.widgets.TbButton', array(
    	            'type'=>'danger',
    	            'size'=>'large',
    	            'label'=>'Siguiente',
    	            //'url'=>'confirmar', // action
    	            'icon'=>'lock white',
    	            'buttonType'=>'submit', 
    	            'htmlOptions'=>array('id'=>'btn-siguiente',),
    	        ));
            
                ?>
            </div>
          </div>
        </div>
      </div>
      		      

    </div>
  </div>
</div>
<!-- /container -->
<?php

}// si esta logueado
else{
    // redirecciona al login porque se murió la sesión
    //header('Location: /user/login');
    $url = CController::createUrl("/user/login");
    header('Location: '.$url);
}
?>
<script>  
//Mostrar alert
function showAlert(type, message){
   $('#alert-msg').removeClass('alert-success alert-error alert-warning') ;
   $('#alert-msg').addClass("alert-"+type);
   $('#alert-msg').children(".msg").html(message);
   $('#alert-msg').show();

   $("#camposGC").removeClass('success error warning');
   $('#camposGC').addClass(type);
}

$(".alert").alert();
$(".alert .close").click(function(){
    $(".alert").fadeOut('slow');
});
        
        
$(document).ready(function() {

//Boton siguiente - General para todos los metodos de pago        
$("#btn-siguiente").click(function(e){
    $("#tarjeta-form").submit();
});

////***** RAFA ******///////
$('#TarjetaCredito_month').change(function(){
	if (($('#TarjetaCredito_year').val()!=0) && ($('#TarjetaCredito_month').val()!=0))
		//alert('hola');
		//alert($('#TarjetaCredito_month').val()+'/'+ $('#TarjetaCredito_year').val())
		$('#TarjetaCredito_vencimiento').val( $('#TarjetaCredito_month').val()+'/'+ $('#TarjetaCredito_year').val() );
	
});
$('#TarjetaCredito_year').change(function(){
	if (($('#TarjetaCredito_year').val()!=0) && ($('#TarjetaCredito_month').val()!=0))
		//alert('hola');
		//alert($('#TarjetaCredito_month').val()+'/'+ $('#TarjetaCredito_year').val())
		$('#TarjetaCredito_vencimiento').val($('#TarjetaCredito_month').val()+'/'+$('#TarjetaCredito_year').val());
	
});
///******** FIN RAFA **********//////
        $("#deposito").click(function() {
        	
            var añadir = "<td valign='top'><i class='icon-exclamation-sign'></i> Depósito o Transferencia Bancaria.</td>";
            $("#adentro").html(añadir);
            $("#tipo_pago").val('1');
            $("#deposito").prop("checked", true);
            // haciendo que no valide
	        disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'nombre');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'numero');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'codigo');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'ci');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'direccion');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'ciudad');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'estado');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'zip');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'month');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'year');
            disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'vencimiento');
            
        });
        
        $("#mercadopago").click(function() {
            var añadir = "<td valign='top'><i class='icon-exclamation-sign'></i> MercadoPago.</td>";
            $("#adentro").html(añadir);
            $("#tipo_pago").val('4');
             $("#mercadopago").attr('checked', true);
            // haciendo que no valide
	        disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'nombre');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'numero');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'codigo');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'ci');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'direccion');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'ciudad');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'estado');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'zip');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'month');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'year');
            disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'vencimiento'); 
            
        });
        
        $("#tarjeta").click(function() {
            var añadir = "<td valign='top'><i class='icon-exclamation-sign'></i> Tarjeta de Crédito.</td>";
            $("#adentro").html(añadir);
            $("#tipo_pago").val('2');
            $("#tarjeta").attr('checked', true);

            enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'nombre');
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'numero');
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'codigo');
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'ci');
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'direccion');
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'ciudad');
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'estado');
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'zip');
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'month');
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'year');
            enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'vencimiento');
            
        });
        
        $("#btn_mercadopago").click(function() {
            var añadir = "<td valign='top'><i class='icon-exclamation-sign'></i> MercadoPago.</td>";
            $("#adentro").html(añadir);
            $("#tipo_pago").val('4');
            $("#mercadopago").prop("checked", true);
        });
        $("#btn_deposito").click(function() {
        	var añadir = "<td valign='top'><i class='icon-exclamation-sign'></i> Depósito o Transferencia Bancaria.</td>";
            $("#adentro").html(añadir);
        	//$("#deposito").attr('checked', 'checked');
        	$("#deposito").prop("checked", true);
        	$("#tipo_pago").val('1');
        	 
        	// haciendo que no valide
	        disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'nombre');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'numero');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'codigo');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'ci');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'direccion');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'ciudad');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'estado');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'zip');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'month');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'year');
            disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'vencimiento'); 
        });
        
        $("#btn_tarjeta").click(function() {
        	 var añadir = "<td valign='top'><i class='icon-exclamation-sign'></i> Tarjeta de Crédito.</td>";
            $("#adentro").html(añadir);
        	$("#tarjeta").prop("checked", true);
        	$("#tipo_pago").val('2');
        	
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'nombre');
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'numero');
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'codigo');
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'ci');
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'direccion');
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'ciudad');
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'estado');
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'zip');
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'month');
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'year');
            enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'vencimiento');
        	
        });

    });
    
    function tarjetas()
    {
            //alert("Entró");
            /* lo de la tarjeta */
            //alert($("#tipo_pago").attr("value"));

            if($("#tipo_pago").attr("value") == 2){ // tarjeta

                    var nom = $("#nombre").attr("value");
                    var num = $("#numero").attr("value");
                    var cod = $("#codigo").attr("value");
                    var ci = $("#ci").attr("value");
                    var mes = $("#mes").attr("value");
                    var ano = $("#ano").attr("value");
                    var dir = $("#direccion").attr("value");
                    var ciud = $("#ciudad").attr("value");
                    var est = $("#estado").attr("value");
                    var zip = $("#zip").attr("value");

                    if(nom=="" || num=="" || cod=="" || mes=="Mes" || ano=="Ano" || ci=="" || dir=="" || ciud=="" || est=="" || zip==""){
                            alert("Por favor complete los datos de la tarjeta.");
                    }
                    else{
                            // alert(" nombre: "+nom+", numero"+num+", cod:"+cod+", mes y año "+mes+"-"+ano+", dir "+dir+", ciudad "+ciud+", estado "+est+", zip"+zip);
                            $("#datos_tarjeta").submit();
                    }

            }
            else
            {
                    $("#datos_tarjeta").submit();
            }

    }
	
    function enableFieldsValidation(form, model, fieldName) {

        // Restore validation for model attributes
        $.each(form.data('settings').attributes, function (i, attribute) {

            if (attribute.model == model && attribute.id == (model + '_' + fieldName))
            {
                if (attribute.hasOwnProperty('disabledClientValidation')) {

                    // Restore validation function
                    attribute.clientValidation = attribute.disabledClientValidation;
                    delete attribute.disabledClientValidation;

                    // Restore sucess css class
                    attribute.successCssClass = attribute.disabledSuccessCssClass;
                    delete attribute.disabledSuccessCssClass;
                }
            }
        });
    }
	
    function disableFieldsValidation(form, model, fieldName) {

        $.each(form.data('settings').attributes, function (i, attribute) {

            if (attribute.model == model && attribute.id == (model + '_' + fieldName))
            {
                if (!attribute.hasOwnProperty('disabledClientValidation')) {

                    // Remove validation function
                    attribute.disabledClientValidation = attribute.clientValidation;
                    delete attribute.clientValidation;

                    // Reset style of elements
                    $.fn.yiiactiveform.getInputContainer(attribute, form).removeClass(
                        attribute.validatingCssClass + ' ' +
                        attribute.errorCssClass + ' ' +
                        attribute.successCssClass
                    );

                    // Reset validation status
                    attribute.status = 2;

                    // Hide error messages
                    form.find('#' + attribute.errorID).toggle(false);

                    // Dont make it 'green' when validation is called
                    attribute.disabledSuccessCssClass = attribute.successCssClass;
                    attribute.successCssClass = '';
                }
            }
        });
    }
	
</script>
