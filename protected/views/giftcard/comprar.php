<?php
/* @var $this GiftcardController */
/* @var $model Giftcard */

$this->breadcrumbs = array(
    'Comprar GiftCard',
);
?>
<div class="container">

    <!-- FLASH ON --> 
    <?php
    $this->widget('bootstrap.widgets.TbAlert', array(
        'block' => true, // display a larger alert block?
        'fade' => true, // use transitions?
        'closeText' => '&times;', // close link text - if set to false, no close link is displayed
        'alerts' => array(// configurations per alert type
            'success' => array('block' => true, 'fade' => true, 'closeText' => '&times;'), // success, info, warning, error or danger
            'error' => array('block' => true, 'fade' => true, 'closeText' => '&times;'), // success, info, warning, error or danger
        ),
            )
    );
    ?>	
    <!-- FLASH OFF --> 
    <h1>Compra una Gift Card</h1>
    <section class="bg_color3  span12 margin_bottom_small padding_medium box_1">
        <?php
        $form = $this->beginWidget("bootstrap.widgets.TbActiveForm", array(
            'id' => 'form-enviarGift',
            'type' => 'horizontal',
            'clientOptions' => array(
                'validateOnSubmit' => true,
            )
        ));
        ?>
            <div class="row margin_top">
                <div class="col-md-6">
                    <div>
                        <p class="lead">1. Selecciona un diseño para la Gift Card </p>
                        <ul class="thumbnails" id="plantillas">
                            <li class="active" id="GC-gift_card_one">
                                <a href="#">
                                <div>
                                    <img src="<?php echo Yii::app()->baseUrl; ?>/images/giftcards/GIFTCARD-xmas-200x123.jpg">
                                    </div>
                                </a>
                            </li>		
                            <?php echo $form->hiddenField($model, 'plantilla_url'); ?>
                        </ul>
                    </div>
                <div class="row-fluid">
                <br/>
                <p class="lead">2. Seleccione el monto</p>
                    <?php echo $form->errorSummary($model); ?>
                        <div class="control-group">
                            <label class="control-label required" for="BolsaGC_monto">Monto.
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-3">
                                <span class="add-on">Bs.</span>
                                <?php echo CHtml::activeDropDownList($model, 'monto', Giftcard::getMontos(), array('class' => 'col-md-1 form-control',)); ?>
                            </div>
                        </div>
                </div>
                <div>
                    <p class="lead">3. Personalízala.</p>                                       
                    <?php
                        echo $form->textFieldRow($envio, 'nombre', array(
                            'placeholder' => "Nombre del beneficiario",
                            'class'=>"form-control"
                        ));
                    ?>                                        
                    <?php
                        echo $form->textAreaRow($envio, 'mensaje', array(
                            'placeholder' => "Mensaje", 'maxlength' => '150','class'=>"form-control"));
                    ?>
                    <br/>
                    <p class="lead">
                    4. ¿A quién la envías?
                    </p>
                        <input type="hidden" name="entrega" value="2" >
                        <?php
                            echo $form->textFieldRow($envio, 'email', array(
                                'placeholder' => 'Correo electrónico del destinatario',
                                'class'=>"form-control"
                            ));
                        ?>  
                        <div class="control-group margin_top_large text_align_center">
                            <?php
                            $this->widget('bootstrap.widgets.TbButton', array(
                                'buttonType' => 'submit',
                                'label' => 'Comprar',
                                'icon' => 'shopping-cart white',
                                'type' => 'success',
                                'size' => 'large', 
                                'htmlOptions' => array('class'=>"form-control"),
                                    )
                            );
                            ?>   
                        </div>      
                </div>

            </div>	
                <div class="col-md-5 box_shadow_personaling padding_medium">
                    <div class="contenedorPreviewGift" >
                        <img src="<?php echo Yii::app()->baseUrl; ?>/images/giftcards/GIFTCARD-xmas-470x288.jpg" width="470">
                        <div class="row-fluid margin_top">
                            <div class="span6 braker_right">
                                <div class=" T_xlarge color4" id="monto"><?php echo $model->monto." Bs."; ?> </div>
                                <div class="margin_top color4" id="codigo"><div class="color9">Código</div> <?php echo "XXXX-XXXX-XXXX-XXXX"; ?> </div>
                            </div>
                            <div class="span6">
                                <strong  id="forpara">Para:</strong>&nbsp;<span id="para"></span>
                                <div>
                                    <strong  id="formensaje">Mensaje:</strong>&nbsp;<span class="" id="mensaje"></span>
                                </div>                        
                            </div>
                        </div>
                        <div class="text_center_align margin_bottom_minus margin_top_small">
                            <span class=" t_small" id="fecha">
                                <?php
                                    $now = date('Y-m-d', strtotime('now'));
                                    echo 'Valido desde <strong>';
                                    echo date('Y-m-d', strtotime('now'));
                                    echo '</strong>';
                                    //hasta <strong>'.date('Y-m-d', strtotime('+1 year')).'</strong>';
                                ?>
                                 </strong>
                            </span>                        
                        </div>
                    </div> 
                </div>
            </div>
        </fieldset>
<?php $this->endWidget(); ?> 
    </section>
</div>
<script>

    $('#EnvioGiftcard_nombre').keyup(function() {
        $('#para').text($('#EnvioGiftcard_nombre').val());
    });

    $('#EnvioGiftcard_nombre').focusout(function() {
        $('#para').text($('#EnvioGiftcard_nombre').val());
    });

    $('#EnvioGiftcard_mensaje').keyup(function() {
        $('#mensaje').text($('#EnvioGiftcard_mensaje').val());
    });

    $('#EnvioGiftcard_mensaje').focusout(function() {
        $('#mensaje').text($('#EnvioGiftcard_mensaje').val());
    });
    $('#EnvioGiftcard_mensaje').change(function() {
        $('#mensaje').text($('#EnvioGiftcard_mensaje').val());
    });

    /*Para actualizar el monto al cambiar el dropdown*/
    $('#<?php echo CHtml::activeId($model, "monto") ?>').change(function() {
        $('#monto').text($('#<?php echo CHtml::activeId($model, "monto") ?>').val() + " Bs.");
    });

    $('#plantillas li').click(function(e) {

        $("body").addClass("aplicacion-cargando");
        $(this).siblings().removeClass('active');
        $(this).addClass('active');

        var urlImg = $(this).attr('id');
        urlImg = urlImg.split("-");
        
        $('#<?php echo CHtml::activeId($model, "plantilla_url") ?>').val(urlImg[1]);

        $(".contenedorPreviewGift img").attr("src",
                "<?php echo Yii::app()->baseUrl; ?>/images/giftcards/" + urlImg[1] + "_x470.jpg");
                
        e.preventDefault();
        

    });
    
    $(".contenedorPreviewGift img").load(function(e){
        $("body").removeClass("aplicacion-cargando");
    });


</script>
<style>
    .contenedorPreviewGift{

        font-family: arial,sans-serif;
    }
    #plantillas li.active{
        /*border: solid 2px blue;*/
    }
</style>
