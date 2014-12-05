<?php Yii::app()->clientScript->registerLinkTag('stylesheet','text/css','https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,400,300,600,700',null,null);
 
$this->setPageTitle(Yii::app()->name . " - Autenticación");
?>
    <style>
        .progreso_compra_giftcard {
            width: 268px;
        }
        .progreso_compra_giftcard .last-not_done {
            text-align: center;
        }
    </style>

<div class="container">
  <div class="row">
    <div class="col-md-offset-4 col-md-4"> 

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

      <h1>Confirma tus datos: </h1>
       
        <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
          'id'=>'login-form',
          'enableClientValidation'=>true,
          'enableAjaxValidation'=>false,
          'clientOptions'=>array(
            'validateOnSubmit'=>true, 
          ),
        ));
        ?>

        <?php echo $form->errorSummary($model); ?>
        
        <div class="form-group">
          <?php echo $form->textFieldRow($model,'username',array("class"=>"form-control","value"=>Yii::app()->user->name,'readonly'=>true)); ?>
          <?php echo $form->error($model,'username'); ?>
          <?php // echo $form->textField($model,'username', array('class'=>'form-control','placeholder'=>'Username or Email') ) ?>
        </div>

        <div class="form-group">
          <?php echo $form->passwordFieldRow($model,'password', array('class'=>'form-control','placeholder'=>'Password')); ?>
          <?php echo $form->error($model,'password'); ?>
        </div>         

        <div class="submit">
    		<?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'danger',
            'size'=>'large',
            'label'=>"Continuar",
            'htmlOptions'=>array('class'=>'btn btn-primary btn-lg form-control'),
        )); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div>
  </div>
</div>