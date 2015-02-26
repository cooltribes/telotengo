<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
    <body>
  
    <div style="background: -webkit-linear-gradient(#198ac9,#016eab);background: -o-linear-gradient(#198ac9,#016eab);background: -moz-linear-gradient(#198ac9,#016eab);background: linear-gradient(#198ac9,#016eab);
    height:100px;">
        <table width="98%" style="margin-left: 10px;">
            <tr>
               
                <td width="204" style="text-align: left">
                    <a href="<?php echo Yii::app()->getBaseUrl(true); ?>/" title="Inicio">
                                        <img src="<?php echo $_SERVER['SERVER_NAME'].'/'.Yii::app()->theme->getBaseUrl(true);?>/images/layout/logo.png" width="204"/>
                    </a>  
                </td>
                <td width="32"><a href="http://www.facebook.com/Sigmaoficial"><img src="<?php echo $_SERVER['SERVER_NAME'].'/'.Yii::app()->theme->getBaseUrl(true);?>/images/layout/ICON-facebook.png" width="28px"/></a></td>
                <td width="32"><a href="https://twitter.com/SigmaOficial"><img src="<?php echo $_SERVER['SERVER_NAME'].'/'.Yii::app()->theme->getBaseUrl(true);?>/images/layout/twitter.png" width="28px"/></a></td>
                
                <td width="32"><a href="http://instagram.com/sigmaoficial" ><img src="<?php echo $_SERVER['SERVER_NAME'].'/'.Yii::app()->theme->getBaseUrl(true);?>/images/layout/instagram.png" width="28px"/></a>
                <td width="32"><a href="http://youtube.com/Sigmaoficial" ><img src="<?php echo $_SERVER['SERVER_NAME'].'/'.Yii::app()->theme->getBaseUrl(true);?>/images/layout/ICON-youtube.png" width="28px"/></a>
                <td width="180"><a href="http://twitter.com/sigmatiendas" style="color:#FFF; text-decoration: none; font-size: 12px">Síguenos en @Sigmatiendas</a>
                <td style="text-align: right;">
                    <a href="<?php echo Yii::app()->getBaseUrl(true); ?>/" title="Inicio">
                                        <img src="<?php echo $_SERVER['SERVER_NAME'].'/'.Yii::app()->theme->getBaseUrl(true);?>/images/layout/slogan.png" width="190"/>
                                   </a>
                </td>
            </tr>
        </table>
    
        
        
    </div>
    
        

    <table width="100%">
        <tr>
         
            <td><?php echo $body; ?></td>
        </tr>
        <tr>
            <td height="25">
            </td>
        </tr>
    </table>
    
   
     <table width="100%">
        <tr>
            <td width="100%"><div style=" width:100%; height:3px; background-color:#ba1928; width:100%; margin-bottom: 20px;"></div></td>
        </tr>
        <tr>

            <td> <?php if(isset($undercomment)) echo $undercomment; ?></td>
        </tr>
        <tr>
            <td height="25">
            </td>
        </tr>
    </table>
    </body>
</html>