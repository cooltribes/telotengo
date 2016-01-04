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
 


<img src="<?php echo Yii::app()->theme->getBaseUrl()."/images/layout/b2b/background.jpg"?>" style="width:100%; z-index:0; height:100%; position:fixed;left: 0;top: 0;"/>


<div class="row-fluid darkpanel" style="position: fixed">
    <div class="col-md-8 col-md-offset-2 col-sm-12">
        
        <!-- BARRA SUPERIOR -->
    <div class="row-fluid padding_top_small clearfix" id="b2b-header"> 
        <div class="col-md-5 col-xs-12 col-logo col-sm-3">

                    <div style="width:300px; height:50px;" class="logo-container">
                        <img src="<?php echo Yii::app()->theme->baseUrl;?>/images/layout/whitelogo.png" width="65%"/>
                    </div>
             
        </div>
        
        
         
                
        <div class="col-md-7 col-sm-9 col-xs-12 no_right_padding col-login">
            <div class="row-fluid">
                <?php 
                
                $loginLayoutModel=new UserLogin;
                $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id'=>'login-form',
                    'htmlOptions'=>array('class'=>''),
                    'type'=>'inline',
                    'action'=>Yii::app()->getBaseUrl(true).'/user/registration',
                    'enableClientValidation'=>false,
                    'enableAjaxValidation'=>true,
                    'clientOptions'=>array(
                        'validateOnSubmit'=>true,
                    ),
                )); ?>
                <input type="text" style="display:none"/>
                 <input type="password" style="display:none"/>
                 <div class="col-md-8 no_horizontal_padding col-sm-8 col-xs-12">
                     <div class="row-fluid login-inputs">
                          <div class="col-md-6 no_right_padding col-sm-6 col-xs-6">
                            <?php // echo CHtml::activeLabelEx($loginLayoutModel,'username'); ?>
                                    <?php echo $form->textFieldRow($loginLayoutModel,'username',array("class"=>"form-control no-radius login-b2b","placeholder"=>"correoelectronico@cuenta.com")); ?>
                                    
                        </div>
                        <div class="col-md-6 no_right_padding col-sm-6 col-xs-6">
                             <?php //echo CHtml::activeLabelEx($loginLayoutModel,'password'); ?>
                                    <?php echo $form->passwordFieldRow($loginLayoutModel,'password',array('class'=>'form-control no-radius login-b2b')); ?>
                                    <span class="help-block muted text_align_right padding_right">
                                    
                        </div>
                         <div class="col-md-12 text-center loginError margin_top_xsmall">
                            <?php echo $form->error($loginLayoutModel,'username'); ?>
                            <?php echo $form->error($loginLayoutModel,'password'); ?>
                    
                        </div>
                     </div>
                 </div>
               
                <div class="col-md-4 no_right_padding col-sm-4 col-xs-12 text_align_center">
                    <?php $this->widget('bootstrap.widgets.TbButton', array(
                        'buttonType'=>'submit',
                        'type'=>'danger',
                        
                        'label'=>"Ingresa",
                        'htmlOptions'=>array('class'=>'btn-block btn-orange', 'id'=>'btn-login-b2b'),
                    )); ?>
                    <div style="height:25px; ">
                         <?php echo CHtml::link("Recuperar contraseña",Yii::app()->getModule('user')->recoveryUrl,array("class"=>"white-link")); ?>
                    </div>
                </div>
               
                 <?php $this->endWidget(); ?>
                
            </div>
        </div>        
    </div>
    <!-- BARRA SUPERIOR OFF -->
    <?php echo $content; ?>

        
        
        
        
        
    </div>
    
</div>