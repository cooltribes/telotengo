<head>
        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">
        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <title>Telotengo</title>

        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>

</head>



<img src="<?php echo Yii::app()->theme->getBaseUrl()."/images/layout/b2b/background.jpg"?>" style="width:100%; z-index:0; height:100%; position:fixed;"?>
<style>
    .loginError{
        margin-top:-16px;
    }
    .loginError .help-block.error{
        margin-top: 2px;
        margin-bottom: 2px;
        text-align: center !important;
    }
</style>


<div class="row-fluid darkpanel" style="position: fixed">
    <div class="col-md-8 col-md-offset-2">
        
        <!-- BARRA SUPERIOR -->
    <div class="row-fluid padding_top_small clearfix"> 
        <div class="col-md-6" style="text-align: center">

                    <div style="width:300px; height:50px;">
                        <img src="<?php echo Yii::app()->theme->baseUrl;?>/images/layout/whitelogo.png" width="65%"/>
                    </div>
             
        </div>
        
        
         
                
        <div class="col-md-6" style="text-align: center">
            <div class="row-fluid">
                <?php 
                
                $loginLayoutModel=new UserLogin;
                $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id'=>'login-form',
                    'htmlOptions'=>array('class'=>''),
                    'type'=>'inline',
                    'enableClientValidation'=>false,
                    'enableAjaxValidation'=>true,
                    'clientOptions'=>array(
                        'validateOnSubmit'=>true,
                    ),
                )); ?>
                <input type="text" style="display:none"/>
                 <input type="password" style="display:none"/>
                <div class="col-md-4">
                    <?php // echo CHtml::activeLabelEx($loginLayoutModel,'username'); ?>
                            <?php echo $form->textFieldRow($loginLayoutModel,'username',array("class"=>"form-control no-radius","placeholder"=>"correoelectronico@cuenta.com")); ?>
                            
                </div>
                <div class="col-md-4">
                     <?php //echo CHtml::activeLabelEx($loginLayoutModel,'password'); ?>
                            <?php echo $form->passwordFieldRow($loginLayoutModel,'password',array('class'=>'form-control no-radius')); ?>
                            <span class="help-block muted text_align_right padding_right">
                            
                </div>
                <div class="col-md-4">
                    <?php $this->widget('bootstrap.widgets.TbButton', array(
                        'buttonType'=>'submit',
                        'type'=>'danger',
                        'size'=>'large',
                        'label'=>"Ingresa",
                        'htmlOptions'=>array('class'=>'btn-block btn-orange'),
                    )); ?>
                    <div style="height:25px; ">
                         <?php echo CHtml::link("Recuperar contraseña",Yii::app()->getModule('user')->recoveryUrl,array("class"=>"white-link")); ?>
                    </div>
                </div>
                <div class="col-md-8 text-center loginError">
                    <?php echo $form->error($loginLayoutModel,'username'); ?>
                    <?php echo $form->error($loginLayoutModel,'password'); ?>
                    
                </div>
                 <?php $this->endWidget(); ?>
                
            </div>
        </div>        
    </div>
    <!-- BARRA SUPERIOR OFF -->
    <?php echo $content; ?>

        
        
        
        
        
    </div>
    
</div>