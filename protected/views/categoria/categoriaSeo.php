<!-- FLASH ON -->
<script>
    var related = new Array();
    
</script>
<?php 

 $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array( 
	'id'=>'categoria-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true, 
	),
	'htmlOptions'=>array('class'=>'form-stacked form-horizontal','enctype' => 'multipart/form-data'),
));

?>

<input id="accion" type="hidden" value="" />	


<div class="container margin_top">
  <div class="page-header">
    <h1>Categorias Relacionadas</small></h1>
    <h2 ><?php echo $categoria->nombre?></h2>
  </div>
  <!-- SUBMENU ON -->
  <input id="categoria" type="hidden" value="<?php echo $categoria->id ?>" />
  <?php echo $this->renderPartial('menu', array('model'=>$categoria,'opcion'=>8)); ?> 
  <!-- SUBMENU OFF -->
  <?php 
  Yii::app()->session['id']=$categoria->id;
$this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
            'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        ),
    )
); 

  ?>
  <div class="row margin_top">
        <div class="form row-fluid">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'seo-form-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly. 
    // See class documentation of CActiveForm for details on this,
    // you need to use the performAjaxValidation()-method described there.
    'enableAjaxValidation'=>false,
)); ?>



    <?php echo $form->errorSummary($model); ?>

    <div class="col-md-6 col-md-offset-3 margin_top">
        <?php echo $form->labelEx($model,'descripcion'); ?>
        <?php echo $form->textField($model,'descripcion',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'descripcion'); ?>
    </div>
 
    <div class="col-md-6 col-md-offset-3 margin_top">
        <?php echo $form->labelEx($model,'tags'); ?>
        <?php echo $form->textField($model,'tags',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'tags'); ?>
    </div>

    <div class="col-md-6 col-md-offset-3 margin_top">
        <?php echo $form->labelEx($model,'amigable'); ?>
        <?php echo $form->textField($model,'amigable',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'amigable'); ?>
    </div>


    <div class="col-md-6 col-md-offset-3 margin_top">
        <?php echo CHtml::submitButton('Guardar',array('class'=>'form-control btn btn-danger')); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
  </div>
</div>
<!-- /container -->
<?php $this->endWidget(); ?>
<script>
	$(document).ready(function(){
	
	jQuery.each($('.idsCategorias'), function() {

		var id = $(this).attr('value');
    	$('#cat-'+id).attr('checked',true);
   	});	
   	
       	$('.itemCheck').click(function(event){ 
        
            if($(this).is(':checked')){
                if(related.indexOf($(this).val())==-1){
                    related.push($(this).val());
                }   
            }else{
                if(related.indexOf($(this).val())!=-1){
                    related.splice(related.indexOf($(this).val()),1);
                } 
                
            }
        });
        
        	
		
	               
	});
	
    
	
</script> 