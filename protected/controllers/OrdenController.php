<?php

class OrdenController extends Controller
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
				'actions'=>array('create','update','view','cancelar','listado','detalleusuario','ventas','detalle','calificarVendedor','reclamo','responderReclamo'
					,'devolucion','procesarDevolucion'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','verproductos','aceptarpago','rechazarpago','enviar','devolucion','procesarDevolucion','modalorden'),
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
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		$user = User::model()->findByPk(Yii::app()->user->id);
		if($model && ($model->users_id == Yii::app()->user->id || UserModule::isAdmin())){
			$this->render('view',array(
				'model'=>$model,
			));
		}
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Orden;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Orden']))
		{
			$model->attributes=$_POST['Orden'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
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

		if(isset($_POST['Orden']))
		{
			$model->attributes=$_POST['Orden'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionEnviar()
	{
		$orden = Orden::model()->findByPK($_POST['id']);
		
		$orden->tracking = $_POST['guia'];
		$orden->estado=4; // enviado
		
		if($orden->save())
			{
				// agregar cual fue el usuario que realizó la compra para tenerlo en la tabla estado
				$estado = new Estado;
										
				$estado->estado = 4;
				$estado->user_id = Yii::app()->user->id; // usuario que envio la orden, admin
				$estado->fecha = date("Y-m-d H:i:s");
				$estado->orden_id = $orden->id;
						
				if($estado->save())
				{
						$user = User::model()->findByPk($orden->users_id);		
						
						/* Enviando email de confirmación */
                        $message = new YiiMailMessage;
                        $subject = 'Tu compra #'.$orden->id.' ha sido despachada';                                
                        $message->subject = $subject;
                        $message->view = "mail_template";
                        $body = '<h2>Felicidades</h2>
                            Tu compra #'.$orden->id.' ya está en camino y en los próximos días llegará hasta tus manos.
                            <br/><br/>Datos de despacho:
							<br/>No. de Referencia: '.$orden->tracking.'
							<br/>Dirección destino: '.$orden->direccionEnvio->direccion_1.', '.$orden->direccionEnvio->ciudad->nombre.', '.$orden->direccionEnvio->provincia->nombre.'
							<br/>Recibe: '.$orden->direccionEnvio->nombre.'
							<br/>Envío por: Zoom
							<br/>Monto de envío: '.$orden->envio.'
							<br/><br/>Gracias por confiar en nosotros';
                        $message->from = array(Yii::app()->params['adminEmail'] => "Sigma Tiendas");
                        $message->setBody(array("body"=>$body, "undercomment"=>"Si tienes alguna pregunta acerca de tu cuenta, o cualquier otro asunto, por favor contáctanos en soporte@sigmatiendas.com"),'text/html');              
                        $message->addTo($user->email);

                        Yii::app()->mail->send($message);
					
					Yii::app()->user->setFlash('success', 'Se ha enviado la orden.');
					
					echo "ok";
				}
		}	
		
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$hasInventario = OrdenHasInventario::model()->findAllByAttributes(array('orden_id'=>$id));
		
		foreach($hasInventario as $eachone){
			$eachone->delete();
		}		
			
		$this->loadModel($id)->delete();
		
		Yii::app()->user->setFlash('success',"Pedido eliminado");
		
		$this->redirect(array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Orden');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new Orden();
		$model->unsetAttributes();  // clear any default values
		$bandera=false;
		$dataProvider = $model->search();
		
		/* Para mantener la paginacion en las busquedas */
		if(isset($_GET['ajax']) && isset($_SESSION['searchPedido']) && !isset($_POST['query'])){
			$_POST['query'] = $_SESSION['searchPedido'];
			$bandera=true;
		}

		/* Para buscar desde el campo de texto */
		if (isset($_POST['query'])){
			$bandera=true;
			unset($_SESSION['searchPedido']);
			$_SESSION['searchPedido'] = $_POST['query'];
            $model->id = $_POST['query'];
            $dataProvider = $model->search();
        }	

        if($bandera==FALSE){
			unset($_SESSION['searchPedido']);
        }
 
		$this->render('admin',array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Historial de órdenes para empresa vendedora
	 */
	public function actionVentas()
	{
		$model = new Orden();
		$model->unsetAttributes();  // clear any default values
		$orders = array();

		$usuario = User::model()->findByPk(Yii::app()->user->id);
		$empresas_user = EmpresasHasUsers::model()->findByAttributes(array('users_id'=>$usuario->id));
		foreach ($empresas_user as $empresa_user) {
			//$empresa = Empresas::model()->findByPk($empresa_user->empresas_id);
			$temp = $model->getEmpresaOrders($empresa_user->empresas_id);
			foreach ($temp as $t) {
				if(!in_array($t, $orders)){
					$orders[] = $t;
				}
			}

			//$orders = array_merge($orders, $temp));
		}
		

		//$model->ordenHasInventarios->inventario->almacen->empresas->id = $empresa->id;
		
		//$dataProvider = $model->search();

		$dataProvider=new CArrayDataProvider($orders, array(
		    'id'=>'orders-dataprovider',
		    'sort'=>array(
		        'attributes'=>array(
		             'fecha',
		        ),
		    ),
		    'pagination'=>array(
		        'pageSize'=>10,
		    ),
		));

		//print_r($dataProvider->getData());
		
		$this->render('listado_empresa',array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Detalle del modelo (verifica si es empresa o admin y muestra la vista respectiva)
	 */
	public function actionDetalle($id)
	{
		$model = $this->loadModel($id);
		
		$pagos = new DetalleOrden;
		$pagos->orden_id = $id;
		$dataProvider = $pagos->search();		
		
		$usuario = User::model()->findByPk(Yii::app()->user->id);

		if($usuario->superuser == 1){
			$this->render('detalle_admin',array(
				'model'=>$model,
				'dataProvider'=>$dataProvider,
			));
		}else if($usuario->hasEmpresasVendedoras()){
			$this->render('detalle_empresa',array(
				'model'=>$model,
				'dataProvider'=>$dataProvider,
			));
		}else if($model->users_id == Yii::app()->user->id){
			$this->render('detalle_usuario',array(
				'model'=>$model,
				'total'=>$dataProvider->totalItemCount,
				'dataProvider'=>$dataProvider,
			));
		}else{
			throw new Exception("No estás autorizado para ver esta página", 403);
			
		}
	}
	
	/**
	 * Detalle del modelo
	 */
	public function actionDetalleusuario($id)
	{
		$model = $this->loadModel($id);
		$pagos = new DetalleOrden;
		
		$pagos->orden_id = $id;
		
		$dataProvider = $pagos->search();
		
		if(isset($_POST['DetalleOrden']))
		{
			$modeloDetalle = New DetalleOrden;
			$modeloDetalle->attributes = $_POST['DetalleOrden'];
            $modeloDetalle->fecha = date("Y-m-d h:i:s",strtotime(str_replace('/', '-',$_POST['DetalleOrden']['fecha'])));

			$modeloDetalle->estado=0; // pago enviado, queda en Default en espera de decision del administrador
			$modeloDetalle->tipo_pago_id = 2; // deposito o transferencia

			$modeloDetalle->save(); 
			
			Yii::app()->user->setFlash('success',"Su pago se ha registrado exitosamente.");
			
			$model->estado = 2; // en espera de confirmacion
		      $model->save();
		
		}
		
		$this->render('detalle_usuario',array(
			'model'=>$model,
			'total'=>$dataProvider->totalItemCount,
			'dataProvider'=>$dataProvider,
		));
		
	}

	/**
	 * Procesar una devolución para una orden
	 */
	public function actionDevolucion($id){
		$model = $this->loadModel($id);
		$devolucion = new Devolucion();

		$this->render('devolucion',array(
			'model'=>$model,
			'devolucion'=>$devolucion,
		));
	}

	/**
	 * Función que se llama por ajax para procesar la devolución de productos
	 */
	public function actionProcesarDevolucion(){
		if(isset($_POST['orden']) && isset($_POST['check']))
		{
			$checks = explode(',',$_POST['check']); // checks va a tener los id de orden_has_inventario
			$cont = 0; 
			
			foreach($checks as $uno)
			{
				$orden = Orden::model()->findByPk($_POST['orden']);
				$orden_inventario = OrdenHasInventario::model()->findByPk($uno);
				
				$devuelto = new Devolucion; 
				
				$devuelto->user_id = $orden->users_id;
				$devuelto->orden_has_inventario_id = $orden_inventario->id;
				
				$devuelto->motivo = $_POST['motivos'][$cont];
				$devuelto->monto_devuelto = $_POST['monto'];
				$devuelto->monto_envio = $_POST['envio'];
				
				$devuelto->save();
				
				if($_POST['motivos'][$cont] != "Devolución por artículo dañado")
				{
					$orden_inventario->inventario->cantidad ++; // devuelvo el artículo a inventario
					$orden_inventario->inventario->save();
				}

				$cont++;
			}
			
			// devolviendo el saldo
                        //tambien agregado el envio
			
			$balance = new Balance;
			$balance->total = $_POST['monto'] + $_POST['envio'];
			$balance->orden_id = $_POST['orden'];
			$balance->user_id = $orden->users_id;
			$balance->tipo = 4;
			
			$balance->save();
			
			// revisando si es una devolucion completa o parcial
			$devueltos = count($_POST['motivos']);
			$total = OrdenHasInventario::model()->countByAttributes(array('orden_id'=>$_POST['orden']));
			
			if($devueltos == $total){
				$orden->estado = 9; // devuelto
				
				$estado = new Estado;
				
				$estado->estado = 9;
				$estado->user_id = $orden->users_id;
				$estado->fecha = date("Y-m-d");
				$estado->orden_id = $orden->id;
				
				$estado->save();
			}					
			else if($devueltos < $total){
				$orden->estado = 10; // parcialmente devuelto
				
				$estado = new Estado;
				
				$estado->estado = 10;
				$estado->user_id = $orden->users_id;
				$estado->fecha = date("Y-m-d");
				$estado->orden_id = $orden->id;
				
				$estado->save();
			}
			
			$orden->save();
			Yii::app()->user->setFlash('success',"Devolución exitosa.");
			echo "ok";
		}
	}


	/**
	 * Calificar un vendedor por una orden_has_inventario
	 */
	public function actionCalificarVendedor($id)
	{
		$orden_inventario = OrdenHasInventario::model()->findByPk($id);
		$calificacion = new CalificacionEmpresa;
		$caracteristicas_nosql = Caracteristica::model()->findAllByAttributes(array('inventario_id'=>$orden_inventario->inventario->id));                                                     
        $caracteristicas = '';
        $cont = 1;
        foreach ($caracteristicas_nosql as $c_nosql) {
            if($cont == sizeof($caracteristicas_nosql)){
                $caracteristicas .= $c_nosql->valor;
            }else{
                $caracteristicas .= $c_nosql->valor.', ';
            }
            $cont++;
        }
		
		
		if(isset($_POST['CalificacionEmpresa'])){
			$calificacion->attributes = $_POST['CalificacionEmpresa'];
			$calificacion->fecha = date('Y-m-d h:i:s', time()); 
			$calificacion->empresas_id = $orden_inventario->inventario->almacen->empresas->id;
			$calificacion->user_id = Yii::app()->user->id;
			$calificacion->orden_id = $orden_inventario->orden->id;
			
			$calificacion->save(); 
			
			Yii::app()->user->setFlash('success',"Calificación guardada");
			$this->redirect(Yii::app()->baseUrl.'/orden/detalleusuario/'.$orden_inventario->orden->id);
		}
		
		$this->render('calificar_vendedor',array(
			'orden_inventario'=>$orden_inventario,
			'calificacion'=>$calificacion,
			'caracteristicas'=>$caracteristicas,
		));
		
	}

	/**
	 * Procesar un reclamo para una orden_has_inventario
	 */
	public function actionReclamo($id)
	{
		$orden_inventario = OrdenHasInventario::model()->findByPk($id);
		$reclamo = new Reclamo;
		$caracteristicas_nosql = Caracteristica::model()->findAllByAttributes(array('inventario_id'=>$orden_inventario->inventario->id));                                                     
        $caracteristicas = '';
        $cont = 1;
        foreach ($caracteristicas_nosql as $c_nosql) {
            if($cont == sizeof($caracteristicas_nosql)){
                $caracteristicas .= $c_nosql->valor;
            }else{
                $caracteristicas .= $c_nosql->valor.', ';
            }
            $cont++;
        }
		
		
		if(isset($_POST['Reclamo'])){
			$reclamo->attributes = $_POST['Reclamo'];
			$reclamo->fecha = date('Y-m-d h:i:s', time()); 
			$reclamo->estado = 1;
			$reclamo->empresa_id = $orden_inventario->inventario->almacen->empresas->id;
			$reclamo->user_id = Yii::app()->user->id;
			$reclamo->orden_id = $orden_inventario->orden->id;
			$reclamo->orden_inventario_id = $orden_inventario->id;
			
			$reclamo->save(); 
			
			Yii::app()->user->setFlash('success',"Reclamo enviado");
			$this->redirect(Yii::app()->baseUrl.'/orden/detalleusuario/'.$orden_inventario->orden->id);
		}
		
		$this->render('reclamo',array(
			'orden_inventario'=>$orden_inventario,
			'reclamo'=>$reclamo,
			'caracteristicas'=>$caracteristicas,
		));
		
	}

	/**
	 * Responder un reclamo para una orden_has_inventario
	 */
	public function actionResponderReclamo($id)
	{
		$reclamo = Reclamo::model()->findByPk($id);
		$reclamo_comentario = new ReclamoComentarios;

		$caracteristicas_nosql = Caracteristica::model()->findAllByAttributes(array('inventario_id'=>$reclamo->orden_inventario->inventario->id));                                                     
        $caracteristicas = '';
        $cont = 1;
        foreach ($caracteristicas_nosql as $c_nosql) {
            if($cont == sizeof($caracteristicas_nosql)){
                $caracteristicas .= $c_nosql->valor;
            }else{
                $caracteristicas .= $c_nosql->valor.', ';
            }
            $cont++;
        }
		
		if(isset($_POST['ReclamoComentarios'])){
			$reclamo_comentario->attributes = $_POST['ReclamoComentarios'];
			$reclamo_comentario->fecha = date('Y-m-d h:i:s', time()); 
			$reclamo_comentario->user_id = Yii::app()->user->id;
			$reclamo_comentario->reclamo_id = $id;
			
			$reclamo_comentario->save(); 
			
			Yii::app()->user->setFlash('success',"Comentario enviado");
			$this->redirect(Yii::app()->baseUrl.'/orden/detalle/'.$reclamo->orden_id);
		}
		
		$this->render('responder_reclamo',array(
			'reclamo'=>$reclamo,
			'reclamo_comentario'=>$reclamo_comentario,
			'caracteristicas'=>$caracteristicas,
		));
		
	}
	
	/**
	 * Ver Productos
	 */
	public function actionVerproductos($id)
	{ 
		$model = $this->loadModel($id);
		
		$this->render('_productos',array(
			'model'=>$model,
		));
		
	}
	
	/**
	 * Cancelar el pedido
	 */
	public function actionCancelar($id)
	{
		$pedido = $this->loadModel($id);
		
		$pedido->estado = 5;
		$pedido->save();
		
		Yii::app()->user->setFlash('success',"Pedido cancelado exitosamente.");

		if(Yii::app()->user->isAdmin())
			$this->redirect(array('admin'));
		else{
			$user = User::model()->findByPk(Yii::app()->user->id);
			if($user->hasEmpresasVendedoras()){
				$this->redirect(array('ventas'));
			}else{
				$this->redirect(array('listado'));
			}
		}
	}
	
	/**
	 * Listado de usuario
	 */
	public function actionListado()
	{ 
		$user = User::model()->findByPk(Yii::app()->user->id);
			
		$model = new Orden();
		$model->unsetAttributes();  // clear any default values
		
		$model->users_id = $user->id;
		$dataProvider = $model->search();
		
		$this->render('listado_usuario',array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));
		
	}
	
	/**
	 * Aceptar Pago
	 */
	public function actionAceptarpago($id)
	{
		$detalle = DetalleOrden::model()->findByPk($id);
		$detalle->estado = 1; // pago aceptado
		
		$orden = Orden::model()->findByPk($detalle->orden_id);
		$porpagar=$orden->getxPagar();
		
		if($detalle->save()){
		//Revisando si lo depositado es > o = al total de la orden. 
		
			$diferencia_pago = round(($detalle->monto - $porpagar),3,PHP_ROUND_HALF_DOWN);
			//$diferencia_pago = round(($detalle->monto - $orden->total),3,PHP_ROUND_HALF_DOWN);
			
			if($diferencia_pago >= 0){ // Pago completo o de más 
				
				$productosOrden = OrdenHasInventario::model()->findAllByAttributes(array('orden_id'=>$orden->id));

				foreach($productosOrden as $inv){
					$inventario = Inventario::model()->findByPk($inv->inventario_id); // se busca el inventario al que apunta
					$inventario->cantidad -= $inv->cantidad; // se descuenta la cantidad comprada ya que se aprobó el pago
					$inventario->save();
				}					

				$orden->estado = 3; // pago confirmado
				$orden->save();
				 
				Yii::app()->user->setFlash('success',"Su pago ha sido aceptado y su orden ha sido confirmada.");			

				if(($diferencia_pago) > 0.5)
				{
					$balance = new Balance;
					$balance->orden_id = $orden->id;
					$balance->user_id = $orden->users_id;
					$balance->total = $diferencia_pago;
					$balance->tipo = 0; // balance positivo

					$balance->save();

					// Enviando mail de saldo positivo
					$user = User::model()->findByPk($orden->users_id);		
					
                    $message = new YiiMailMessage;
                    $subject = 'Tu compra #'.$orden->id.' te dejó un balance positivo';                                
                    $message->subject = $subject;
                    $message->view = "mail_template";
                    $body = '<h2>Hola '.$user->email.'</h2>
                        El pago de tu compra #'.$orden->id.' fue mayor a lo que debías pagar. Es por esto que hemos sumado la diferencia a tu balance.<br/>
                        Un total de '.$diferencia_pago.' Bs. han sido sumados a tu balance para que puedas seguir comprando sin problemas.<br/>
						<br/><br/>Gracias por confiar en nosotros';
                    $message->from = array(Yii::app()->params['adminEmail'] => "Sigma Tiendas");
                    $message->setBody(array("body"=>$body, "undercomment"=>"Si tienes alguna pregunta acerca de tu cuenta, o cualquier otro asunto, por favor contáctanos en soporte@sigmatiendas.com"),'text/html');              
                    $message->addTo($user->email);

                    Yii::app()->mail->send($message);
					
					Yii::app()->user->setFlash('success', 'Se ha enviado la orden.');

				} // si es mayor hace el balance

				// mail de pago aceptado

				$user = User::model()->findByPk($orden->users_id);		
				
                $message = new YiiMailMessage;
                $subject = 'Hemos aceptado tu pago';                                
                $message->subject = $subject;
                $message->view = "mail_template"; 
                $body = '<h2>Hola '.$user->email.'</h2>
                    El pago de tu compra #'.$orden->id.' ha sido aceptado.<br/>
                    En las próximas horas estaremos enviando tu compra.<br/>
					<br/><br/>Gracias por confiar en nosotros';
                $message->from = array(Yii::app()->params['adminEmail'] => "Sigma Tiendas");
                $message->setBody(array("body"=>$body, "undercomment"=>"Si tienes alguna pregunta acerca de tu cuenta, o cualquier otro asunto, por favor contáctanos en soporte@sigmatiendas.com"),'text/html');              
                $message->addTo($user->email);

                Yii::app()->mail->send($message);
			} 
			else{ // pago incompleto
				$diferencia_pago = 0 - $diferencia_pago;
				$orden->estado = 7; // pago insuficiente
				$orden->save();	
				Yii::app()->user->setFlash('error',"Su pago ha sido aceptado pero faltan Bs. ".$diferencia_pago);


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

				// mail de pago aceptado
				$user = User::model()->findByPk($orden->users_id);		
				
                $message = new YiiMailMessage;
                $subject = 'Tu pago ha sido aceptado pero ha sido incompleto';                                
                $message->subject = $subject;
                $message->view = "mail_template"; 
                $body = '<h2>Hola '.$user->email.'</h2>
                    El pago de tu compra #'.$orden->id.' ha sido aceptado pero el mismo ha sido incompleto.<br/>
                    <br/>Dinero restante por depositar: '.$diferencia_pago.' Bs.<br/>
					<br/><br/>Gracias por confiar en nosotros';
                $message->from = array(Yii::app()->params['adminEmail'] => "Sigma Tiendas");
                $message->setBody(array("body"=>$body, "undercomment"=>$undercomment),'text/html');              
                $message->addTo($user->email);

                Yii::app()->mail->send($message);

			}
			
		}
		else
			var_dump($detalle->getError());

		$this->redirect(array('detalle','id'=>$orden->id));
	}
	
	/**
	 * Rechazar Pago
	 */
	public function actionRechazarpago($id)
	{ 
		$detalle = DetalleOrden::model()->findByPk($id);
		$detalle->estado = 2; // pago rechazado
		
		$orden = Orden::model()->findByPk($detalle->orden_id);
		
		if($detalle->save()){
			//Revisando si lo depositado es > o = al total de la orden. 
			$orden->estado = 6; // pago rechzado
			$orden->save();	
			
			Yii::app()->user->setFlash('error',"Su pago ha sido rechazado.");	
		}
		
		$this->redirect(array('detalle','id'=>$orden->id));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Orden::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='orden-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionModalorden($id){
		
		$id = $_POST['orden'];
	
		$ordenInventario = OrdenHasInventario::model()->findAllByAttributes(array('orden_id'=>$id));

		$html='';
		$html=$html.'<div class="modal-header no_border">';
    	$html=$html.'<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';

  		$html=$html.'</div>';
  		$html=$html.'<div class="modal-body">';
    	$html=$html.'';

    	// Tabla ON
    	//Header de la tabla ON
   		$html=$html.'<div class="margin_bottom"><h1 class="no_margin_top">Productos incluídos <small>Pedido N° '.$id.'</small></h1><hr class="no_margin_top"/></div>';
        
        
      	$html=$html.'<table width="50%" border="0" cellspacing="0" cellpadding="0" class="table">';
        $html=$html.'<thead><tr>';
        $html=$html.'<th scope="col"></th>';
        $html=$html.'<th scope="col"></th>';
        $html=$html.'<th scope="col">Cantidad</th>';
        $html=$html.'<th scope="col">Precio </th>';
        $html=$html.'</tr>';
        $html=$html.'</thead><tbody>';
        
		foreach($ordenInventario as $cadaInventario){
			$inventario = Inventario::model()->findByPk($cadaInventario->inventario_id);
			$producto = $inventario->producto;
	 
			$html=$html.'<tr>';

			$principal = Imagenes::model()->findByAttributes(array('orden'=>1,'producto_id'=>$inventario->producto_id));
                                                                    
            if($principal->getUrl())
                $im = CHtml::image(str_replace(".","_thumb.",$principal->getUrl()), "Thumbnail",
                		array("height"=>"100px", "width" => "100px",'class'=>'img-responsive'));
            else
                $im = '<img src="http://placehold.it/100x100" width="100%">';   

            // imagen
	        $html=$html.'<td>'.$im.'</td>';
	        // nombre
	        $html=$html.'<td><strong>'.$producto->nombre.'</strong></td>';
	        // Cantidad
	        $html=$html.'<td>'.$inventario->cantidad.'</td>';
	        
	        $html=$html.'<td>'; 
			$html=$html.number_format($inventario->precio, 2, ',', '.')."  Bs.";
	        $html=$html.'</td>';     

        	$html=$html.'<tr>';
		}

        //Cuerpo de la tabla OFF
        $html=$html.'</tbody></table></div>';
        // Tabla OFF
  		$html=$html.'</div></div>';
		echo $html;
	}

}
