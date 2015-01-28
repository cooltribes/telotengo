<?php
/* @var $this GiftcardController */
/* @var $model Giftcard */


$this->breadcrumbs=array(
	'Gift Card'=>array('admin'),
	'Generar',
);

?>
<div class="container">
	<h1>Generar Gift Card</h1>
	<hr class="no_margin_top">
	
	<section class="bg_color3  span9 offset1 margin_bottom_small padding_small box_1">
            <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                'id'=>'giftcard-form',
                //'enableAjaxValidation' => tr- .  m          ue,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'htmlOptions' => array(
                 // 'class' => 'form-horizontal',
                ),
                'type' => 'horizontal',
            )); ?> 
    

		<fieldset>

                        
                         <?php echo $form->errorSummary($model); ?>
                        
                        <div class="control-group input-prepend<?php echo $model->hasErrors("monto")?" error":""; ?>">
                            <label class="control-label required" for="Giftcard_monto"> Monto <span class="required">*</span>
                            </label>
                            <div class="controls">
                                <span class="add-on">Bs.</span>
                                <?php echo CHtml::activeDropDownList($model, 'monto', 
                                        Giftcard::getMontos(), array('class' => 'col-md-1')); ?>
                            </div>
                        </div>
                        
                        <div class="control-group input-prepend<?php echo $model->hasErrors("monto")?" error":""; ?>">
                            <label class="control-label required"> Valido desde <span class="required">*</span>
                            <?php
                                $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                    'model' => $model,
                                    'attribute' => "inicio_vigencia",
                                    'language' => 'es',
                                    // additional javascript options for the date picker plugin
                                    'options'=>array(
                                        'showAnim'=>'fold',
                                        'dateFormat'=>'yy-mm-dd',
                                    ),
                                ));

                            ?>
                            </label>
                        </div>

                        <div class="control-group input-prepend<?php echo $model->hasErrors("monto")?" error":""; ?>">
                            <label class="control-label required"> Valido Hasta <span class="required">*</span>
                            <?php
                                $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                    'model' => $model,
                                    'attribute' => "fin_vigencia",
                                    'language' => 'es',
                                    // additional javascript options for the date picker plugin
                                    'options'=>array(
                                        'showAnim'=>'fold',
                                        'dateFormat'=>'yy-mm-dd',
                                    ),
                                ));

                            ?> 
                            </label>
                        </div>
                        <div>
                        <?php echo $form->textFieldRow($model, 'beneficiario', array(
                            'placeholder' => 'email del destinatario'
                        )); ?>      
                        </div>
			<div class="control-group row">
				<div class="controls pull-right">  
                    <button type="submit" name="Enviar" class="btn btn-danger"><i class="icon-gift icon-white"></i> Enviar Gift Card </button>
				</div>
			</div>
		</fieldset>

            <?php $this->endWidget(); ?>
        </section>
</div>
</div>
<script type="text/javascript">
	    
        $('#<?php echo CHtml::activeId($model, 'inicio_vigencia') ?>').datepicker({
            dateFormat: "dd-mm-yy",
            minDate: 0,            
            onSelect: function(selected) {
                        $("#<?php echo CHtml::activeId($model, 'fin_vigencia') ?>").datepicker(
                                "option","minDate", selected);
                        console.log(selected);
                        }
        });
        
        //$('#<?php echo CHtml::activeId($model, 'inicio_vigencia') ?>').datepicker("setDate", "0");
        var inicio = $('#<?php echo CHtml::activeId($model, 'inicio_vigencia') ?>').datepicker("getDate");
        //console.log(inicio);        
        
        $('#<?php echo CHtml::activeId($model, 'fin_vigencia') ?>').datepicker({
            dateFormat: "dd-mm-yy",
            minDate: 0,
        });
        
        if(inicio != null){
           $("#<?php echo CHtml::activeId($model, 'fin_vigencia') ?>").datepicker(
                                "option","minDate", inicio);
                        
        }
        
        
	
</script>
