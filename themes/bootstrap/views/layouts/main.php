<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<head>
<?php 
    Header("Cache-Control: must-revalidate");
    Header("Pragma: cache");

 $offset = 60 * 60 * 24 * 6;
 $ExpStr = "Expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";
 Header($ExpStr);
    
     ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
<link rel="icon" href="<?php echo Yii::app()->theme->baseUrl;?>/images/layout/favicon75.png" type="image/x-icon">
<link rel="shortcut icon" href="<?php echo Yii::app()->theme->baseUrl;?>/images/layout/favicon.ico" type="image/x-icon">
<?php  //Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/styles.css',null); ?>
<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/dropdown_menu/css/helper.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/dropdown_menu/css/dropdown/dropdown.vertical.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/dropdown_menu/css/dropdown/themes/default/default.css');
?>
<?php Yii::app()->bootstrap->register(); ?>
<?php  Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/styles.css',null); 

        #$assetUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.modules.user.views.asset'));
        #Yii::app()->getClientScript()->registerCssFile($assetUrl.'/css/redmond/jquery-ui.css');
        #Yii::app()->getClientScript()->registerScriptFile($assetUrl.'/js/jquery-ui.min.js');
?>
 
      
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
<body>
   
<?php   if(Yii::app()->user->isAdmin()): 
              include 'admin.php';    
        else: 
            if(!Yii::app()->user->isGuest): 
                 if(Yii::app()->authManager->checkAccess("vendedor", Yii::app()->user->id)||Yii::app()->authManager->checkAccess("compraVenta", Yii::app()->user->id)):
                    include 'start.php';
                 else:
                     include 'start.php';
                 endif;
            else:                  
                include 'b2b.php';
            endif;    
        endif;     ?>
</body>           