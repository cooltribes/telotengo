<?php /* @var $this Controller 'tokenGoogleAnalytics'=>'UA-78775800-1', */?>
<!DOCTYPE html>
<head> 
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', '<?php echo Yii::app()->params["tokenGoogleAnalytics"]?>', 'auto');
  ga('send', 'pageview');
</script>
<!-- Smartsupp Live Chat script -->
<script type="text/javascript">
var _smartsupp = _smartsupp || {};
_smartsupp.key = 'bea274c23caaaaf628ad8de3d063838067cd868f';
window.smartsupp||(function(d) {
  var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
  s=d.getElementsByTagName('script')[0];c=d.createElement('script');
  c.type='text/javascript';c.charset='utf-8';c.async=true;
  c.src='//www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
})(document);
</script>
<!--Start of Tawk.to Script
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/57f3d429bb785b3a47d66148/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>-->
<!--End of Tawk.to Script-->
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
$noFooter=0;
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
                include 'b2b.php'; $noFooter=1;
            endif;    
        endif;     ?>

<?php 
if($noFooter==0)
  include 'footer.php';
?>
</body>           