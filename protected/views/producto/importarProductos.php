<div class="container">
    <div class="row-fluid margin_top_small">
        <div class="col-md-10 col-md-offset-1"> 
    
     	<!-- FLASH ON -->
        <?php if(Yii::app()->user->hasFlash('success')){?>
            <div class="alert in alert-block fade alert-success text_align_center">
                <?php echo Yii::app()->user->getFlash('success'); ?> 
            </div>
        <?php } ?>
        <?php if(Yii::app()->user->hasFlash('error')){?>
            <div class="alert in alert-block fade alert-error text_align_center">
                <?php echo Yii::app()->user->getFlash('error'); ?>
            </div>
        <?php } ?>
		<!-- FLASH OFF --> 
    	<?php
        ///echo ini_get('memory_limit');
        ?>
        <div>
            <h1>Importar productos</h1>
        </div>
        <div class="bg_color3 margin_bottom_small padding_small box_1">
            <?php
            $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    //'action' => CController::createUrl('importar'),
                    'id' => 'form-validar',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'htmlOptions' => array('enctype' => 'multipart/form-data'),
                ));
            ?>
            <fieldset>                
                <legend>Subir archivo: </legend>
                <div class="well col-md-5">
                    <?php
                    $this->widget('CMultiFileUpload', array(
                        'name' => 'archivoCarga',
                        'accept' => 'xls|xlsx|csv', // useful for verifying files
                        'duplicate' => 'El archivo está duplicado.', // useful, i think
                        'denied' => 'Tipo de archivo inválido.', // useful, i think
                    ));
                    ?>
                    <div class="margin_top_small">	              		    
                        <?php
                        $this->widget('bootstrap.widgets.TbButton', array(
                            'buttonType' => 'submit',
                            'type' => 'danger',
                            'icon' => 'upload white',
                            'label' => 'Cargar Archivo',
                            'loadingText'=>'Cargando ...',
                            'htmlOptions' => array(
                                'name' => 'cargar',
                                'id'=>'buttonCargaMD', 
                            ),
                        ));
                        ?>
                    </div>
                </div>
            </fieldset>
            <?php $this->endWidget(); ?>
        </div>	
        </div>
    </div>
</div>
<script type="text/javascript">

$('#buttonCargaMD').click(function(e) {
    var btn = $(this);
    var res = confirm("El archivo será cargado.\n¿Está seguro de proceder?");
    if (res == true) {
        btn.button('loading'); // call the loading function
        $("body").addClass("aplicacion-cargando");
    } else {
       e.preventDefault();
    }
    
});

</script>