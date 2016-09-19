<?php
/* @var $this SiteImageController */
/* @var $model SiteImage */
/* @var $form CActiveForm */
?>

<div class="form horizontal">
<div class="pointer text_align_right margin_small" title="Cerrar" onclick="$('#toLoad').modal('toggle'); ">x</div>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'site-image-form',
   
    'enableClientValidation'=>true,
   // 'type'=>'horizontal',
    'clientOptions'=>array(
        'validateOnSubmit'=>true, 
    ),
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
));

  switch ($index)
  {
    case 1:
      $name="Superior 1 Comprador";
      $medidas= "1903x381";
    break;
    case 2:
      $name="Lateral Derecho 1";
      $medidas= "294x318";
    break;
    case 3:
      $name="Lateral Derecho 2";
      $medidas= "294x513";
    break;    
    case 4:
      $name="Superior 2 Comprador";
      $medidas= "1903x381";
    break;    
    case 5:
      $name="Superior 3 Comprador";
      $medidas= "1903x381";
    break;    
    case 6:
      $name="Superior 1 Vendedor";
      $medidas= "1903x381";
    break;    
    case 7:
      $name="Superior 2 Vendedor";
      $medidas= "1903x381";
    break; 
    case 8:
      $name="Superior 3 Vendedor";
      $medidas= "1903x381";
    break;  
    case 9:
      $name="Superior 4 Vendedor";
      $medidas= "1903x381";
    break;     
  }

?>

    <div class="row-fluid margin_bottom">
       <h3 class="text-center">Imagen <?php echo $name; ?></h3>
       <div class="col-md-12 text_align_center">
           <p class="note"><small>Los campos con <span class="required">*</span> son requeridos.</small></p>
            <?php echo $form->errorSummary($model); ?>
       </div>
       <div class="row-fluid clearfix">
           <div class="col-md-4 col-sm-4 col-xs-4 no_margin_left text_align_right margin_top_small">
            <label for="Banner_ruta" class="required">Link de tienda <span class="required">*</span></label>        
           </div>
           <div class="col-md-8 col-sm-8 col-xs-8 margin_top_small">
               <?php echo $form->textField($model,'ruta'); ?>
                <?php echo $form->error($model,'ruta'); ?>            
           </div>
       </div>
       <div class="row-fluid clearfix">
           <div class="col-md-4 col-sm-4 col-xs-4 no_margin_left text_align_right margin_top_small">
            <?php echo $form->labelEx($model,'ruta_imagen'); ?>          
           </div>
           <div class="col-md-8 col-sm-8 col-xs-8 margin_top_small">
               <?php echo CHtml::activeFileField($model, 'ruta_imagen', array('required'=>'required','accept'=>'image/*'));?>
          <?php echo $form->error($model,'ruta_imagen'); ?>
          <?php if($dimError):?>
                      <span class="error"><small>La imagen debe ser de <?php echo $medidas;?> pixeles</small></span>
          
          <?php endif; ?>
           </div>
       </div>
       
       <?php
        
              echo CHtml::activeHiddenField($model,'index',array('value'=>$index));
              //echo CHtml::activeHiddenField($model,'type',array('value'=>$type));
              //echo CHtml::activeHiddenField($model,'group',array('value'=>$group));
             // echo CHtml::activeHiddenField($model,'name',array('value'=>$name));  
             // echo CHtml::activeHiddenField($model,'categoria_id',array('value'=>$categoria_id));  
         ?>               
        
    </div>
  

  <div class="buttons col-md-6 col-md-offset-3 margin_top_small">
    <?php echo CHtml::submitButton('Submit',array('class'=>'btn btn-orange white form-control margin_top_small')); ?>
  </div>
    
<?php $this->endWidget(); ?>

</div><!-- form -->