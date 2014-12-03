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
				'actions'=>array('index','error','contact','login','logout','captcha','busqueda','tiendas','info','soporte','garantia','convenios',
								'corporativo','licencias'), 
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
	public function actionIndex()
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
}