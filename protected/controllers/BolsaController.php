<?php

class BolsaController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('index'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','agregar','view','eliminar','authenticate','confirm','cities','addAddress','placeOrder',
								'sendValidationEmail','actualizar','agregarAjax','calcularEnvio',
								'authGC','pagoGC','confirmarGC','crearGC','sendsummary','comprarGC','pedidoGC','registrarpagoGC'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView()
	{
		$user = Yii::app()->user->id;
		$bolsa = Bolsa::model()->findByAttributes(array('users_id'=>$user));
		
		$this->render('view',array(
			'model'=>$bolsa,
		));
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	/*public function actionAgregar($id)
	{
		$user = Yii::app()->user->id;
		$bolsa = Bolsa::model()->findByAttributes(array('users_id'=>$user));
		
		if(isset($bolsa)){ 
			 
			$ag = new BolsaHasInventario; 
			$ag->bolsa_id = $bolsa->id;
			$ag->inventario_id = 3; // temporal
			$ag->cantidad = 1; 
			
			if($ag->save()){
				Yii::app()->user->setFlash('success', 'Se ha agregado correctamente el producto a la bolsa.');
			}else{
				var_dump($ag->getErrors());
				Yii::app()->user->setFlash('error', 'Error al agregar.');
			}	
		} 
		else
		{
			$nueva = new Bolsa;
			$nueva->users_id = $user;
			$nueva->save();
			// bolsa creada
			
			// por ahora pondre producto->id envez de inventario
			
			$ag = new BolsaHasInventario;
			$ag->bolsa_id = $nueva->id;
			$ag->inventario_id = 3;
			$ag->cantidad = 1;
			
			if($ag->save()){
				Yii::app()->user->setFlash('success', 'Se ha agregado correctamente el producto a la bolsa.');
			}else{
				Yii::app()->user->setFlash('error', 'Error al agregar.');
			}
							
		}	
		
		$this->redirect(array('view'));
		
	}*/

	public function actionAgregar(){

		$user = Yii::app()->user->id;
		$bolsa = Bolsa::model()->findByAttributes(array('users_id'=>$user));
		
		if(isset($bolsa)){ 
			 
			$ag = new BolsaHasInventario; 
			$ag->bolsa_id = $bolsa->id;
			$ag->inventario_id = $_POST['inventario_seleccionado_id'];
			$ag->cantidad = 1; 
			
			if($ag->save()){
				Yii::app()->user->setFlash('success', 'Se ha agregado correctamente el producto a la bolsa.');
			}else{
				var_dump($ag->getErrors());
				Yii::app()->user->setFlash('error', 'Error al agregar.');
			}	
		} 
		else{
			$nueva = new Bolsa;
			$nueva->users_id = $user;
			$nueva->save();
			// bolsa creada
			
			// por ahora pondre producto->id envez de inventario
			
			$ag = new BolsaHasInventario;
			$ag->bolsa_id = $nueva->id;
			$ag->inventario_id = $_POST['inventario_seleccionado_id'];
			$ag->cantidad = 1;
			
			if($ag->save()){
				Yii::app()->user->setFlash('success', 'Se ha agregado correctamente el producto a la bolsa.');
			}else{
				Yii::app()->user->setFlash('error', 'Error al agregar.');
			}
							
		}	
		
		$this->redirect(array('view'));
		
	}
	
	/** 
	 * Elimina un producto de la bolsa
	 */
	public function actionEliminar()
	{
		$id = $_POST['num'];
		
		$user = Yii::app()->user->id; 
		$bolsa = Bolsa::model()->findByAttributes(array('users_id'=>$user));

		$bh = BolsaHasInventario::model()->findByAttributes(array('bolsa_id'=>$bolsa->id,'inventario_id'=>$id));
		
		$bh->delete();
		
		echo 'ok';
	}
	

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Bolsa;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Bolsa']))
		{
			$model->attributes=$_POST['Bolsa'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 *  Calcular envio según la dirección seleccionada
	 */
	public function actionCalcularEnvio(){
		if (isset($_POST['direccion_id'])) {
			$direccion = DireccionEnvio::model()->findByPk($_POST['direccion_id']);
			$flete = Orden::model()->calcularTarifa($direccion->ciudad->cod_zoom, $_POST['numero_productos'], $_POST['peso'], $_POST['subtotal']);
			echo json_encode($flete);
		}
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Bolsa']))
		{
			$model->attributes=$_POST['Bolsa'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

/*
 * action para actualizar las cantidades del producto en el carrito
 * 
 * */
	public function actionActualizar(){
		 
		if (isset($_POST['accion'])){
			
			$arr = explode("-",$_POST['accion']);
			 
			$accion = $arr[0];
			$inventario = $arr[1];
			$cantidad = $_POST['cantidad'];
			
			if($_POST['cantidad']==1 && $accion=='menos')
			{
				// eliminar el objeto de la bolsa.
				
				$bolsa = Bolsa::model()->findByPk($_POST['bolsa']); 
				$bolsahas = BolsaHasInventario::model()->findByAttributes(array('bolsa_id'=>$bolsa->id,'inventario_id'=>$inventario));
				
				// $inventario = Inventario::model()->findByPk($bolsahas->inventario_id);
				
				$bolsahas->delete();
				
				Yii::app()->user->setFlash('success',"Producto eliminado.");
		        
				 // echo "borrado";
			}
			else{
				
				if($accion=='menos'){
					// eliminar el objeto de la bolsa.
					
					$bolsa = Bolsa::model()->findByPk($_POST['bolsa']); 
					$bolsahas = BolsaHasInventario::model()->findByAttributes(array('bolsa_id'=>$bolsa->id,'inventario_id'=>$inventario));
					
					$inventario = Inventario::model()->findByPk($bolsahas->inventario_id);
					
					$bolsahas->cantidad = $cantidad-1;
					$bolsahas->save();
					
			        Yii::app()->user->setFlash('success',"Cantidad actualizada exitosamente.");
			        
					// echo 'ok';
				}
				
				if($accion=='mas'){
					
					$bolsa = Bolsa::model()->findByPk($_POST['bolsa']); 
					$bolsahas = BolsaHasInventario::model()->findByAttributes(array('bolsa_id'=>$bolsa->id,'inventario_id'=>$inventario));
					
					$inventario = Inventario::model()->findByPk($bolsahas->inventario_id);
					
					if($inventario->cantidad < $_POST['cantidad']+1){
						Yii::app()->user->setFlash('error',"Lo sentimos, no es posible actualizar la cantidad. La Cantidad es mayor a la existencia en inventario.");	
						//echo 'NO';
					}
					else{
						$bolsahas->cantidad = $cantidad + 1;
						$bolsahas->save();
						
						Yii::app()->user->setFlash('success',"Cantidad actualizada exitosamente.");
						// echo 'ok';
					}
					
					
				}
				
				
			}
				 
		echo 'ala';	
		}
		
	} // actualizar


	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Bolsa');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Bolsa('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Bolsa']))
			$model->attributes=$_GET['Bolsa'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Autenticación de usuario al comenzar el proceso de compra
	 * Si la autenticación falla se devuelve a la bolsa, si es exitosa pasa al resumen de la compra
	 */
	public function actionAuthenticate(){
		$model=new UserLogin;
		$user = User::model()->findByPk(Yii::app()->user->id);
		if(isset($_POST['UserLogin']))
		{
			$model->attributes=$_POST['UserLogin'];
			// validate user input and redirect to previous page if valid
			if($model->validate()) {
				if($user->status == 0){
					Yii::app()->user->setFlash('error', 'Debe validar su cuenta para continuar ['.CHtml::link('Reenviar correo de validación', $this->createUrl('sendValidationEmail')).']');
					$this->redirect(array('view'));
				}
				$this->redirect(array('confirm'));
			}else{
				Yii::app()->user->setFlash('error', 'Debe ingresar los datos de su cuenta para continuar');
			}
		}
		$this->render('autenticar',array(
			'model'=>$model,
		));
	}

	public function actionSendValidationEmail(){
		$user = User::model()->findByPk(Yii::app()->user->id);
		$activation_url = $this->createAbsoluteUrl('/user/activation/activation',array("activkey" => $user->activkey, "email" => $user->email));
		//UserModule::sendMail($user->email,UserModule::t("Valida tu cuenta",UserModule::t("Por favor activa tu cuenta visitando el siguiente enlace: {activation_url}",array('{activation_url}'=>$activation_url)));
		// Falta enviar el correo
		Yii::app()->user->setFlash('error', 'Correo de validación enviado');
		$this->redirect(array('view'));
	}

	/**
	 * Confirmar compra
	 * Ingresar y validar todos los datos finales para la compra
	 */
	public function actionConfirm(){
		$user = User::model()->findByPk(Yii::app()->user->id);
		$addresses = DireccionEnvio::model()->findAllByAttributes(array('users_id'=>$user->id));
		$newAddress = new DireccionEnvio();
		$bolsa = Bolsa::model()->findByAttributes(array('users_id'=>$user->id));

		$this->render('confirm',array(
			'user'=>$user,
			'addresses'=>$addresses,
			'newAddress'=>$newAddress,
			'model'=>$bolsa,
		));
	}

	/**
	 * Busca las ciudades pertenecientes a un estado para llenar el dropdown en el formulario de nueva dirección
	 */
	public function actionCities(){
		
		if(isset($_POST['stateId'])){
			$cities = Ciudad::model()->findAllByAttributes(array('provincia_id'=>$_POST['stateId']), array('order'=>'nombre ASC'));
			$return = '';
			if(sizeof($cities) > 0){
				foreach ($cities as $city) {
					$return .= '<option value="'.$city->id.'">'.$city->nombre.'</option>';
				}
				echo $return;
			}
		}
	}

	/**
	 * Agregar una dirección desde el formulario de confirmación de compra
	 */
	public function actionAddAddress(){

		if(isset($_POST['DireccionEnvio'])){
				
			$model = new DireccionEnvio();
			$model->attributes=$_POST['DireccionEnvio'];
			$model->users_id = Yii::app()->user->id;
			
				if($model->save()){
					echo '<div class="radio">
				                <label>
				                    <input type="radio" class="address_checkbox" name="optionsRadios" id="address_'.$model->id.'" value="'.$model->id.'" checked>
				                    <strong>'.$model->nombre.': </strong>'.$model->direccion_1.' '.$model->direccion_2.'. '.$model->ciudad->nombre.', '.$model->provincia->nombre.'.
				                </label>
				            </div>';
				}
				else
				{
					echo CActiveForm::validate($model);
				}
			
		}
	}

	/**
	 * Recibe todos los datos necesarios y guarda la orden en base de datos, luego redirecciona al resumen del pedido
	 */
	public function actionPlaceOrder(){
		$user = User::model()->findByPk(Yii::app()->user->id);
		$bolsa = Bolsa::model()->findByAttributes(array('users_id'=>$user->id));

		$bolsa_has = BolsaHasInventario::model()->findAllByAttributes(array('bolsa_id'=>$bolsa->id));
		$subtotal = 0;
		if(isset($bolsa_has) && count($bolsa_has)>0 ){	
			foreach($bolsa_has as $uno){
				$inventario = Inventario::model()->findByPk($uno->inventario_id);
				if($inventario->estado ==1){
					$subtotal += $inventario->precio*$uno->cantidad;
				} // estado del inventario
			}
		}

		$orden = new Orden();
		$orden->descuento = 0;
		$orden->envio = $_POST['envio'];
		$orden->iva = 0;
		$orden->total = $subtotal + $_POST['envio']; //falta agregar el iva
		$orden->fecha = date('Y-m-d H:i:s');
		$orden->estado = 1;
		$orden->users_id = intval($user->id);
		$orden->tipo_pago_id = intval($_POST['payment_method_id']);
		
		if($orden->save()){
			foreach($bolsa_has as $uno){
				$inventario = Inventario::model()->findByPk($uno->inventario_id);	
				$orden_inventario = new OrdenHasInventario();
				$orden_inventario->cantidad = $uno->cantidad;
				$orden_inventario->precio = $inventario->precio;
				$orden_inventario->inventario_id = $inventario->id;
				$orden_inventario->orden_id = $orden->id;

				if($orden_inventario->save()){
					$inventario->cantidad -= $uno->cantidad;
					if($inventario->save()){
						$post_data = array(
							'status' => 'ok',
						    'order' => $orden->id,
						);
					}else{
						Yii::trace('UserID: '.$user->id.' Error al guardar compra (inventario):'.print_r($inventario->getErrors(),true), 'registro');
						$post_data = array(
							'status' => 'error',
						);
					}
					echo json_encode($post_data);
				}else{
					Yii::trace('UserID: '.$user->id.' Error al guardar compra (orden_inventario):'.print_r($orden_inventario->getErrors(),true), 'registro');
				}
				$uno->delete();
			}
		}else{
			Yii::trace('UserID: '.$user->id.' Error al guardar compra (orden):'.print_r($orden->getErrors(),true), 'registro');
		}


	}

	/* 1. Paso
	 * Paso de autenticacion para la compra de giftcard
	 */
	public function actionAuthGC(){
		// que esté logueado para llegar a esta acción
        if (!Yii::app()->user->isGuest) { 
	        //y que tenga giftcards en la bolsa
            $giftcard = BolsaGC::model()->findByAttributes(array("user_id" => Yii::app()->user->id));
            if(!$giftcard){
                $this->redirect(array("giftcard/comprar"));
            }
			
			$model=new UserLogin;
			$user = User::model()->findByPk(Yii::app()->user->id);
			
			if(isset($_POST['UserLogin']))
			{
				$model->attributes=$_POST['UserLogin'];
				// validate user input and redirect to previous page if valid
				
				if($model->validate()) {
					//Si esta activo - ir al siguiente paso
					if($user->status == 1){
						$this->redirect(array('bolsa/pagoGC'));
					}else{
						Yii::app()->user->setFlash('error',"Debes validar tu cuenta para continuar. Te hemos enviado un nuevo enlace de validación a <strong>".$user->email."</strong>"); 
						$activation_url = $this->createAbsoluteUrl('/user/activation/activation',array("activkey" => $user->activkey, "email" => $user->email));

						$message = new YiiMailMessage;
						$message->view = "mail_template";
						$subject = 'Activa tu cuenta en Sigma Tiendas';
						$body = "Estás recibiendo este email porque has solicitado un nuevo enlace para validar tu cuenta. Puedes continuar haciendo click en el siguiente enlace:<br/>".$activation_url;
						$params              = array('subject'=>$subject, 'body'=>$body);
						$message->subject    = $subject;
						$message->setBody($params, 'text/html');
						$message->addTo($user->email);
						$message->from = array(Yii::app()->params["adminEmail"] => 'Sigma Tiendas');
						Yii::app()->mail->send($message);
						$this->refresh();
					}
				}else{
					$this->render('authGC',array('model'=>$model));
				}	
			}else{
                // si no viene del formulario. O bien viene de la pagina anterior
                $this->render('authGC',array('model'=>$model));
			}
		}else{ // no va a llegar nadie que no esté logueado    
	        Yii::app()->user->setReturnUrl($this->createUrl('bolsa/authGC'));
	        Yii::app()->user->setFlash('error',"La sesión ha expirado, intenta tu compra nuevamente"); 
	        //Redirigir a login
	        $this->redirect(array('/user/login'));                        
		}
	} // AUTHGC

	/*2. Paso
	 * Paso para escoger el metodo de pago en la compra de giftcard
     * (solo tarjeta actualmente 04/12/2013)
	 */	
    public function actionPagoGC(){
	    if (Yii::app()->user->isGuest){
            //Redirigir a login
            Yii::app()->user->setReturnUrl($this->createUrl('bolsa/authGC'));
            Yii::app()->user->setFlash('error',Yii::t("contentForm", "¡La sesión ha expirado, intenta tu compra nuevamente!"));                              
            $this->redirect(array('/user/login'));                        
        }
	
	    if(isset($_POST['tipo_pago'])){
        	if($_POST['tipo_pago']==2 && isset($_POST['ajax']) && $_POST['ajax']==='tarjeta-form'){
                echo CActiveForm::validate($_POST['TarjetaCredito']);
                Yii::app()->end();
        	}
            //$tarjeta = new TarjetaCredito; 
            Yii::app()->getSession()->add('tipoPago',$_POST['tipo_pago']);
 
            if($_POST['tipo_pago'] == 2){ // pago de tarjeta de credito
	            $usuario = Yii::app()->user->id; 

	            $tarjeta->nombre = $_POST['TarjetaCredito']['nombre'];
	            $tarjeta->numero = $_POST['TarjetaCredito']['numero'];
	            $tarjeta->codigo = $_POST['TarjetaCredito']['codigo'];
	            $tarjeta->month = $_POST['TarjetaCredito']['month'];
	            $tarjeta->year = $_POST['TarjetaCredito']['year'];
	            $tarjeta->ci = $_POST['TarjetaCredito']['ci'];
	            $tarjeta->direccion = $_POST['TarjetaCredito']['direccion'];
	            $tarjeta->ciudad = $_POST['TarjetaCredito']['ciudad'];
	            $tarjeta->zip = $_POST['TarjetaCredito']['zip'];
	            $tarjeta->estado = $_POST['TarjetaCredito']['estado'];
	            $tarjeta->user_id = $usuario;		

	            if($tarjeta->save()){
                    Yii::app()->getSession()->add('idTarjeta',$tarjeta->id);
                    $this->redirect(array('bolsa/confirmarGC'));
	            }
	            else{
	            	echo CActiveForm::validate($tarjeta);
	            }
        	}
            else{
            	// colocar valor o algo para deposito (?)
                $this->redirect(array('bolsa/confirmarGC'));
            }

        }
        else{                
            //Comprobar que hay giftcards en la bolsa - si no, redirigir a la primera página
            $giftcard = BolsaGC::model()->findByAttributes(array("user_id" => Yii::app()->user->id));
            
            if(!$giftcard){
                $this->redirect(array("giftcard/comprar"));
            }
            
            $total = $giftcard->monto;
            Yii::app()->getSession()->add('total',$total);
            $this->render('pagoGC',array(               
                'total' => $total,
        	));		
        }

    }

    /*
	 * 3. Paso
	 * Paso para ver el resumen de la compra y hacer el pago
	 */
    public function actionConfirmarGC()
    {                            
	    if (Yii::app()->user->isGuest){
	        //Redirigir a login
	        Yii::app()->user->setReturnUrl($this->createUrl('bolsa/authGC'));
	        Yii::app()->user->setFlash('error',Yii::t("contentForm", "¡La sesión ha expirado, intenta tu compra nuevamente!"));                              
	        $this->redirect(array('/user/login'));                        
	    }

        //por los momentos solo la primera giftcard que encuentre
        $giftcard = BolsaGC::model()->findByAttributes(array("user_id" => Yii::app()->user->id));

        if(!$giftcard){
        	$this->redirect(array("giftcard/comprar"));
        }

        $monto = Yii::app()->getSession()->get('total');
         /* Para pago con tarjeta y paypal */
        $nombreProducto = "GiftCard Personaling";

        $tipo_pago = Yii::app()->getSession()->get('tipoPago');

        $optional = array(                        
            'name'          => 'Personaling Enterprise S.L.',
            'product_name'  => $nombreProducto,                             
        );                                            

        $this->render('confirmarGC',array(
            'idTarjeta'=> Yii::app()->getSession()->get('idTarjeta'),
            'monto'=> $monto,
            'giftcard' => $giftcard,
            'tipoPago' => $tipo_pago,
             ));
	}

	/**
     * Para pasar la tarjeta y cobrar
     */
    public function actionComprarGC()
	{

        $userId = Yii::app()->user->id;                 
        $tipoPago = Yii::app()->getSession()->get('tipoPago');	
        $total = Yii::app()->getSession()->get('total');
            
        switch ($tipoPago) {
        	case 1:
				$orden = new OrdenGC;                            
                $orden->estado = Orden::ESTADO_ESPERA; // En espera de pago 
                $orden->fecha = date("Y-m-d H:i:s"); // Datetime exacto del momento de la compra 
                $orden->total = $total;
                $orden->user_id = $userId;

                if (!($orden->save())){
                    echo CJSON::encode(array(
                                'status'=> 'error',
                                'error'=> $orden->getErrors(),
                            ));
                    Yii::app()->end();
                }

                //$this->crearGC($userId, $orden->id);
                	$user = User::model()->findByPk($userId);
                	$usuario = $user->profile; 
                	$message = new YiiMailMessage;                
			        $subject = 'Tu compra de Gift Card de Sigma Tiendas';
			        $body = "¡Hola <strong>{$usuario->first_name}</strong>!<br/><br/>
			                Hemos procesado satisfactoriamente tu compra de Gift Card.<br/>
			                Recuerda enviar tu pago para poder enviar la tarjeta de regalo a su destinatario.<br/>
			                Entra en la siguiente dirección para registrar tu pago <a href='http://telotengo.com/sigmatiendas/bolsa/registrarpagoGC'
			                title='Registrar'>Registrar Pago</a>";
			        $message->from = array(Yii::app()->params['adminEmail'] => "Sigma Tiendas");
			        $message->subject = $subject;
			        $message->setBody($body, 'text/html');
			        $message->addTo($user->email);
			        Yii::app()->mail->send($message);
                
            	break;
            case 2: // TARJETA DE CREDITO
                $tarjetaId = Yii::app()->getSession()->get('idTarjeta');
                $resultado = $this->cobrarTarjeta($tarjetaId, $userId, $total);
				$global = $resultado;

                if ($resultado['status'] == "ok")
                {
                    $tarjeta = TarjetaCredito::model()->findByPk($tarjetaId);
                    $detalle = new DetallePago();
                    $detalle->nTarjeta = $tarjeta->numero;
                    $detalle->nTransferencia = $resultado["idOutput"];
                    $detalle->nombre = $tarjeta->nombre;
                    $detalle->cedula = $tarjeta->ci;
                    $detalle->monto = $total;
                    $detalle->fecha = date("Y-m-d H:i:s");
                    $detalle->banco = 'TDC';
                    $detalle->estado = 1; // aceptado
                    
                    if(!$detalle->save()){
                        Yii::trace('UserID: '.$userId.' Error al guardar detalle:'.print_r($detalle->getErrors(),true), 'registro');
                    }
                            
                    $orden = new OrdenGC;                            
                    $orden->estado = Orden::ESTADO_CONFIRMADO;
                    $orden->fecha = date("Y-m-d H:i:s"); // Datetime exacto del momento de la compra 
                    $orden->total = $total;
                    $orden->user_id = $userId;
                       
                    if (!($orden->save())){
                        echo CJSON::encode(array(
                                    'status'=> 'error',
                                    'error'=> $orden->getErrors(),
                                ));
                        Yii::trace('UserID: '.$userId.' Error al guardar la orden:'.print_r($orden->getErrors(),true), 'registro');	
                        Yii::app()->end();
                    }	
	                    //Pasar de la bolsa a las giftcards
	                    $this->crearGC($userId, $orden->id);
	                    
	                    //Generar el detalle de pago
	                    $detalle->orden_id = $orden->id;
	                    $detalle->tipo_pago = 2;
	                    $detalle->save();
                    
                }else { 
                	$this->redirect($this->createAbsoluteUrl('bolsa/errorGC',array('codigo'=>$resultado['codigo'],'mensaje'=>$resultado['mensaje']),'http'));
                }			
                break;
            case 3:			        
                break;
        } 

        //Ver resumen del pedido
        if($tipoPago == 2){ // tarjeta
    		Yii::app()->session['voucher'] = $global['voucher'];
			Yii::app()->session['referencia'] = $global['referencia'];
		}
		
		$this->redirect($this->createAbsoluteUrl('bolsa/pedidoGC',array('id'=>$orden->id),'http'));	
    }
		

   /*Pasar de la bolsa a generar las giftcards*/
    public function crearGC($userId, $ordenId){
        
        $giftcards = BolsaGC::model()->findAllByAttributes(array("user_id" => $userId));		
        $resumen="";
        foreach($giftcards as $gift){
            
            $model = new Giftcard;
            $model->monto = $gift->monto;
            $model->plantilla_url = $gift->plantilla_url;
            
            $model->estado = 1; //inactiva hasta que pague con deposito
            $model->inicio_vigencia = date('Y-m-d');
            $now = date('Y-m-d', strtotime('now'));
            $model->fin_vigencia = date("Y-m-d", strtotime($now." + 1 year"));
            $model->comprador = $userId;

            do{  
                $model->codigo = Giftcard::generarCodigo();
                $existe = Giftcard::model()->countByAttributes(array('codigo' => $model->codigo));                        
            }while($existe);
            
            $model->orden_id = $ordenId;
            
            $model->save();
            $gift->delete();
			
            //Enviar la giftcard por correo solo si se selecciono email al comprar
            // o cuando no sea por deposito
            if(Yii::app()->getSession()->get('tipoPago') != 1){
            	                	
                $envio = new EnvioGiftcard();
                $campos = Yii::app()->getSession()->get('envio');                    
                
                $envio->nombre = $campos["nombre"];
                $envio->mensaje = $campos["mensaje"];
                $envio->email = $campos["email"];
                                    
                $saludo = "<strong>{$model->UserComprador->profile->first_name}</strong> te ha enviado una Gift Card como obsequio.";               

                $personalMes = ""; 
                
                if($envio->mensaje != ""){
                    $personalMes = "<br/><br/><i>" . $envio->mensaje . "</i><br/>";
                }
                                  
                $message = new YiiMailMessage;
                //Opciones de Mandrill
                $message->activarPlantillaMandrill("plantilla-correos-no-footer");
                $subject = 'Gift Card de Personaling';
                
                if(Yii::app()->language == "es_ve"){ 
                                    $body = "¡Hola <strong>{$envio->nombre}</strong>!<br><br> {$saludo} 
                    	                    <br/>".Yii::t('contentForm','Start enjoying your Gift Card in <a href="https://www.personaling.com.ve" title="Personaling">Personaling.com.ve</a> using it.')."
                    	                    <br/>
                                            (Para ver la Gift Card permite mostrar las imagenes de este correo) <br/><br/>";
                                    }
                                    else{
                                    $body = "¡Hola <strong>{$envio->nombre}</strong>!<br><br> {$saludo} 
                    	                    <br/>".Yii::t('contentForm','Start enjoying your Gift Card in <a href="https://www.personaling.es" title="Personaling">Personaling.es</a> using it.')."
                    	                    <br/>
                                            (Para ver la Gift Card permite mostrar las imagenes de este correo) <br/><br/>";	
                                    }

                $body = $this->renderPartial("//mail/_giftcard",
                        array('body' => $body,'envio' => $envio,
                            'model'=> $model), true);
                
                $message->subject = $subject;
                $message->setBody($body, 'text/html');
                $message->addTo($envio->email);
                Yii::app()->mail->send($message); 

                $resumen.="<tr><td>Email</td><td>{$envio->email}</td><td>{$model->monto}</td><tr>";
            }
            	 
        } 
        
        $this->actionSendSummary($ordenId,$userId);
	}	

	public function actionSendSummary($ordenId,$userId){
            			
        $comprador=User::model()->findByPk($userId);
        $user=$comprador->profile;
        
        $message = new YiiMailMessage;                
        $subject = 'Tu compra de Gift Card de Sigma Tiendas';
        $body = "¡Hola <strong>{$user->first_name}</strong>!<br/><br/>
                Hemos procesado satisfactoriamente tu compra de Gift Card.";

        $message->subject = $subject;
        $message->setBody($body, 'text/html');
        
        $message->addTo($comprador->email);
        return Yii::app()->mail->send($message);         
	}

	/**
	* Muestra el detalle de una compra de giftcard,
	* se puede imprimir la tarjeta
	*/
    public function actionPedidoGC($id){
		$orden = OrdenGC::model()->findByPk($id);
				
		$this->render('pedidoGC',array('orden'=>$orden,'voucher'=>Yii::app()->session['voucher'],'referencia'=>Yii::app()->session['referencia'],
										'tipoPago'=>Yii::app()->getSession()->get('tipoPago')));
	}

	public function actionRegistrarPagoGC($id){
		$pago = new DetalleOrden;

		if(isset($_POST['DetalleOrden']["nombre"])){
			// datos del deposito
			$pago->attributes = $_POST['DetalleOrden'];
			$pago->estado = 0; // sin revisar
			$pago->orden_id = $id;
			$pago->comentario = "Pago de Gift Card";
			$pago->tipo_pago_id = 2; // Deposito
			if($pago->save()){
				Yii::app()->user->setFlash('success',"El pago ha sido registrado satisfactoriamente. En un periodo de 12-24 horas estarás recibiendo tu Gift Card");       
			}else{
				var_dump($pago->getErrors());
				Yii::app()->end();
			} 
		} 
  
		$this->render('registrarpago',array('pago'=>$pago));
	} 
 
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Bolsa the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Bolsa::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Bolsa $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='address-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
