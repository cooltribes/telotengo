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
								'corporativo','licencias','ofertas','home'), 
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('mensajes','buscarmensaje','mailtest'), 
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
    public function actionMailTest(){
      $body="BODY";
        $undercomment='Para completar la compra debes realizar el deposito o transferencia electrónica en un máximo de 3 días a cualquiera de las siguientes <strong>cuentas corrientes</strong>:
                            <ul style="list-style-type:square" class="margin_top_small margin_left_small">
                                <li><strong>Banesco</strong> - 0134 0261 2026 1101 8222</li>
                                <li><strong>Venezuela</strong> - 0102 0129 2500 0008 9665</li>
                                <li><strong>Mercantil</strong> - 0105 0735 9417 3503 3014</li>
                                <li><strong>Banfoandes</strong> - 0007 0147 5600 0000 3292</li>
                                <li><strong>Sofitasa</strong> - 0137 0020 6200 0900 7231</li>
                                <li><strong>100% Banco</strong> - 0156 0015 2804 0019 1722</li>
                                <li><strong>BFC C.A</strong> - 0151 0135 1530 0004 2301</li>
                                <li><strong>Banco Activo</strong> - 0171 0018 1660 0037 0854</li>
                                <li><strong>Bancaribe</strong> - 0114 0430 8443 0005 2865</li>
                                <li><strong>Provincial</strong> - 0108 0098 6001 0005 7276</li>
                                <li><strong>Venezolano de Crédito </strong>- 0104 0033 3903 3008 3417.</li>
                                <li><strong>Corpbanca/BOD</strong>- 0121 0312 3700 1338 1504</li>
                                <li><strong>Banco Exterior</strong> - 0115 0114 1410 02398498</li>
                            </ul>

                            <h4 class="margin_top_small">Datos para la transferencia:</h4>
                            <ul style="list-style-type:square" class="margin_top_small margin_left_small">
                                <li><strong>Beneficiario/Razón Social</strong>: Sigmasys C.A.</li>
                                <li><strong>Correo electrónico:</strong> info@sigmatiendas.com</li>
                                <li><strong>RIF</strong>: J-29468637-0</li>
                                <li><strong>Dirección</strong>: Avenida libertador  C.C Las Lomas local 30,  San Cristóbal,  Edo. Táchira.
                                <li><strong>Teléfono</strong>:  02763442626</li>
                            </li>
                            </ul><br/> Al depositar ingresa en tu cuenta => tus pedidos y registra tus datos.';

        $model=Orden::model()->findByPk(59);
        $message = new YiiMailMessage;
                               // $subject = 'Gracias por registrarte en Sigma Tiendas';   
                               $subject = 'Tu compra en Sigma Tiendas';                                
                                $message->subject = $subject;
                                $message->view = "mail_template";
                                /*$body = '<h2>¡Bienvenido a Sigma Tiendas!</h2>
                                    Recibes este correo electrónico porque te has registrado en Sigmatiendas.com. 
                                    Por favor valida tu cuenta haciendo clic en el enlace que aparece a continuación:
                                    <br/><br/><a href="#">Clic aquí</a>';*/
                            $body=$this->renderPartial('/mail/mail_order_detail', array( 'model'=>Orden::model()->findByPk(59)),true);
                                $message->from = array(Yii::app()->params['adminEmail'] => "Sigma Tiendas");
                                $params=array('model'=>$model,'body'=>$body,'undercomment'=>$undercomment);
                                $message->setBody($params, 'text/html');                
                                $message->addTo('dduque@upsidecorp.ch');

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
    
    public function actionHome(){
        $this->render('landing');
    }
    
}