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
				'actions'=>array('create','update','agregar','view','eliminar','authenticate','confirm','cities','addAddress','placeOrder','sendValidationEmail','actualizar','agregarAjax','calcularEnvio'),
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
