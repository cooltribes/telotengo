<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
<link rel="icon" href="<?php echo Yii::app()->theme->baseUrl;?>/images/layout/favicon75.png" type="image/x-icon">
<link rel="shortcut icon" href="<?php echo Yii::app()->theme->baseUrl;?>/images/layout/favicon75.png" type="image/x-icon">
<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/dropdown_menu/css/helper.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/dropdown_menu/css/dropdown/dropdown.vertical.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/dropdown_menu/css/dropdown/themes/default/default.css');
?>

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
		<?php Yii::app()->bootstrap->register(); ?>
		<?php  Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/styles.css',null); ?>
	</head>

	<body>

     <!-- HEADER ON -->
    <style>
        .linkSuperior{
            color: #FFF; font-size: .8em;
        }
        .linkSuperior:hover{
            color: #FFF;
        }
        .linkSuperior:active{
            color: #FFF;
        } 
        .linkSuperior:visited{
            color: #FFF;
        } 
        .mainHead{
              background: -webkit-linear-gradient(#198ac9, #016eab); /* For Safari 5.1 to 6.0 */
              background: -o-linear-gradient(#198ac9, #016eab); /* For Opera 11.1 to 12.0 */
              background: -moz-linear-gradient(#198ac9, #016eab); /* For Firefox 3.6 to 15 */
              background: linear-gradient(#198ac9, #016eab); /* Standard syntax */
        }
        .mainHead .container{
            font-size:.8em;
        }
        .white{
            color:#FFF;
        }
       .red{
            color:#F00;
        }
        .mainHead .container .navbar-right{
            width:20%;  
            text-align: center;
        }
        .button{
      
            min-width:6em;
            float:right;
            margin-left:.3em;
            text-align: center;
            background-color: #198ac9;
            padding-top:10px;
            padding-bottom:10px;
             transition: background-color 300ms ease-in-out;
            -moz-transition: background-color 300ms ease-in-out;
            -webkit-transition: background-color 300ms ease-in-out;
            -o-transition: background-color 300ms ease-in-out;
            
        }
        .button:hover{
            text-decoration:none;
            background-color: #2a9bda;
            padding-top:7px;
            padding-bottom:13px;
           
            
        }
        .glyphiconLarge{
            font-size:1.7em;
        } 
        
        .mainHead .container .menu{
            background-color: #F19;
        }
        .menu{
            text-align: center;
        }
        ul.dropdown *.dir{
            background-image: none;
            background-color: #ec1f24;
            line-height: 2.8em;
            height:4.2em;
            color: #FFF;
            font-size:1.05em;
            padding-left:13px;
            padding-right:13px;
        }
        ul.dropdown>li>span:hover{
            color: #198ac9;
        }
        ul.dropdown *.dir:hover{
            background-color:#FFF;
            color: #198ac9;
        }
        
        #busqueda{ 
            width: 100%;
            list-style: none;
            height: 2.8em;            
        }        
        .menu, .menu>ul, .menu>ul>li{
            background: #ec1f24;
        }
        
        ul.dropdown ul li{
            background-color: #FFF;
        }
        footer{
            bottom:0px;
            position:inherit;
            width:100%;
        }  
        .footer{
            background-color:  #198ac9;
            margin-right:0px;
        }
        .subfooter{
            background-color:  #016eab;
        }
        body{
            padding: 0px;
            background: none;
        }
        .foot-title{
            color:#FFF;
            font-size:1.7em;
        }
        .foot-list{
            list-style-type: none;
            color:#FFF;
        }
        
        .foot-list>li>a{
            color: #FFF;
        }
        .foot-list>li>a:hover{
            color: #FFF;
        }
        .foot-section{
            background:rgba(0, 0, 0, 0.07);
            overflow-y: hidden;
            min-height: 210px;
        }
        .foot-main{
            width:100%;
        }
        .no_list_style, ul{
            list-style-type: none;
             
        }
        .clientService{
            width:100%;
            text-align:right;
        }
        .productName {  
            line-height: 1.5em;
            height: 3em;
            min-height: 3em;       /* height is 2x line-height, so two lines will display */
            overflow: hidden;  /* prevents extra lines from being visible */
        }
       .caja{
           box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.3); 
       } 
       .caja:hover{
           box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.5); 
       }
        .caja>.productImage{
            height:240px; 
        }
        .cajaTienda>.productImage{
            height:240px;
        }
        .carousel-indicators li{
            border: solid 1px #CCC;
            
        }
        .carousel-indicators .active li{
            background-color: #CCC;
        }
        .main-content{
            background: none;
            border:0px;
            box-shadow: none;
        } 
        #page>#content>.container{
            margin-bottom:4em;
        }
        #boton_facebook{
            background-color: #3B5998;
            background-image: url(<?php echo Yii::app()->theme->baseUrl;?>/images/icon_facebook_registrator.png);
            background-repeat: no-repeat;
            background-position-y: -2px;
            padding: 10px 10px 10px 35px;
            color: #FFF;
        }
        #boton_facebook:visited{
            color:#FFF;
        }
        .align_center{
            text-align: center;
        }
        .padre, .todas{
            margin-top:.6em;
        }
        .padre>a{
            color:#000;
            font-weight: bold;
         }
         .todas>a{
            color:#666677;
            
         }
         .hijo>a{
             color:#666677;
             margin-left:1em;
         }
         
    
    </style>
   
    <nav class="navegacion-superior navbar-default navbar-fixed-top" style="position:inherit; background-color: #127ab5; padding: 5px 0 0 0; " >
        <div class="container"> 
            <div class="navbar-left">                
                        <a href="http://facebook.com/sigmatiendas">
                            <img src="<?php echo Yii::app()->theme->baseUrl;?>/images/layout/ICON-facebook.png" alt="Facebook" width="25" height="25">
                        </a>
                   
                        <a href="https://twitter.com/Sigmatiendas">
                            <img src="<?php echo Yii::app()->theme->baseUrl;?>/images/layout/twitter.png" alt="Twitter" width="25" height="25">
                        </a>
                        <a href="http://youtube.com/Sigmaoficial">
                            <img src="<?php echo Yii::app()->theme->baseUrl;?>/images/layout/ICON-youtube.png" alt="Youtube" width="25" height="25">
                        </a>
                        <a href="http://instagram.com/sigmatiendas">
                            <img src="<?php echo Yii::app()->theme->baseUrl;?>/images/layout/instagram.png" alt="Instagram" width="25" height="25">
                        </a>
                        <a class="linkSuperior" href="http://twitter.com/sigmatiendas">
                           Síguenos en @Sigmatiendas
                        </a> 
                        
            </div>
            <div class="navbar-right">
                <ul style="list-style: none; color:#FFF">
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
                        <div class="col-md-3">  
                           <a href="<?php echo Yii::app()->baseUrl; ?>/" title="Inicio">
                                <img src="http://sigmatiendas.com/skin/frontend/fortis/default/images/sigma-systems-logo.png" width="190px"/>
                            </a> 
                        </div>
                        <div class="col-md-9">  
                            <div class="row" style="text-align:right">
                                <span class="white">Vive la <span class="red">Experiencia</span> tecnológica</span>
                            </div>
                            <div class="row">
                            <ul class="no_list_style">
                             <?php
                    if(Yii::app()->user->isAdmin()){
                ?>
                    <li class="button"><a href="<?php echo Yii::app()->baseUrl; ?>/site/logout" class="white">Salir</a> </li>
                    <li class="dropdown button">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="white">Administración<b class="caret"></b></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/user/admin">Usuarios</a></li>
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/marca/admin">Marcas</a></li>
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/categoria/admin">Categorías</a></li>
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/giftcard/admin">Gift Cards</a></li>
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/TipoPago/admin">Tipos de Pago</a> </li>
                        </ul>
                    </li>    
                     
                    <li class="dropdown button">
                        <a href="#" class="dropdown-toggle white" data-toggle="dropdown">Pedidos<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/orden/admin">Todos</a></li> 
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/user/admin/reclamos">Reclamos</a></li>
                        </ul>
                    </li>       
                    <li class="dropdown button">
                        <a href="#" class="dropdown-toggle white" data-toggle="dropdown">Productos<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/producto/seleccion">Crear nuevo</a></li> 
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/producto/admin">Todos</a></li>
                            
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/producto/seleccion">Agregar a Inventario</a></li>
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/flashsale/admin">Ventas Flash</a></li>
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/pregunta/admin">Preguntas</a></li>
                        </ul>
                    </li>
                     
                    
                     
                            
                        
                <?php        
                    
                }
                else if(!Yii::app()->user->isGuest)
                {
                 // usuario normal
                    ?>
                        <li class="button"><a href="<?php echo Yii::app()->baseUrl; ?>/site/logout"><div class="white">Salir</div></a></li>
                        <li class="dropdown button">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <div class="white">Cuenta<b class="caret"></b></div>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo Yii::app()->baseUrl; ?>/user/user/tucuenta">Tu Cuenta</a></li>
                                <li><a href="<?php echo Yii::app()->baseUrl; ?>/user/profile/edit">Editar perfil</a></li> 
                                <!-- <li><a href="<?php echo Yii::app()->baseUrl."/user/profile/profile/id/".Yii::app()->user->id; ?>">Mi perfil público</a></li> -->
                                <li><a href="<?php echo Yii::app()->baseUrl; ?>/user/profile/changepassword">Cambiar Contraseña</a></li>       
                            </ul>
                        </li> 
                        
                        <li class="dropdown button">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <div class="white">Direcciones<b class="caret"></b></div>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo Yii::app()->baseUrl; ?>/direccionEnvio/listado">De Envío </a>
                                </li>
                                <li>
                                    <a href="<?php echo Yii::app()->baseUrl; ?>/direccionFacturacion/listado">De Facturación</a>
                                </li>
                            </ul>
                        </li>
                        <li class="button">
                            <a href="<?php echo Yii::app()->baseUrl; ?>/bolsa/view">
                                <div class="white">
                                    <span class="glyphicon glyphicon-shopping-cart"></span> Tu Carrito de compras 
                                </div>
                            </a>
                        </li>
                          
                        <li class="button"><a href="<?php echo Yii::app()->baseUrl; ?>/tienda/"><div class="white">Tienda</div></a></li> 
                        <li class="button"><a href="<?php echo Yii::app()->baseUrl; ?>/giftcard/comprar">
                            <div class="white"><span class="glyphicon glyphicon-gift"> Comprar Giftcard</div>
                            </a>
                        </li>
            
                <?php
                        
                }
                else { 
                ?> 
                                <li class="button">
                                    <a href="<?php echo Yii::app()->baseUrl; ?>/site/index">                           
                                        <div class="white" >
                                            <span class="glyphicon glyphicon-user glyphiconLarge"></span><br/>
                                            Tu cuenta
                                        </div> 
                                    </a>
                                </li>
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

                <?php   
                }
                ?>
                                 </ul>
                            </div>
                        </div>
                    </div> 
                </div>
            
                    <ul id="nav" class="dropdown dropdown-horizontal row">
                   <a href="<?php echo Yii::app()->getBaseUrl(true);?>">
                        <li class="dir">
                            <span class="glyphicon glyphicon-home glyphiconLarge white"></span>
                        </li>
                    </a>
                        <?php
                        $categorias = Categoria::model()->findAllByAttributes(array('id_padre'=>0));
                        foreach ($categorias as $categoria) {
                            ?>
                            <li class="dir"><?php echo $categoria->nombre; ?>
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

		<div id="page">

			<?php if(isset($this->breadcrumbs)):?>
				<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
					'links'=>$this->breadcrumbs,
				)); ?><!-- breadcrumbs -->
			<?php endif?>
  
			<?php echo $content; ?>
            </div>
			<div class="clear"></div>
            
			<footer role="contentinfo" class="footer margin_top_large">
              	<div class="row foot-main">
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
                    
					<div class="col-md-3 foot-section white" >
                        <h2 class="foot-title">Sigmasys C.A.</h2>
                            <strong>0276-3442626</strong>
                            <p>
                            <div>Av. Libertador, Centro Comercial Las Lomas, Local Nº 30, San Cristóbal, Edo. Táchira.</div>
                            </p>
                      <p>&copy; Sigmasys C.A <?php echo date('Y');?></p> 
                    </div>
                </div>
                
            </footer>
		
		<!-- page -->
	</body>
</html>
<script>
    $('#busqueda').keyup(function(e){
            if(e.keyCode == 13)
            {
                $('#busqueda-form').submit();
                
            }
        });
</script>
