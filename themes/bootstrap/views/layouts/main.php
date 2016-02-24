<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<head>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<?php
   # header('Pragma: cache'); 
   # header('Cache-Control: public');
   # header('Expires: '.gmdate('D, d M Y H:i:s', time()+(3600*24*5)).' GMT');

    
?>
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
   
<?php
if(!isset(Yii::app()->session['seller']))
    Yii::app()->session['seller']=false;       
if(Yii::app()->user->isAdmin()): 
              include 'admin.php';    
        else: 
            if(!Yii::app()->user->isGuest): 
                if(Yii::app()->authManager->checkAccess("vendedor", Yii::app()->user->id)):
                    include 'vendedor.php';
                endif;
                if(Yii::app()->authManager->checkAccess("comprador", Yii::app()->user->id)):
                    include 'comprador.php';
                endif;
                if(Yii::app()->authManager->checkAccess("compraVenta", Yii::app()->user->id)):
                        if(Yii::app()->session['seller']):
                            include 'compraVenta_V.php';
                        else:
                            include 'compraVenta_C.php';
                        endif;
                    
                endif;
            else:                  
                include 'b2b.php';
            endif;    
        endif;     ?>
</body>           