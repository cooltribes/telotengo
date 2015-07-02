<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
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
<?php  Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/styles.css',null); ?>
	<head>
		
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
	  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	  	<meta name="description" content="">
	  	<meta name="author" content="">
	  	<link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">
		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="language" content="en" />

	    <title>Sigma Tiendas</title>

		
		
		<!-- Just for debugging purposes. Don't actually copy this line! -->
		<!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
		
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		    <!--[if lt IE 9]>
		      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		      <![endif]-->
		      <!-- Move down content because we have a fixed navbar that is 50px tall -->
			

		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>

	<!--	<title><?php echo CHtml::encode($this->pageTitle); ?></title> -->
		<?php // Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/styles.css',null); ?>
		
		<?php //Yii::app()->less->files = array('less/styles.less'=>'css/syles.css');
				//Yii::app()->less->register(); ?>
	
		
	</head>

	<body>

     <!-- HEADER ON -->

   
    <nav class="navegacion-superior navbar-default navbar-fixed-top min992" id="mainHeader" >
        <div class="container"> 
            <div class="navbar-left">  
                <div class="links_menu">            
                        <a href="http://facebook.com/sigmatiendas" target="_blank">
                            <img src="<?php echo Yii::app()->theme->baseUrl;?>/images/layout/ICON-facebook.png" alt="Facebook" width="25" height="25">
                        </a>
                   
                        <a href="https://twitter.com/Sigmatiendas" target="_blank">
                            <img src="<?php echo Yii::app()->theme->baseUrl;?>/images/layout/twitter.png" alt="Twitter" width="25" height="25">
                        </a>
                        <a href="http://instagram.com/sigmatiendas" target="_blank">
                            <img src="<?php echo Yii::app()->theme->baseUrl;?>/images/layout/instagram.png" alt="Instagram" width="25" height="25">
                        </a>
                        <a href="http://youtube.com/Sigmaoficial" target="_blank">
                            <img src="<?php echo Yii::app()->theme->baseUrl;?>/images/layout/ICON-youtube.png" alt="Youtube" width="25" height="25">
                        </a>

                        <a class="linkSuperior" href="http://twitter.com/sigmatiendas" target="_blank">
                           Síguenos en @Sigmatiendas
                        </a> 
                </div>          
            </div>
            <div class="navbar-right">
                <ul class="links_menu">
                    <a href="<?php echo Yii::app()->baseUrl;?>/site/info" class="linkSuperior">Quienes somos </a>|
                    <a href="<?php echo Yii::app()->baseUrl;?>/site/soporte" class="linkSuperior">Ensamblaje y soporte </a>|
                    <a href="<?php echo Yii::app()->baseUrl;?>/site/garantia" class="linkSuperior">Garantías </a>|
                    <a href="<?php echo Yii::app()->baseUrl;?>/site/convenios" class="linkSuperior">Convenios </a>|
                    <a href="<?php echo Yii::app()->baseUrl;?>/site/corporativo" class="linkSuperior">Corporativo </a>|
                    <a href="<?php echo Yii::app()->baseUrl;?>/site/licencias" class="linkSuperior">Instalación de Licencias </a>
                  
                </ul>
            </div>
        </div>
        
        <div class="mainHead"> 
            <div class="container">
                <div class="navbar">
                    <div class="row-fluid">
                        <div class="col-md-4 col-xs-4 no_padding">
                            <div class="row-fluid">
                                <div class="col-md-6 no_padding">   
                                   <a href="<?php echo Yii::app()->baseUrl; ?>/" title="Inicio">
                                        <img src="<?php echo Yii::app()->theme->baseUrl;?>/images/layout/logo.png" width="100%"/>
                                   </a>
                                </div>
                                <div class="col-md-6 no_padding" style="line-height: 80px;">   
                                   <a href="<?php echo Yii::app()->baseUrl; ?>/" title="Inicio">
                                        <img src="<?php echo Yii::app()->theme->baseUrl;?>/images/layout/slogan.png" width="100%"/>
                                   </a>
                                </div>
                            </div> 
                        </div>
                        <div class="col-md-8">  
                            <div class="row" style="text-align:right">
                               <!-- <span class="white">Vive la <span class="red">Experiencia</span> tecnológica</span> -->
                            </div>
                            <div class="row" style="margin-top: 10px;">
                            <ul class="no_list_style userButtons">
                             <?php
                    if(Yii::app()->user->isAdmin()){
                ?>
                    
                    
                    <li class="button glyph-padding"><a href="<?php echo Yii::app()->baseUrl; ?>/site/logout" class="white">
                        Salir</a> </li>
                    <li class="dropdown button glyph-padding">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="white">Administración<b class="caret"></b></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/user/admin">Usuarios</a></li>
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/marca/admin">Marcas</a></li>
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/atributo/admin">Atributo</a></li>
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/unidad/admin">Unidad</a></li>
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/color/admin">Color</a></li>
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/categoria/admin">Categorías</a></li>
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/giftcard/admin">Gift Cards</a></li>
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/TipoPago/admin">Tipos de Pago</a> </li>
                        </ul>
                    </li>    
                     
                    <li class="dropdown button glyph-padding">
                        <a href="#" class="dropdown-toggle white" data-toggle="dropdown">Pedidos<b class="caret"></b></a> 
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/orden/admin">Todos</a></li> 
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/user/admin/reclamos">Reclamos</a></li>
                        </ul>
                    </li>       
                    <li class="dropdown button glyph-padding">
                        <a href="#" class="dropdown-toggle white" data-toggle="dropdown">Productos<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/producto/seleccion">Crear nuevo</a></li> 
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/producto/admin">Todos</a></li>
                            
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/producto/seleccion">Agregar Inventario</a></li>
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/flashsale/admin">Ventas Flash</a></li>
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/pregunta/admin">Preguntas</a></li>
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/producto/importar">Importar productos</a></li>
                        </ul>
                    </li>
                    <li class="button glyph-padding">
                        <a href="<?php echo Yii::app()->baseUrl; ?>/ControlPanel/admin" class="white">Panel de Control</a>
                    </li>       
                        
                <?php        
                    
                }
                else if(!Yii::app()->user->isGuest)
                {
                 // usuario normal
                    ?>
                    
     
              <li class="button"><a href="<?php echo Yii::app()->baseUrl; ?>/site/logout">
                  <span class="glyphicon glyphicon-off glyphiconLarge"></span><br/>Salir</a></li>
                        
                <li class="menu-item dropdown button">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-user glyphiconLarge"></span><br/>
                    Cuenta<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li class="menu-item dropdown ">
                            <a href="<?php echo Yii::app()->baseUrl; ?>/user/user/tucuenta">Tu Cuenta</a>
                        </li>
                        <li class="menu-item dropdown ">
                           <a href="<?php echo Yii::app()->baseUrl; ?>/orden/listado"> Tus Pedidos</a>
                        </li>
                        <li class="menu-item dropdown ">
                            <a href="<?php echo Yii::app()->baseUrl; ?>/user/profile/edit">Editar Perfil</a>
                        </li>
                        <li class="menu-item dropdown dropdown-submenu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Direcciones</a>
                            <ul class="dropdown-menu">
                                <li class="menu-item ">
                                     <a href="<?php echo Yii::app()->baseUrl; ?>/direccionEnvio/listado">De Envío </a>
                                </li>
                                <li class="menu-item ">
                                    <a href="<?php echo Yii::app()->baseUrl; ?>/direccionFacturacion/listado">De Facturación</a>
                                </li>
                               <!-- <li class="menu-item dropdown dropdown-submenu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Level 2</a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="#">Link 3</a>
                                        </li>
                                    </ul>
                                </li>-->
                            </ul>
                        </li>
                        <li class="menu-item dropdown">
                           <a href="<?php echo Yii::app()->baseUrl; ?>/user/profile/changepassword"> Cambiar Contraseña</a>
                        </li>
                    </ul>
                </li>
            
                     
                        <li class="button">
                            <a href="<?php echo Yii::app()->baseUrl; ?>/bolsa/view">
                                <div class="white">
                                    <span class="glyphicon glyphicon-shopping-cart glyphiconLarge"></span><br/> Tu Carrito de compras 
                                </div>
                            </a>
                        </li>
                          
                        <li class="button"><a href="<?php echo Yii::app()->baseUrl; ?>/tienda/"><div class="white"><span class="glyphicon glyphicon glyphicon-th glyphiconLarge"></span><br/>
                                            Tienda </div></a></li> 
                       
                        <li class="button">
                            <a href="<?php echo Yii::app()->baseUrl; ?>/giftcard/comprar">
                                <div class="white">
                                    <span class="glyphicon glyphicon-gift glyphiconLarge"></span><br/> Comprar Giftcard
                                </div>
                            </a>
                        </li> 
                        
            
                        
                        
                        
          
            
                <?php
                        
                }
                else { 
                ?> 
                                 <!--  <li class="button">
                                 <a href="<?php // echo Yii::app()->baseUrl; ?>/site/index">                           
                                        <div class="white" >
                                            <span class="glyphicon glyphicon-user glyphiconLarge"></span><br/>
                                            Tu cuenta
                                        </div> 
                                    </a>
                                </li>-->
                                <li class="button"> 
                                    <a href="<?php echo Yii::app()->baseUrl; ?>/user/login">
                                        <div class="white" >
                                            <span class="glyphicon glyphicon-check glyphiconLarge"></span><br/>
                                            Inicia Sesión
                                        </div>
                                    </a> 
                                </li>
                                <li class="button">
                                    <a href="<?php echo Yii::app()->baseUrl; ?>/user/registration">
                                        <div class="white" >
                                            <span class="glyphicon glyphicon-plus-sign glyphiconLarge"></span><br/>
                                            Regístrate                            
                                        </div>
                                    </a>
                                </li>
                                <li class="button">
                                    <a href="<?php echo Yii::app()->baseUrl; ?>/tienda">
                                        <div class="white" >
                                            <span class="glyphicon glyphicon glyphicon-th glyphiconLarge"></span><br/>
                                            Tienda                         
                                        </div>
                                    </a>
                                </li>

                <?php   
                }
                ?>
                                 </ul>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="width:100%">
                    <ul class="dropdown categoriesMenu" style="display: table; width:100%;">
                      
                            <li class="dir" id="homeButton">
                                  <a href="<?php echo  Yii::app()->baseUrl; ?>"><span class="margin_top_xsmall glyphicon glyphicon-home glyphiconLarge"></span></a>
                            </li>
                        
                 
                        <?php
                        $categorias = Categoria::model()->findAllByAttributes(array('id_padre'=>0));
                        foreach ($categorias as $categoria) {
                            ?>
                            <li class="dir" onclick="window.location.href = '<?php echo Yii::app()->baseUrl.'/categorias'.'/'.$categoria->url_amigable; ?>';"><?php echo $categoria->nombre; ?>
                                <?php
                                $hijos = Categoria::model()->findAllByAttributes(array('id_padre'=>$categoria->id));
                                if(sizeof($hijos) > 0){
                                    ?>
                                    <ul>
                                        <?php
                                        foreach ($hijos as $hijo) {
                                            ?>
                                            <?php echo CHtml::link('<li>'.$hijo->nombre.'</li>', Yii::app()->baseUrl.'/categorias'.'/'.$hijo->url_amigable, array()); ?>
                                            <?php
                                        }
                                        ?>
                                    </ul> 
                                    <?php
                                }
                                ?>
                            </li>
                            <?php
                        }
                        ?>    </ul> 
          
                </div>
                       <!-- <div class="col-md-2 margin_top_small">
                       
                        <?php
                          /*  echo CHtml::textField('busqueda', '',
                                array('id'=>'busqueda', 
                                    
                                    'placeholder'=>'Buscar por palabra clave'
                                    )
                                ); */?>

                        </div>-->
                   
                        
                    
      
                   
                   
                   
                  
               
            </div>
         </div>
        
    </nav>
     
		
  <!-- HEADER OFF -->
  
<nav class="navbar navbar-default max991" id="navMobile">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed margin_top_medium" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand no_padding" href="<?php echo Yii::app()->baseUrl; ?>/" title="Inicio">
         <img src="<?php echo Yii::app()->theme->baseUrl;?>/images/layout/logo.png" width="100%"/>
      </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Categorías <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <?php foreach ($categorias as $categoria): ?>
                            <li><a href="<?php echo Yii::app()->baseUrl.'/categorias'.'/'.$categoria->url_amigable; ?>"><?php echo $categoria->nombre; ?></a>
                                
                            </li>
            <?php endforeach; ?>            
            
            
            
            
          </ul>
        </li>
      </ul>
     
      
 <!-- ************** USER MENU *************************-->     
      <ul class="nav navbar-nav navbar-right">
          <?php
                    if(Yii::app()->user->isGuest):
           ?>
           <li><a href="#">Tienda</a></li>
           <li><a href="#">Registrate</a></li>
           <li><a href="#">Inicia Sesión</a></li>
           
           <?php    else: 
           ?>
           <li><a href="<?php echo Yii::app()->baseUrl; ?>/giftcard/comprar">Comprar giftcard</a></li>
           <li><a href="<?php echo Yii::app()->baseUrl; ?>/bolsa/view">Carrito</a></li>
           <li><a href="<?php echo Yii::app()->baseUrl; ?>/tienda/">Tienda</a></li>
           
           <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Tu Cuenta <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="<?php echo Yii::app()->baseUrl; ?>/user/user/tucuenta">Tu cuenta</a></li>
                <li><a href="<?php echo Yii::app()->baseUrl; ?>/orden/listado">Tus pedidos</a></li>
                <li><a href="<?php echo Yii::app()->baseUrl; ?>/user/profile/edit">Editar perfil</a></li>
                <li>
                    <a href="<?php echo Yii::app()->baseUrl; ?>/direccionEnvio/listado">Direcciones de envío </a>
                </li>
                <li>
                    <a href="<?php echo Yii::app()->baseUrl; ?>/direccionFacturacion/listado">Direcciones de facturación</a>
                </li>               
              </ul>
            </li>
            <li><a href="<?php echo Yii::app()->baseUrl; ?>/site/logout">Salir</a></li>
            
           
           <?php endif; ?>
           
           
           
       
        
      </ul>
      
      
      
      
      
      
      
 <!-- ************* USER MENU OFF *************************-->     
 
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

		<div id="page">
            <div id="principal" style="clear: top">
                <div class="container"> 
        			<?php if(isset($this->breadcrumbs)):?> 
        				<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
        					'links'=>$this->breadcrumbs,
                            'tagName'=>'ul',
                            'separator'=>'',
                            'homeLink' => CHtml::link('Inicio', Yii::app()->homeUrl),
                            'activeLinkTemplate'=>'<li><a href="{url}">{label}</a> <span class="divider">/</span></li>',
                            'inactiveLinkTemplate'=>'<li><span>{label}</span></li>',
                            'htmlOptions'=>array ('class'=>'breadcrumb bg_white no_padding_left')
                    			)); ?><!-- breadcrumbs -->
                    		<?php endif?>
                 </div>   		

			     <?php echo $content; ?>
			    
           </div> 
           </div>
        <div class="clear"></div> 
          <div class="footer padding_bottom_small">
              <div class="container">
                  <div class="row-fluid">
                      <div class="col-md-4 padding_left padding_right">
                          <div style="width:100%;" class="foot-section padding_right padding_left">
                              <h2 class="foot-title"> Sobre nosotros </h2>
                                        <ul class="foot-list">
                                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/site/info" title="Quienes somos">¿Quiénes Somos?</a></li>
                                            <li><a href="#" title="Términos de Uso">Términos de Uso</a></li>
                                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/site/contact">Contacto</a></li>
                                        </ul>
                          </div>
                      </div>
                      <div class="col-md-4 padding_left padding_right">
                          <div style="width:100%;" class="foot-section padding_right padding_left">
                              <h2 class="foot-title">Servicio al cliente</h2>
                                            <ul class="foot-list">
                                                <li><a href="<?php echo Yii::app()->baseUrl; ?>/user/login">Inicia sesión</a></li>
                                                <li><a href="#" title="Preguntas Frecuentes">Preguntas Frecuentes</a></li>
                                                <li><a href="#" title="Formas de Pago">Formas de Pago</a></li>
                                                <li><a href="#" title="Políticas de Privacidad">Políticas de Privacidad</a></li>
                                                <li><a href="#" title="Políticas de Envíos, Devoluciones y Cancelaciones">Políticas de Envíos, Devoluciones y Cancelaciones</a></li>
                                          </ul> 
                          </div>
                      </div>
                      <div class="col-md-4 padding_left padding_right">
                          <div style="width:100%;" class="foot-section padding_right padding_left">
                              <h2 class="foot-title">Sigmasys C.A.</h2>
                                    <strong>0276-3442626</strong>
                                    <p>
                                    <div>Av. Libertador, Centro Comercial Las Lomas, Local Nº 30, San Cristóbal, Edo. Táchira.</div>
                                    </p>
                              <p>&copy; Sigmasys C.A <?php echo date('Y');?></p> 
                              
                          </div>
                      </div>
                  </div>
              </div>
          </div>
	<!--
	
	<footer class="footer margin_top_large">
              	<div class="content">
                  	<div class="row-fluid foot-main">
                        <div class="col-md-7 col-md-offset-1">
                            <div class="row-fluid foot-section">
                                <div class="col-md-4 col-md-offset-2">
                                    <h2 class="foot-title"> Sobre nosotros </h2>
                                    <ul class="foot-list">
                                        <li><a href="<?php echo Yii::app()->baseUrl; ?>/site/info" title="Quienes somos">¿Quiénes Somos?</a></li>
                                        <li><a href="#" title="Términos de Uso">Términos de Uso</a></li>
                                        <li><a href="<?php echo Yii::app()->baseUrl; ?>/site/contact">Contacto</a></li>
                                    </ul>
                                </div>
                               
                                <div class="col-md-4">
                                    <div>
                                        <h2 class="foot-title">Servicio al cliente</h2>
                                        <ul class="foot-list">
                                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/user/login">Inicia sesión</a></li>
                                            <li><a href="#" title="Preguntas Frecuentes">Preguntas Frecuentes</a></li>
                                            <li><a href="#" title="Formas de Pago">Formas de Pago</a></li>
                                            <li><a href="#" title="Políticas de Privacidad">Políticas de Privacidad</a></li>
                                            <li><a href="#" title="Políticas de Envíos, Devoluciones y Cancelaciones">Políticas de Envíos, Devoluciones y Cancelaciones</a></li>
                                      </ul> 
                                    </div> 
                                </div>
                            </div>
                       </div>              
                        
    					<div class="col-md-3 foot-section white" >
                            <h2 class="foot-title">Sigmasys C.A.</h2>
                                <strong>0276-3442626</strong>
                                <p>
                                <div>Av. Libertador, Centro Comercial Las Lomas, Local Nº 30, San Cristóbal, Edo. Táchira.</div>
                                </p>
                          <p>&copy; Sigmasys C.A <?php echo date('Y');?></p> 
                        </div>
                    </div>
                </div>
    </footer>
		
		<!-- page -->
	</body>
</html>
<script>
    $('#homeButton').hover(function(e){
            $('#homeButton>a>span').css('color','#198ac9');
        },function(e){
            $('#homeButton>a>span').css('color','#FFF');
        });
    $('#busqueda').keyup(function(e){
            if(e.keyCode == 13)
            {
                $('#busqueda-form').submit();
                
            }
        });
</script>
