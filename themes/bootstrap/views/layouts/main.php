<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
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

	    <title>Telotengo</title>

		
		
		<!-- Just for debugging purposes. Don't actually copy this line! -->
		<!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
		
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		    <!--[if lt IE 9]>
		      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		      <![endif]-->
		      <!-- Move down content because we have a fixed navbar that is 50px tall -->
			<style>
		      body {
		        padding-top: 50px;
		        padding-bottom: 20px;
		      }
			</style>

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
        .mainHead .container .navbar-right ul li.button{
    
            min-width:6em;
            float:left;
            margin-left:.3em;
            text-align: center;
            background-color: #198ac9;
            padding-top:10px;
            padding-bottom:10px;
             transition: background-color 300ms ease-in-out;
            -moz-transition: background-color 300ms ease-in-out;
            -webkit-transition: background-color 300ms ease-in-out;
            -o-transition: background-color 300ms ease-in-out;
            
        }.mainHead .container .navbar-right ul li.button:hover{
            text-decoration:none;
        }
        .mainHead .container .navbar-right .button>a:hover{
            
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
        .footer{
            background-color:  #198ac9;
        }
        .subfooter{
            background-color:  #016eab;
        }
        body{
            padding: 0px;
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
            background:#016eab;
            overflow-y: hidden;
            min-height: 210px;
        }
        .no_list_style{
            list-style-type: none;
            
        }
    
    </style>
   
    <nav class="navegacion-superior navbar-default navbar-fixed-top" style="position:absolute; background-color: #127ab5; padding: 5px 0 0 0" >
        <div class="container"> 
            <div class="navbar-left">                
                        <a href="http://facebook.com/sigmatiendas">
                            <img src="http://maranjo.com/sandbox/sigma/skin/social_images/facebook.png" alt="Facebook" width="25" height="25">
                        </a>
                   
                        <a href="https://twitter.com/Sigmatiendas">
                            <img src="http://maranjo.com/sandbox/sigma/skin/social_images/twitter.png" alt="Twitter" width="25" height="25">
                        </a>
                
                        <a href="http://instagram.com/sigmatiendas">
                            <img src="http://sigmatiendas.com/skin/skin/social_images/instagram.png" alt="Instagram" width="25" height="25">
                        </a>
                        <a class="linkSuperior" href="http://twitter.com/sigmatiendas">
                           Síguenos en @Sigmatiendas
                        </a> 
                        
            </div>
            <div class="navbar-right">
                <ul style="list-style: none; color:#FFF">
                    <a href="http://sigmatiendas.com/index.php/our-info/" class="linkSuperior">Quienes somos </a>|
                    <a href="http://sigmatiendas.com/index.php/suport/" class="linkSuperior">Ensamblaje y soporte </a>|
                    <a href="http://sigmatiendas.com/index.php/waranty/" class="linkSuperior">Garantías </a>|
                    <a href="http://sigmatiendas.com/index.php/agreements/" class="linkSuperior">Convenios </a>|
                    <a href="http://sigmatiendas.com/index.php/corporative/" class="linkSuperior">Corporativo </a>|
                    <a href="http://sigmatiendas.com/index.php/licences/" class="linkSuperior">Instalación de Licencias </a>
                  
                </ul>
            </div>
        </div>
        
        <div class="mainHead"> 
            <div class="container">
                <div class="navbar">
                    <div class="navbar-left">  
                        <img src="http://sigmatiendas.com/skin/frontend/fortis/default/images/sigma-systems-logo.png" width="190px"/>
                    </div>
                    <div class="navbar-right">  
                        <p><span class="white">Vive la <span class="red">Experiencia</span> tecnológica</span></p>
                        <ul class="no_list_style">
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
                            
                        </ul>
                    </div>
                </div>
                <div class="row-fluid" align="center">
                <div class="col-md-10">

                    <ul id="nav" class="dropdown dropdown-horizontal">
                        <li class="dir">
                            <span class="glyphicon glyphicon-home glyphiconLarge white"></span>
                        </li>
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
                                            <li><?php echo Chtml::link($hijo->nombre, Yii::app()->baseUrl.'/categorias'.'/'.$hijo->url_amigable, array()); ?></li>
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

                        <div class="col-md-2 margin_top_small">
                       
                        <?php
                            echo CHtml::textField('busqueda', '',
                                array('id'=>'busqueda', 
                                    
                                    'placeholder'=>'Buscar por palabra clave'
                                    )
                                ); ?>

                        </div>
                   
                        
                    
      
                   
                   
                   
                  
                </div>
            </div>
         </div>
        
    </nav>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    <nav class="navbar navbar-default " role="navigation" style="background-color: #ea662e; margin-top: 250px">
    	<div class="container">
	        <div class="row">
	        <!-- Brand and toggle get grouped for better mobile display -->
	        <div class="col-md-2">
	        	<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a href="http://telotengo.com<?php echo Yii::app()->baseUrl; ?>">
						<?php echo CHtml::image(Yii::app()->baseUrl.'/images/telotengo-on-logo.jpg');  ?>
					</a>
				</div>
	        </div>
	        	
		<ul class="nav navbar-nav navbar-right collapse navbar-collapse">
		            
				<?php
					$sql = "select count(*) from tbl_producto where notificado=0";
					$total = Yii::app()->db->createCommand($sql)->queryScalar();
					
					if(Yii::app()->user->isAdmin()){
				?>
					<li class="dropdown">
				        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pedidos<b class="caret"></b></a>
				        <ul class="dropdown-menu">
				        	<li><a href="<?php echo Yii::app()->baseUrl; ?>/orden/admin">Todos</a></li> 
							<li><a href="<?php echo Yii::app()->baseUrl; ?>/user/admin/reclamos">Reclamos</a></li>
						</ul>
				    </li>      	
					<li class="dropdown">
				        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Productos<b class="caret"></b></a>
				        <ul class="dropdown-menu">
				        	<li><a href="<?php echo Yii::app()->baseUrl; ?>/producto/seleccion">Crear nuevo</a></li> 
							<li><a href="<?php echo Yii::app()->baseUrl; ?>/producto/admin">Todos</a></li>
							<li><a href="<?php echo Yii::app()->baseUrl; ?>/producto/poraprobar">Por Aprobar (<?php echo $total; ?>)</a></li>
							<li><a href="<?php echo Yii::app()->baseUrl; ?>/producto/seleccion">Agregar a Inventario</a></li>
							<li><a href="<?php echo Yii::app()->baseUrl; ?>/flashsale/admin">Ventas Flash</a></li>
							<li><a href="<?php echo Yii::app()->baseUrl; ?>/pregunta/admin">Preguntas</a></li>
						</ul>
				    </li>
				    		
					<li class="dropdown">
				        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Empresas<b class="caret"></b></a>
				        <ul class="dropdown-menu">
							<li><a href="<?php echo Yii::app()->baseUrl; ?>/empresas/admin">Todas</a></li>
							<li><a href="<?php echo Yii::app()->baseUrl; ?>/empresas/compradoras">Compradoras</a></li>
							<li><a href="<?php echo Yii::app()->baseUrl; ?>/empresas/vendedoras">Vendedoras</a></li>
				    	</ul>
				    </li>    
				    
				    <li class="dropdown">
				        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Administración<b class="caret"></b></a>
				        <ul class="dropdown-menu">
							<li><a href="<?php echo Yii::app()->baseUrl; ?>/user/admin">Usuarios</a></li>
							<li><a href="<?php echo Yii::app()->baseUrl; ?>/marca/admin">Marcas</a></li>
							<li><a href="<?php echo Yii::app()->baseUrl; ?>/categoria/admin">Categorías</a></li>
							<li><a href="<?php echo Yii::app()->baseUrl; ?>/TipoPago/admin">Tipos de Pago</a> </li>
				    	</ul>
				    </li>     
					<li><a href="<?php echo Yii::app()->baseUrl; ?>/site/logout">Salir</a> </li>		
			            
			    <?php        
					
				}
				else if(!Yii::app()->user->isGuest)
				{
				
					$usuario = User::model()->findByPk(Yii::app()->user->id);
					
					$empresaHas = EmpresasHasUsers::model()->findByAttributes(array('users_id'=>$usuario->id));
				    if(isset($empresaHas)) $empresa = Empresas::model()->findByPk($empresaHas->empresas_id);
					
					if(isset($empresa)){ // tiene empresa
						if($empresa->tipo==2){ // empresa vendedora
							
						?>
							<li><a href="<?php echo Yii::app()->baseUrl; ?>/site/index">Inicio</a></li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Empresas<b class="caret"></b></a>
						        <ul class="dropdown-menu">
									<li><a href="<?php echo Yii::app()->baseUrl; ?>/empresas/listado">Mis Empresas</a></li>   
									<li><a href="<?php echo Yii::app()->baseUrl; ?>/DatosPago/listado">Datos de pago</a></li>
						    	</ul> 
						   </li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Productos<b class="caret"></b></a>
						        <ul class="dropdown-menu">
									<!-- <li><a href="<?php //echo Yii::app()->baseUrl; ?>/inventario/listado">Inventario</a></li> -->
									<li><a href="<?php echo Yii::app()->baseUrl; ?>/producto/seleccion">Agregar</a></li>
									<li><a href="<?php echo Yii::app()->baseUrl; ?>/pregunta/preguntas">Preguntas</a></li>
						    	</ul> 
						   </li>
							<li class="dropdown">
						        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Cuenta<b class="caret"></b></a>
						        <ul class="dropdown-menu">
						        	<li><a href="<?php echo Yii::app()->baseUrl; ?>/user/user/tucuenta">Tu Cuenta</a></li>
									<li><a href="<?php echo Yii::app()->baseUrl; ?>/user/profile/edit">Editar perfil</a></li>
									<li><a href="<?php echo Yii::app()->baseUrl."/user/profile/profile/id/".Yii::app()->user->id; ?>">Mi perfil público</a></li>
									<li><a href="<?php echo Yii::app()->baseUrl; ?>/user/profile/changepassword">Cambiar Contraseña</a></li>
						    	</ul>
						    </li>   
							<li><a href="<?php echo Yii::app()->baseUrl; ?>/site/logout">Salir</a></li>
						
						<?php					
							
						}
						else if ($empresa->tipo==1) // empresa compradora
						{
						?>
						
						<li><a href="<?php echo Yii::app()->baseUrl; ?>/site/index">Inicio</a></li>
						<li class="dropdown">
					        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Direcciones<b class="caret"></b></a>
					        <ul class="dropdown-menu">
								<li><a href="<?php echo Yii::app()->baseUrl; ?>/direccionEnvio/listado">De Envío</a></li>
								<li><a href="<?php echo Yii::app()->baseUrl; ?>/direccionFacturacion/listado">De Facturación</a></li>
					    	</ul>
					    </li>
					    <li><a href="<?php echo Yii::app()->baseUrl; ?>/bolsa/view"><span class="glyphicon glyphicon-shopping-cart"></span> Carrito </a></li>
						<li class="dropdown">
					        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Cuenta<b class="caret"></b></a>
					        <ul class="dropdown-menu">
					        	<li><a href="<?php echo Yii::app()->baseUrl; ?>/user/user/tucuenta">Tu Cuenta</a></li>
								<li><a href="<?php echo Yii::app()->baseUrl; ?>/user/profile/edit">Editar perfil</a></li>
								<li><a href="<?php echo Yii::app()->baseUrl."/user/profile/profile/id/".Yii::app()->user->id; ?>">Mi perfil público</a></li>
								<li><a href="<?php echo Yii::app()->baseUrl; ?>/user/profile/changepassword">Cambiar Contraseña</a></li>
								<li><a href="<?php echo Yii::app()->baseUrl; ?>/empresas/listado">Mis empresas</a></li>          
					    	</ul>
					    </li>   
						<li><a href="<?php echo Yii::app()->baseUrl; ?>/site/logout">Salir</a></li>
						
						
						<?php	
						}
					}
					else { // usuario normal
					?>
					
						<li><a href="<?php echo Yii::app()->baseUrl; ?>/">Inicio</a></li>
						<li><a href="<?php echo Yii::app()->baseUrl; ?>/tienda/">Tienda</a></li> 
						<li class="dropdown">
					        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Direcciones<b class="caret"></b></a>
					        <ul class="dropdown-menu">
								<li><a href="<?php echo Yii::app()->baseUrl; ?>/direccionEnvio/listado">De Envío</a></li>
								<li><a href="<?php echo Yii::app()->baseUrl; ?>/direccionFacturacion/listado">De Facturación</a></li>
					    	</ul>
					    </li>
					  	<li><a href="<?php echo Yii::app()->baseUrl; ?>/bolsa/view"><span class="glyphicon glyphicon-shopping-cart"></span> Tu Carrito de compras </a></li>
						<li class="dropdown">
					        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Cuenta<b class="caret"></b></a>
					        <ul class="dropdown-menu">
					        	<li><a href="<?php echo Yii::app()->baseUrl; ?>/user/user/tucuenta">Tu Cuenta</a></li>
								<li><a href="<?php echo Yii::app()->baseUrl; ?>/user/profile/edit">Editar perfil</a></li> 
								<li><a href="<?php echo Yii::app()->baseUrl."/user/profile/profile/id/".Yii::app()->user->id; ?>">Mi perfil público</a></li>
								<li><a href="<?php echo Yii::app()->baseUrl; ?>/user/profile/changepassword">Cambiar Contraseña</a></li>       
					    	</ul>
					    </li>   
						<li><a href="<?php echo Yii::app()->baseUrl; ?>/site/logout">Salir</a></li>
						
					<?php
					}
					
				?>

			
				<?php
						
				}
				else {
				?>
			
					<li><a href="<?php echo Yii::app()->baseUrl; ?>/site/index">Inicio</a></li>
					<li><a href="<?php echo Yii::app()->baseUrl; ?>/user/login">Inicia sesión</a></li>
					<li><a href="<?php echo Yii::app()->baseUrl; ?>/user/registration">Registrate</a></li>
					<li><a href="<?php echo Yii::app()->baseUrl; ?>/site/contact">Contacto</a></li>

				<?php	
				}
				?>
				<li></li>	            
				</ul>
        	</div>
        	<!-- <div class="row navbar navbar-inverse">
 				<ul class="nav navbar-nav navbar-left collapse navbar-collapse">
			    	<li><a href="#">Inicio</a></li>
			    	<li><a href="#">Ofertas</a></li>
			    	<li><a href="#">Tiendas</a></li>
			    </ul>

			    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			    	<ul class="nav navbar-nav navbar-right collapse navbar-collapse">
			    		<li><a href="#">Inicio</a></li>
			    		<li><a href="#">Ofertas</a></li>
			    		<li><a href="#">Tiendas</a></li>
			    	</ul>
	    		</div>       		
        	</div>
        	
    	</div>
    	-->
    	</nav>
		
		<nav class="navbar navbar-inverse">
    		<div class="container">
    			<div class="row">
	    			<div class="col-md-3">
		        		<div class="navbar-header">
			      			<ul class="nav navbar-nav navbar-left">
						    	<li><a href="<?php echo Yii::app()->baseUrl; ?>/site/index">Inicio</a></li>
						    	<li><a href="<?php echo Yii::app()->baseUrl; ?>/tienda">Tienda</a></li>
						    	<li><a href="#">Ofertas</a></li> 
						    </ul>
						</div>
					</div>
					<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="col-md-offset-1 col-md-4 pull-right">
				<?php
				
				$url = Yii::app()->baseUrl."/site/busqueda";
				
				$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
					'id'=>'busqueda-form',
					'enableAjaxValidation'=>false,
					'enableClientValidation'=>true,
					'action'=> $url,
					'type'=>'horizontal',
					'clientOptions'=>array(
						'validateOnSubmit'=>true, 
					),
					'htmlOptions' => array(
				        'enctype' => 'multipart/form-data',
				        'class' => 'form-inline',
				    ),
				)); ?>
					<div class="form-group">
						<!-- <input type="text" id="busqueda" placeholder="Buscar por palabra clave..." class=""> -->
						
						<?php
							echo CHtml::textField('busqueda', '',
								array('id'=>'busqueda', 
						    		'class'=>'form-control',
									'placeholder'=>'Buscar por palabra clave'
									)
								);
						?>
						
						<?php
						  $this->widget('bootstrap.widgets.TbButton', array(
								'buttonType'=>'submit',
								'type'=>'success',
								'icon'=>'glyphicon glyphicon-search',
							)); ?>

					</div>
			<?php $this->endWidget(); ?>
					</div>
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
            
			<footer role="contentinfo" class="footer">
              	<div class="row foot-main">
                    <div class="col-md-7 col-md-offset-1">
                        <div class="row-fluid foot-section">
                            <div class="col-md-4 col-md-offset-2">
                                <h2 class="foot-title"> Sobre nosotros </h2>
                                <ul class="foot-list">
                                    <li><a href="#" title="Quienes somos">¿Quiénes Somos?</a></li>
                                    <li><a href="#" title="Trabaja con Nosotros">Trabaja con Nosotros</a></li>
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
                                    <li><a href="#" title="Términos y Condiciones de Promesa">Términos y Condiciones de Promesa</a></li>
                                </ul>
                            </div>
                        </div>
                   </div>             
                    
					<div class="col-md-3 foot-section white" >
                      <h2 class="foot-title">Telotengo en los medios:</h2>
                      Un poco de logos ahi
                      Recibe ofertas en tu correo:
                      Dale un ojo a nuestro blog
                      Formas de pago
                    </div>
                </div>
                <p>&copy; Telotengo 2013</p>
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
