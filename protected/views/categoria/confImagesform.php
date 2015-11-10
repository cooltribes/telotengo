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

?>

    <div class="row-fluid margin_bottom">
       <h3 class="text-center">Imagen #<?php echo $index ?></h3>
       <div class="col-md-12 text_align_center">
           <p class="note"><small>Los campos con <span class="required">*</span> son requeridos.</small></p>
            <?php echo $form->errorSummary($model); ?>
       </div>
       <div class="col-md-4 no_margin_left text_align_right">
             <?php echo $form->labelEx($model,'alt'); ?>         
       </div>
       <div class="col-md-8">
           <?php echo $form->textField($model,'alt'); ?>
		   <?php echo $form->error($model,'alt'); ?>
       </div>
       
       
       <div class="col-md-4 no_margin_left text_align_right margin_top_small">
            <?php echo $form->labelEx($model,'title'); ?>         
       </div>
       <div class="col-md-8 margin_top_small">           
            <?php echo $form->textField($model,'title'); ?>
            <?php echo $form->error($model,'title'); ?>
       </div>
       
       
       <div class="col-md-4 no_margin_left text_align_right margin_top_small">
         <?php echo $form->labelEx($model,'copy'); ?>            
       </div>
       <div class="col-md-8 margin_top_small">           
        <?php echo $form->textArea($model,'copy',array('style'=>'resize:none','rows'=>'6')); ?>

       </div>
       
       <div class="col-md-4 no_margin_left text_align_right margin_top_small">
        <?php echo $form->labelEx($model,'link'); ?>          
       </div>
       <div class="col-md-8 margin_top_small">
           <?php echo $form->textField($model,'link'); ?>
            <?php echo $form->error($model,'link'); ?>            
       </div>
       
       
       <div class="col-md-4 no_margin_left text_align_right margin_top_small">
        <?php echo $form->labelEx($model,'path'); ?>          
       </div>
       <div class="col-md-8 margin_top_small">
           <?php echo CHtml::activeFileField($model, 'path', array('required'=>'required','accept'=>'image/*'));?>
		  <?php echo $form->error($model,'path'); ?>
		  <?php if($dimError):?>
		              <span class="error"><small>La imagen debe ser de <?php echo $index==1?"1200x450 ":"380x270 " ?> pixeles</small></span>
		  
		  <?php endif; ?>
       </div>
       
       <?php
        
              echo CHtml::activeHiddenField($model,'index',array('value'=>$index));
              echo CHtml::activeHiddenField($model,'type',array('value'=>$type));
              echo CHtml::activeHiddenField($model,'group',array('value'=>$group));
              echo CHtml::activeHiddenField($model,'name',array('value'=>$name));  
              echo CHtml::activeHiddenField($model,'categoria_id',array('value'=>$categoria_id));  
         ?>               
        
    </div>
	

	<div class="buttons col-md-6 col-md-offset-3 margin_top_small">
		<?php echo CHtml::submitButton('Submit',array('class'=>'btn btn-danger btn-large form-control')); ?>
	</div>
    
<?php $this->endWidget(); ?>

</div><!-- form -->