<?php Yii::app()->clientScript->registerLinkTag('stylesheet','text/css','https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,400,300,600,700',null,null);
 
$this->setPageTitle(Yii::app()->name . " - " . Yii::t('contentForm', 'Autenticación'));

?>
    <style>
        .progreso_compra_giftcard {
            width: 268px;
        }
        .progreso_compra_giftcard .last-not_done {
            text-align: center;
        }
    </style>
<div class="progreso_compra progreso_compra_giftcard margin_top">
      <div class="clearfix margin_bottom">
         <div class="first-done">Autenticación</div>        
         <div class="middle-not_done"> Metodo <br> de pago</div>
         <div class="last-not_done">Confirmar <br> compra</div>
      </div>
  </div>

<!-- FLASH ON --> 
<?php $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
            'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        ),
    )
); ?>	
<!-- FLASH OFF -->
	
  <div class="row">
    <div class="col-md-6 col-md-offset-3">

      <h1>Confirma tus datos: </h1>
        <article class="bg_color3 margin_top  margin_bottom_small padding_small box_1 text_align_center">
        <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
          'id'=>'login-form',
          'htmlOptions'=>array('class'=>'personaling_form'),
            //'type'=>'stacked',
          'type'=>'inline',
          'enableClientValidation'=>true,
          'clientOptions'=>array(
            'validateOnSubmit'=>true, 
          ),
        )); ?>
        <fieldset>
        <div class="control-group">
       	  <div class="controls"> 
      		  <?php echo $form->textFieldRow($model,'username',array("class"=>"col-md-5 col-md-offset-2","value"=>Yii::app()->user->name,'readonly'=>true)); ?>
            <?php echo $form->error($model,'username'); ?>
          </div>  
        </div>
        <div class="control-group"> 
          <div class="controls">
        		<?php echo $form->passwordFieldRow($model,'password',array(
        			'class'=>'col-md-5 col-md-offset-2',
        			'value'=>'',
      				//'hint'=>'Hint: You may login with <kbd>demo</kbd>/<kbd>demo</kbd> or <kbd>admin</kbd>/<kbd>admin</kbd>',
    				)); ?>
    				<?php echo $form->error($model,'password'); ?>
    			</div>
    		</div>            

        <div class="">
    		<?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'danger',
            'size'=>'large',
            'label'=>"Siguiente",
            'htmlOptions'=>array('class'=>'col-md-5 col-md-offset-2'),
        )); ?>
        </div>
        </fieldset>
        <?php $this->endWidget(); ?>
      </article>
    </div>
  </div>
</div>