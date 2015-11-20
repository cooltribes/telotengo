<?php

class SiteController extends Controller
{
	
		/**
	 * @return array action filters
	 */
	
	public function filters()
	{ 
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}
 
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','error','contact','login','logout','captcha','busqueda','inhome','tiendas','info','soporte','garantia','convenios','request','request2',
								'corporativo','licencias','ofertas','home','store','detalle', 'inhome2', 'autoComplete', 'filtroBusqueda', 'carrito', 'category', 'formuPregunta',
								'detalleOrden','mailtest'), 

				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('mensajes','buscarmensaje'), 
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
				//'users'=>array('admin'),
				'expression' => 'UserModule::isAdmin()',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionOldIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$message = new YiiMailMessage;
				$message->view = "mail_template";
				$subject = 'Formulario de Contacto - '.$model->email;
				$body = "El usuario de mail: ".$model->email."<br/>
						envió el siguiente mensaje: ".$model->body."<br/>
						<br/>
						Atender a la brevedad";
				$params = array('body'=>$body);
				$message->subject = $subject;
				$message->setBody($params, 'text/html');
				$message->addTo(Yii::app()->params['contacto']);
				$message->from = array(Yii::app()->params['contacto'] => 'Sigma Tiendas');
				Yii::app()->mail->send($message);			

				Yii::app()->user->setFlash('success','Gracias por contactarnos. Te responderemos lo más pronto posible.');
				$this->redirect(array("contact"));
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
		// Esta es la pagina de Notificaciones/Mensajes
	public function actionMensajes(){

		$this->render('mensajes');
	}

	/* Ver los mapas de las tiendas */
	public function actionTiendas(){
		$this->render('tienda');
	}

	/* Quienes Somos */
	public function actionInfo(){
		$this->render('info');
	}

	/* Ensamblaje y Soporte */
	public function actionSoporte(){
		$this->render('soporte');
	}

	/* Garantia */
	public function actionGarantia(){
		$this->render('garantia');
	}

	/* Convenios */
	public function actionConvenios(){
		$this->render('convenios');
	}

	/* Corporativo */
	public function actionCorporativo(){
		$this->render('corporativo');
	}

	/* Licencias */
	public function actionLicencias(){
		$this->render('licencias');
	}
    public function actionMailTest(){ 
   $message = new YiiMailMessage;
                //Opciones de Mandrill
                $message->activarPlantillaMandrill();
                
                $subject = 'Tu Pago en Personaling';
                $message->subject    = $subject;
                $body ='Mail de Pruebas sin info importante';                
                $message->setBody($body, 'text/html');                
                $message->addTo('wmontilla@upsidecorp.ch');
                $message->addTo('rpalma@upsidecorp.ch');
                
                Yii::app()->mail->send($message);
      
    }

		/**
	 * Arma el cuerpo del mensaje que se va a mostrar y lo devuelve como texto para colocarlo en el frontend
	 */
	public function actionBuscarmensaje()
	{
		$mensaje = Mensajes::model()->findByPk($_POST['mensaje_id']);
		
		if($mensaje->estado == 0) // no se ha leido
		{
			$mensaje->estado = 1;
			$mensaje->save(); 
		}
		
		$div = "";
		
		$div = $div.'<div class="padding_medium bg_color3 ">';
		$div = $div."<p><strong>De:</strong> Admin <span class='pull-right'><strong> ".date('d/m/Y', strtotime($mensaje->fecha))."</strong> ".date('h:i A', strtotime($mensaje->fecha))."</span></p>";
		$div = $div."<p> <strong>Asunto:</strong> ".$mensaje->asunto."</p>";
		$div = $div."<p> ".$mensaje->mensaje." </p>";
	/*	$div = $div.'<form class=" margin_top_medium ">
				  		<textarea class="span12 nmargin_top_medium" rows="3" placeholder="Escribe tu mensaje..."	></textarea>
				  		<button class="btn btn-danger"> <span class="entypo color3 icon_personaling_medium" >&#10150;</span> Enviar </button>
			  		</form>'; */
		//$div = $div.'<p><a class="btn btn-danger pull-right" href="'.Yii::app()->getBaseUrl().'/orden/detallepedido/'.$mensaje->orden_id.'#mensajes" target="_blank"> Responder </a></p>
		//	  		';	  		
		
		$div = $div."<br/></div>";
		
		echo $div;
		
	}		
	
	
	// Busqueda de cualquier texto en cualquier parte de la web
	public function actionBusqueda(){
		
	//	Yii::app()->end();

		if(isset($_POST['busqueda'])){
			$texto = $_POST['busqueda'];
			Yii::app()->getSession()->add('texto', $_POST['busqueda']);
		}		
		
		$producto = new Producto;
		$producto->unsetAttributes();
		
		$producto->nombre = $_POST['busqueda'];  
		$producto->estado = 1; 
		
		$dataProvider = $producto->searchTwo();
		$rangos = Inventario::model()->getLimites();
		
 		$this->render('busqueda',
			array(
			'dataProvider'=>$dataProvider,
			'rangos'=>$rangos,
		));	
		
	}


	public function actionOfertas(){
		$this->render('ofertas');
	}
    
    public function actionIndex(){
      /*  $this->layout='//layouts/b2b';
        $model = new RegistrationForm;
            $profile = new Profile;
            $profile->regMode = true;
        $this->render('landing',array('model'=>$model,'profile'=>$profile));*/
        
        $this->redirect(array('user/registration'));
    }
    
    public function actionInhome(){
       // $this->layout='//layouts/start';

       $this->render('inhome');
    }
	
	public function actionInhome2(){
       //$this->layout='//layouts/start';
	   $model = Categoria::model()->findAllBySql("select * from tbl_categoria where id_padre = 0  order by destacado desc, fecha_destacado desc  limit 6") ;
       $ultimos = Producto::model()->findAllBySql("select * from tbl_producto where id in (select producto_id from tbl_inventario) order by id desc limit 15");
	   $destacados = Producto::model()->findAllBySql("select * from tbl_producto where id in (select producto_id from tbl_inventario) order by destacado desc limit 15");
	   Yii::app()->session['banner']=true;
       $this->render('inhome2', array('model'=>$model, 'ultimos'=>$ultimos, 'destacados'=>$destacados));
    }
    
    public function actionStore(){
        //$this->layout='//layouts/start';

       $this->render('store', array('list'=>false));
    }
    public function actionCategory($id){
    	$model=Categoria::model()->findByPk($id);
		$hijos=Categoria::model()->findAllByAttributes(array('id_padre'=>$model->id), array('limit'=>6));
        //$this->layout='//layouts/start';

       $this->render('category', array('model'=>$model, 'hijos'=>$hijos));
    }  
    
    public function actionRequest(){ 
        //$this->layout='//layouts/b2b';
        $model = new RegistrationForm;
        $profile = new Profile;
        $profile->regMode = true;
        $this->render('request',array('model'=>$model,'profile'=>$profile)); 
    }
    
    public function actionRequest2(){
        //$this->layout='//layouts/b2b';
        $model = new Empresas;
        $user=User::model()->findByPk(1);
        $profile=$user->profile;
      $this->render('create',array(
            'model'=>$model,
            'user' => $user,
            'profile' => $user->profile,
        ));
    }
    public function actionDetalle(){
        //$this->layout='//layouts/start';
        $otros="";
		$connection = new MongoClass();
		if(Funciones::isDev())
		{
			$document = $connection->getCollection('ejemplo');	//DEVELOP

		}	
		else
		{

			$document = $connection->getCollection('stage');	//STAGE
		} 
		if(!isset($_GET['producto_id']) || !isset($_GET['almacen_id'])) //si no viene nada por get, fue que coloco el URL a mano
		{
			$this->redirect(array('site/inhome2'));
		}
		$producto_id=$_GET['producto_id'];
		$almacen_id=$_GET['almacen_id'];
		$almacen=Almacen::model()->findByPk($almacen_id);
		$model=Producto::model()->findByPk($producto_id);
		$inventario=Inventario::model()->findByAttributes(array('producto_id'=>$producto_id, 'almacen_id'=>$almacen_id));
		$imagen=Imagenes::model()->findAllByAttributes(array('producto_id'=>$producto_id));
		$imagenPrincipal=Imagenes::model()->findByAttributes(array('producto_id'=>$producto_id, 'orden'=>1));
		
		if(!Yii::app()->user->isAdmin())
			$empresaPropia=Empresas::model()->findByPk((EmpresasHasUsers::model()->findByAttributes(array('users_id'=>Yii::app()->user->id))->empresas_id)); // id del que esta intentado entrar
		
		$prueba = array("producto"=>(string)$producto_id); //MEJORAR ESTO 
		$busqueda = $document->findOne($prueba);
		//echo $almacen->empresas->razon_social;
		 $empresa=$almacen->empresas;
		 //$empresa_id=$almacen->empresas->id;
		// $empresa_nombre=$almacen->empresas->nombre;
		//var_dump($busqueda); 
		if(Inventario::model()->findAllByAttributes(array('producto_id'=>$producto_id), array('condition'=>'almacen_id<>'.$almacen_id)))
			$similares=Inventario::model()->findAllByAttributes(array('producto_id'=>$producto_id), array('condition'=>'almacen_id<>'.$almacen_id)); // buscar otros
		else
			$similares=NULL;
		//var_dump($data);
		if(!Yii::app()->user->isAdmin()) // si no es admin
			$otros = Inventario::model()->findAllBySql("select * from tbl_inventario where producto_id=".$producto_id." and almacen_id!=".$almacen_id." and almacen_id not in(select id from tbl_almacen where empresas_id=".$empresaPropia->id.")");
		else // si es admin
	    	$otros = Inventario::model()->findAllBySql("select * from tbl_inventario where producto_id=".$producto_id." and almacen_id!=".$almacen_id." and almacen_id not in(select id from tbl_almacen where empresas_id=".$empresa->id.")");
	    $this->render('detalle2', array('model'=>$model, 'inventario'=>$inventario, 'imagen'=>$imagen, 'imagenPrincipal'=>$imagenPrincipal, 'busqueda'=>$busqueda, 'empresa'=>$empresa, 'almacen'=>$almacen, 
       'otros'=>$otros, 'similares'=>$similares));
    }
    public function actionAutoComplete()
		{
	    	$empresas_id=EmpresasHasUsers::model()->findByAttributes(array('users_id'=>Yii::app()->user->id))->empresas_id; // id del que esta intentado entrar	
	    	$res =array();
	    	if (isset($_GET['term']) && Yii::app()->session['menu']=="")
			{
				#$qtxt ="SELECT  distinct(CONCAT (p.nombre, ' (',c.nombre,')')) FROM tbl_producto_padre p JOIN tbl_categoria c on p.id_categoria=c.id JOIN tbl_producto  po on p.id=po.padre_id JOIN tbl_inventario i on i.producto_id=po.id    WHERE p.nombre LIKE :nombre and i.cantidad>0 limit 3";
				$qtxt ="SELECT  distinct(CONCAT (p.nombre, ' (',c.nombre,')')) FROM tbl_producto_padre p JOIN tbl_categoria c on p.id_categoria=c.id JOIN tbl_producto  po on p.id=po.padre_id JOIN tbl_inventario i on i.producto_id=po.id JOIN tbl_almacen a on i.almacen_id=a.id JOIN tbl_empresas em on a.empresas_id=em.id   WHERE p.nombre LIKE :nombre and i.cantidad>0
				 and em.id<>'".$empresas_id."'  limit 3";
				$command =Yii::app()->db->createCommand($qtxt);
				$command->bindValue(":nombre", '%'.$_GET['term'].'%', PDO::PARAM_STR);
				$resP =$command->queryColumn();	
					
				#$qtxt ="select distinct(p.nombre) from tbl_producto p join tbl_inventario t on t.producto_id=p.id where p.nombre like :nombre and t.cantidad>0 limit 6";
				$qtxt ="select distinct(p.nombre) from tbl_producto p join tbl_inventario i on i.producto_id=p.id JOIN tbl_almacen a on i.almacen_id=a.id JOIN tbl_empresas em on a.empresas_id=em.id  where p.nombre like :nombre and i.cantidad>0 and em.id!='".$empresas_id."'  limit 6"; //and em.id<>'".$empresas_id."'
				$command =Yii::app()->db->createCommand($qtxt);
				$command->bindValue(":nombre", '%'.$_GET['term'].'%', PDO::PARAM_STR);
				$res2 =$command->queryColumn();
				sort($res2);
				$res= array_merge($resP,$res2);
	     		echo CJSON::encode($res);
	    	}
			else
		    {
				$model=Categoria::model()->findByPk(Yii::app()->session['menu']);

				
				/*$qtxt ="SELECT  CONCAT (p.nombre, ' en ',c.nombre) FROM tbl_producto_padre p JOIN tbl_categoria c on p.id_categoria=c.id  
				WHERE p.nombre LIKE :nombre  limit 3";*/
				
				/*$command =Yii::app()->db->createCommand($qtxt);
				$command->bindValue(":nombre", '%'.$_GET['term'].'%', PDO::PARAM_STR);
				$resP =$command->queryColumn();	*/	
				$res[0]=$_GET['term']." (".$model->nombre.")";
				/*$qtxt ="SELECT nombre FROM tbl_producto WHERE nombre LIKE :nombre limit 6";
				$command =Yii::app()->db->createCommand($qtxt);
				$command->bindValue(":nombre", '%'.$_GET['term'].'%', PDO::PARAM_STR);
				$res2 =$command->queryColumn();
				sort($res2);
				$res= array_merge($resP,$res2);*/
				$model = Categoria::model()->findAllByAttributes(array('id_padre'=>Yii::app()->session['menu']));
				$i=0;
				
				foreach($model as $modelado)
				{
					
						if($modelado->ultimo==1)
						{
							if(ProductoPadre::model()->findAllByAttributes(array('id_categoria'=>$modelado->id, 'activo'=>1)))
							{
								$hijos=ProductoPadre::model()->findAllByAttributes(array('id_categoria'=>$modelado->id, 'activo'=>1)); 
								foreach($hijos as $hijo)
								{
									array_push($res, $hijo->nombre);
									$i++;
								}
							}	
	 
						}
						

				}
	     		echo CJSON::encode($res);
			}
			
	    	Yii::app()->end();
		}
	public function actionFiltroBusqueda()
	{
		echo Yii::app()->session['menu']=$_POST['filtro'];		
	}
	
	public function actionCarrito()
	{
		//$this->layout='//layouts/start';
		$empresas = EmpresasHasUsers::model()->findByAttributes(array('users_id'=>Yii::app()->user->id));		
        $model=Bolsa::model()->findByAttributes(array('empresas_id'=>$empresas->empresas_id));
	    $bolsaInventario=BolsaHasInventario::model()->findAllByAttributes(array('bolsa_id'=>$model->id), array('order'=>'almacen_id asc'));
        $this->render('carrito', array('model'=>$model, 'bolsaInventario'=>$bolsaInventario));
	}

	public function actionFormuPregunta()
	{
		$texto=$_POST['texto'];
		$tipo=$_POST['tipo'];
		$producto_id=$_POST['producto_id'];
		$empresa_id=$_POST['empresa_id'];
		 $model = new Pregunta;
		 $model->pregunta=$texto;
		 $model->fecha=date('Y-m-d h:i:s');
		 $model->producto_id=$producto_id;
		 $model->empresa_id=$empresa_id;
		 $model->users_id=132; //TODO hacerlo dinamico
		 $model->publica=$tipo;
		 $model->save();
		Yii::app()->end();
		
	} 

} 
