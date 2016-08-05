<?php

class EmpresasController extends Controller
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
			array('allow',  // allow all users
				'actions'=>array('index','view','create','solicitudFinalizada', 'selectdos'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update','listado','cancelar', 'complete', 'agregarDocumento', 'eliminarDocumento', 'agregarDato', 'eliminarDato','getAlmacenes','inventarios','ventas'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','vendedoras','compradoras','solicitudes','detalles','aprobar','rechazar','suspender','update','calificaciones','eliminarCalificacion', 'verEmpresa'),
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model. 
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
			
		#echo Yii::app()->session['cliente'];
		$model = new Empresas;
		//$this->layout='//layouts/b2b';
		$empresa_user = new EmpresasHasUsers();
		$rol='';

		if(isset(Yii::app()->session["usuarionuevo"])){
			//$user = User::model()->findByAttributes(array('email'=>Yii::app()->session["usuarionuevo"]));
		}
		elseif(isset(Yii::app()->session['cliente'])){
			$user = User::model()->findByPk(Yii::app()->session['cliente']);
		}
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$model->tipoEmpresa="vendedor";
		if(isset($_POST['Empresas']))
		{

			
			if(isset(Yii::app()->session['vacio'])) //evitar el bug de dejar el registro a medias
			{
				
				
				$email= Yii::app()->session['usuarionuevo'];
				
				$modelado = new RegistrationForm;
        		$profile = new Profile;
				$profile->regMode = true;
				$profile->attributes=Yii::app()->session['atributos'];
				
				$soucePassword = User::generarPassword();
				$modelado->email = Yii::app()->session['usuarionuevo'];
				$modelado->status=0;
				$modelado->username = Yii::app()->session['usuarionuevo']; #Mismo Mail
				$modelado->activkey = UserModule::encrypting(microtime().$soucePassword);
				$modelado->password = UserModule::encrypting($soucePassword);
				$modelado->verifyPassword = UserModule::encrypting($modelado->verifyPassword);
				$modelado->quien_invita = 0; #el mismo, se modifica cuando tenga ID luego del save
				$modelado->type = User::TYPE_USUARIO_SOLICITA;
				$profile->user_id=0;
				

				if($modelado->validate()&&$profile->validate())
				{
					if($modelado->save()){
						if(isset(Yii::app()->session['usuarionuevo'])){
							$modelado->quien_invita = $modelado->id;
							$modelado->save();
						}
	
						$profile->user_id = $modelado->id;
						$profile->save();	
					}
				}
			}elseif(isset(Yii::app()->session['cliente'])) //evitar el bug de dejar el registro a medias
			{
				$user = User::model()->findByPk(Yii::app()->session['cliente']);
				$email=$user->email;
        		$profile = Profile::model()->findByPk(Yii::app()->session['cliente']);
				$profile->regMode = true;
				$profile->attributes=Yii::app()->session['atributos'];
				
				$soucePassword = User::generarPassword();
	
				$profile->save();

			}

			
			$model->attributes=$_POST['Empresas'];
			$model->telefono=$_POST['Empresas']['telefono'];
			$model->direccion=$_POST['Empresas']['direccion'];
			$model->estado = 1; # solicitado 
			#$model->forma_legal = $_POST['Empresas']['forma_legal'];
			$model->sector = $_POST['Empresas']['sector'];
			if($_POST['Empresas']['cargo']=="Otro")
				$model->cargo=$_POST['Empresas']['otraOpcion'];
			else
				$model->cargo = $_POST['Empresas']['cargo'];
			$model->zip = $_POST['Empresas']['zip'];
			#$model->num_empleados = $_POST['Empresas']['num_empleados'];
			$rol=$_POST['Empresas']['tipoEmpresa'];
			$model->rol=$rol;
			if(isset(Yii::app()->session['vacio'])) //evitar el bug de dejar el registro a medias
			{
				$model->tipo=User::TYPE_USUARIO_SOLICITA;	
			}	
			else
			{
				$model->tipo = $user->type; # el mismo tipo de empresa que recibio en la invitación	
			}
			

			if($model->save()){
				$model->refresh();
				if(isset(Yii::app()->session['usuarionuevo']))
					$user = User::model()->findByAttributes(array('email'=>Yii::app()->session["usuarionuevo"]));
				
				$empresa_user->empresas_id = $model->id;
				$empresa_user->users_id = $user->id;
				$empresa_user->rol = $_POST['Empresas']['cargo'];
				Yii::app()->authManager->assign($rol,$user->id);
				$empresa_user->save();				
				$almacen = new Almacen;
				$almacen->provincia_id=$_POST['Empresas']['provincia'];
				$almacen->ciudad_id=$_POST['Empresas']['ciudad'];
				$almacen->ubicacion=$_POST['Empresas']['direccion'];
				$almacen->empresas_id=$model->id;
				$almacen->alias=$model->razon_social.' - principal';
				$almacen->nombre=$model->razon_social.' - principal';
				$almacen->save();

				$message = new YiiMailMessage;
				$message->activarPlantillaMandrill();					
				$body=Yii::app()->controller->renderPartial('//mail/solicitudRecibida', array( '$user'=>$user ),true);				
				$message->subject= "Solicitud recibida";
				$message->setBody($body,'text/html');
								
				$message->addTo($email);
				Yii::app()->mail->send($message);
				
				if(Yii::app()->session['tipo']=="") // en caso de ser una peticion normal
				{
					$user->pendiente=1;
					$user->save();	
					$this->redirect(array('solicitudFinalizada'));
				}
				if(Yii::app()->session['username']!="admin" && Yii::app()->session['username']!="" && Yii::app()->session['cliente']!="") // para el caso de que la invitacion sea para crear una empresa, hecha por otra empresa
				{
					$user->pendiente=1;
					$user->save();	
					$this->redirect(array('solicitudFinalizada'));
				}
				
				if(isset(Yii::app()->session['cliente'])) ///LLEVAR HACER LA CONTRASENA CUANDO SE ESTE invitando desde el admin como empresa
				{
					$this->redirect(Yii::app()->session['url_act']);
				}
				$this->redirect(array('solicitudFinalizada'));
			}
		}
		
		$this->render('create',array(
			'model'=>$model,
			//'user' => $user,
			//'profile' => $user->profile,
		));
	}

	/*
	Action para el finalizar la solicitud
	*/
	public function actionSolicitudFinalizada()
	{
		//$this->layout='//layouts/b2b';
		Yii::app()->user->setFlash('success', 'Solicitud realizada con éxito. Pronto estaremos en contacto contigo.');

		$this->render('solicitudFinalizada');
	}

	public function actionComplete($user = NULL, $empresa_id)
	{
		$model = Empresas::model()->findByPk($empresa_id);;
		//$empresa_user = new EmpresasHasUsers();
		if(!$user){
			$user = User::model()->findByPk(Yii::app()->user->id);
		}

		$documentos = Documentos::model()->findAllByAttributes(array('empresas_id'=>$model->id));
		$datos = DatosContacto::model()->findAllByAttributes(array('empresa_id'=>$model->id));
		

		$this->render('complete_info',array(
			'model'=>$model,
			'user' => $user,
			'profile' => $user->profile,
			'documentos' => $documentos,
			'datos' => $datos,
		));
	}

	public function actionAgregarDocumento($empresa_id = NULL)
	{
		$model = new Documentos();
		if($empresa_id){
			$empresa = Empresas::model()->findByPk($empresa_id);
		}else if(isset($_POST['Documentos'])){
			$empresa = Empresas::model()->findByPk($_POST['Documentos']['empresas_id']);
		}
		$model->empresas_id = $empresa->id;

        if(isset($_POST['Documentos'])){
        	$rnd = rand(0,9999);  // generate random number between 0-9999
            $model->attributes=$_POST['Documentos'];
            //$model->tipo=$_POST['Documentos']['tipo'];
            //$model->ruta=$_POST['Documentos']['ruta'];

            $uploadedFile=CUploadedFile::getInstance($model,'ruta');
            $fileName = $rnd.'-'.$uploadedFile;  // random number + file name
            $model->ruta = $fileName;
            if($model->save()){
            	if (!is_dir(Yii::app()->params['uploadPath'] . $empresa->id)) {
        			mkdir(Yii::app()->params['uploadPath'] . $empresa->id);
   				}
                $uploadedFile->saveAs(Yii::app()->params['uploadPath'].$empresa->id.'/'.$fileName);
                Yii::app()->user->setFlash('success', 'Documento cargado con éxito');
                //$this->redirect(array('complete', 'empresa_id'=>$empresa_id));
            }else{
            	Yii::app()->user->setFlash('error','Error al subir el documento');
            }
            $this->redirect(array('complete', 'empresa_id'=>$empresa_id));
        }
		
		

		$this->render('agregar_documento',array(
			'model'=>$model,
			'empresa'=>$empresa,
		));
	}

	public function actionEliminarDocumento($id){
		$documento = Documentos::model()->findByPk($id);
		$empresa_id = $documento->empresas_id;
		if($documento){
			$documento->delete();
			Yii::app()->user->setFlash('success', 'Documento eliminado con éxito');
			$this->redirect(array('complete', 'empresa_id'=>$empresa_id));
		}
	}

	public function actionAgregarDato($empresa_id = NULL){
		$model = new DatosContacto();
		if($empresa_id){
			$empresa = Empresas::model()->findByPk($empresa_id);
		}else if(isset($_POST['Documentos'])){
			$empresa = Empresas::model()->findByPk($_POST['Documentos']['empresas_id']);
		}
		$model->empresa_id = $empresa->id;

        if(isset($_POST['DatosContacto'])){
            $model->attributes=$_POST['DatosContacto'];
            if($model->save()){
                Yii::app()->user->setFlash('success', 'Datos guardados con éxito');
            }else{
            	Yii::app()->user->setFlash('error','Error al guardar los datos');
            }
            $this->redirect(array('complete', 'empresa_id'=>$empresa_id));
        }

		$this->render('agregar_dato',array(
			'model'=>$model,
			'empresa'=>$empresa,
		));
	}

	public function actionEliminarDato($id)
	{
		$dato = DatosContacto::model()->findByPk($id);
		$empresa_id = $dato->empresa_id;
		if($dato){
			$dato->delete();
			Yii::app()->user->setFlash('success', 'Datos eliminado con éxito');
			$this->redirect(array('complete', 'empresa_id'=>$empresa_id));
		}
	}

	public function actionListado(){
		$model = new EmpresasHasUsers;
		
		$model->users_id = Yii::app()->user->id;
		$dataProvider = $model->search();
		
		$this->render('listado',array(
			'model' => $model,
			'dataProvider' => $dataProvider,
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
		#$empresa_users = EmpresasHasUsers::model()->findByAttributes(array('empresas_id'=>$id));		
			
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Empresas']))
		{
			if($_POST['Empresas']['ciudad']=="")
				$_POST['Empresas']['ciudad']=$_POST['Empresas']['ciudad2'];
			$model->zip=$_POST['Empresas']['zip'];
			$model->attributes=$_POST['Empresas'];
			#$model->rol=$_POST['Empresas']['tipoEmpresa'];
			if($model->save())
			{
				Yii::app()->user->setFlash('success', 'Datos modificados correctamente.');
				
				if(Yii::app()->user->isAdmin())
				{
					$log=new Log;
					$log->id_admin=Yii::app()->user->id;
					$log->id_empresa=$id;
					$log->fecha=date('Y-m-d G:i:s');
					$log->accion=16; //modifico a una empresa
					$log->save();
					$this->redirect(array('admin'));
				}
				else
				{
					$this->redirect(array('listado'));
				}
			}
				
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}


	public function actionCancelar()
	{
		$model = Empresas::model()->findByPk($_GET['id']); 
		
		$model->estado = 5; // cancelado 
		
		$rif = explode("-", $model->rif);
		$model->prefijo = $rif[0];
		$model->numero = $rif[1];
		
		if($model->save())
		{		
			Yii::app()->user->setFlash('success',"Se ha cancelado la solicitud.");
			$this->redirect(array('listado'));
		}

	}
	
	
	public function actionDetalles($id){
		$model=$this->loadModel($id);
		
		$et = EmpresasHasUsers::model()->findByAttributes(array('empresas_id'=>$id));
		$user = User::model()->findByPk($et->users_id);
		
		$this->render('detalles',array(
			'model'=>$model,
			'user'=>$user,
		));
		
	}

	/**
	 * Aprobar una solicitud para vender
	 */
	public function actionAprobar($id)
	{
		$model=$this->loadModel($id);
		$model->estado = 2;
		$rif = explode("-", $model->rif);
		$model->prefijo = $rif[0];
		$model->numero = $rif[1];
		if($model->save()){
			Yii::app()->user->setFlash('success', 'Solicitud aprobada');
		}else{
			Yii::app()->user->setFlash('error', 'Error al aprobar la solicitud');
		}
		
		$this->redirect(array('vendedoras'));
	}

	/**
	 * Rechazar una solicitud para vender
	 */
	public function actionRechazar($id)
	{
		$model=$this->loadModel($id);
		$model->estado = 3;
		$rif = explode("-", $model->rif);
		$model->prefijo = $rif[0];
		$model->numero = $rif[1];
		if($model->save()){
			Yii::app()->user->setFlash('success', 'Solicitud rechazada');
		}else{
			Yii::app()->user->setFlash('error', 'Error al rechazar la solicitud');
		}
		
		$this->redirect(array('vendedoras'));
	}

	/**
	 * Suspender una empresa previamente aprobada
	 */
	public function actionSuspender($id)
	{
		$model=$this->loadModel($id);
		$model->estado = 4;
		$rif = explode("-", $model->rif);
		$model->prefijo = $rif[0];
		$model->numero = $rif[1];
		if($model->save()){
			Yii::app()->user->setFlash('success', 'Empresa suspendida');
		}else{
			Yii::app()->user->setFlash('error', 'Error al suspender la empresa');
		}
		
		$this->redirect(array('vendedoras'));
	}
	

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
		
		Yii::app()->user->setFlash('success', 'Empresa correctamente eliminada.');
		
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Empresas');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	/**
	 * Lista las empresas vendedoras
	 */
	public function actionVendedoras()
	{
		$model = new Empresas;
		$model->unsetAttributes();  // clear any default values

		$model->tipo = 2;
		$dataProvider = $model->search();
		
		$this->render('vendedoras',array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));

	}

	/**
	 * Ver calificaciones para una empresa desde el panel de admin
	 */
	public function actionCalificaciones($id)
	{
		$model=$this->loadModel($id);
		$calificacion = new CalificacionEmpresa();
		$calificacion->empresas_id = $model->id;
		$dataProvider = $calificacion->search();

		$numero_calificaciones = CalificacionEmpresa::model()->countByAttributes(array('empresas_id'=>$model->id));
		$calificacion_total = 0;
		$calificacion_promedio = 0;
		$calificaciones = CalificacionEmpresa::model()->findAllByAttributes(array('empresas_id'=>$model->id));
		foreach ($calificaciones as $c) {
			$calificacion_total += $c->puntuacion;
		}
		if ($numero_calificaciones > 0) {
			$calificacion_promedio = $calificacion_total / $numero_calificaciones;
		}

		$this->render('calificaciones',array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
			'calificacion_promedio'=>$calificacion_promedio,
		));
	}

	/**
	 * Eliminar calificacion de una empresa desde el admin
	 */
	public function actionEliminarCalificacion($id){
		$calificacion = CalificacionEmpresa::model()->findByPk($id);
		$empresa_id = $calificacion->empresas_id;
		$calificacion->delete();
		Yii::app()->user->setFlash('success',"Calificacion eliminada");

		$this->redirect(array('empresas/calificaciones/'.$empresa_id));
	}

	/**
	 * Ver calificaciones para una empresa desde el panel de admin
	 */
	public function actionInventarios($id)
	{
		$model=$this->loadModel($id);
		$dataProvider = Inventario::model()->getInventariosEmpresa($id);

		$this->render('inventarios',array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Ver listado de órdenes para una empresa
	 */
	public function actionVentas($id)
	{
		$model=$this->loadModel($id);
		$dataProvider = Orden::model()->getEmpresaOrders($id);

		$this->render('ventas',array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Lista las empresas compradoras
	 */
	public function actionCompradoras()
	{
		$model = new Empresas;
		$model->unsetAttributes();  // clear any default values

		$model->tipo = 1;
		$dataProvider = $model->search();
		
		$this->render('compradoras',array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));

	}
	
	/**
	 * Lista las solicitudes de empresas
	 */
	public function actionSolicitudes()
	{
		$model = new Empresas;
		$model->unsetAttributes();  // clear any default values

		$model->estado = 1;
		$dataProvider = $model->search();
		
		$this->render('solicitudes',array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));

	}

	/**
	 * Obtiene los almacenes para una empresa seleccionada
	 */
	public function actionGetAlmacenes(){
		if(isset($_POST['empresa_id'])){
				
			$almacenes = Almacen::model()->findAllByAttributes(array('empresas_id'=>$_POST['empresa_id']), array('order'=>'id ASC'));
			//$ciudades = Ciudad::model()->findAllByAttributes(array('provincia_id'=>$_POST['provincia_id']), array('order'=>'nombre ASC'));
			$return = '<option value>Seleccione una sucursal...</option>';
			if(sizeof($almacenes) > 0){
				foreach ($almacenes as $almacen) {
					$return .= '<option value="'.$almacen->id.'">'.$almacen->alias.'</option>';
				}
			}
			echo $return;
		}
	}
	

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		
		$model = new Empresas;
		$model->unsetAttributes();  // clear any default values
		$bandera=false;
		$dataProvider = $model->search();

		/* Para mantener la paginacion en las busquedas */
		if(isset($_GET['ajax']) && isset($_SESSION['searchBox']) && !isset($_POST['query'])){
			$_POST['query'] = $_SESSION['searchBox'];
			$bandera=true;
		}

		/* Para buscar desde el campo de texto */
		if (isset($_POST['query'])){
			$bandera=true;
			unset($_SESSION['searchBox']);
			$_SESSION['searchBox'] = $_POST['query'];
            $query = $_POST['query'];
            echo $query;
            $dataProvider = $model->search($query);
        }	

        if($bandera==FALSE){
			unset($_SESSION['searchBox']);
        }

		if(isset($_GET['Empresas']))
			$model->attributes=$_GET['Empresas'];

		        /*********************** Para los filtros *********************/
             if((isset($_SESSION['todoPost']) && !isset($_GET['ajax'])))
            {
                unset($_SESSION['todoPost']);
            }
            //Filtros personalizados
            $filters = array();
            
            //Para guardar el filtro
            $filter = new Filter;            
            
            if(isset($_GET['ajax']) && !isset($_POST['dropdown_filter']) && isset($_SESSION['todoPost'])
               && !isset($_POST['nombre'])){
              $_POST = $_SESSION['todoPost'];
              
            }            
            
            if(isset($_POST['dropdown_filter'])){  
                                
                $_SESSION['todoPost'] = $_POST;           
                
                //Validar y tomar sólo los filtros válidos
                for($i=0; $i < count($_POST['dropdown_filter']); $i++){
                    if($_POST['dropdown_filter'][$i] && $_POST['dropdown_operator'][$i]
                            && trim($_POST['textfield_value'][$i]) != '' && $_POST['dropdown_relation'][$i]){

                        $filters['fields'][] = $_POST['dropdown_filter'][$i];
                        $filters['ops'][] = $_POST['dropdown_operator'][$i];
                        $filters['vals'][] = $_POST['textfield_value'][$i];
                        $filters['rels'][] = $_POST['dropdown_relation'][$i];                    

                    }
                }     
                //Respuesta ajax
                $response = array();
                
                if (isset($filters['fields'])) {      
                    
                    $dataProvider = $model->buscarPorFiltros($filters);                    
                    
                     //si va a guardar
                     if (isset($_POST['save'])){                        
                         
                         //si es nuevo
                         if (isset($_POST['name'])){
                            
                            $filter = Filter::model()->findByAttributes(
                                    array('name' => $_POST['name'], 'type' => '3') 
                                    ); 
                            if (!$filter) {
                                $filter = new Filter;
                                $filter->name = $_POST['name'];
                                $filter->type = 3;
                                
                                if ($filter->save()) {
                                    for ($i = 0; $i < count($filters['fields']); $i++) {

                                        $filterDetails[] = new FilterDetail();
                                        $filterDetails[$i]->id_filter = $filter->id_filter;
                                        $filterDetails[$i]->column = $filters['fields'][$i];
                                        $filterDetails[$i]->operator = $filters['ops'][$i];
                                        $filterDetails[$i]->value = $filters['vals'][$i];
                                        $filterDetails[$i]->relation = $filters['rels'][$i];
                                        $filterDetails[$i]->save();
                                    }
                                    
                                    $response['status'] = 'success';
                                    $response['message'] = 'Filtro <b>'.$filter->name.'</b> guardado con éxito';
                                    $response['idFilter'] = $filter->id_filter;                                    
                                    
                                }
                                
                            //si ya existe
                            } else {
                                $response['status'] = 'error';
                                $response['message'] = 'No se pudo guardar el filtro, el nombre <b>"'.
                                        $filter->name.'"</b> ya existe'; 
                            }

                          /* si esta guardadndo uno existente */
                         }else if(isset($_POST['id'])){
                            
                            $filter = Filter::model()->findByPk($_POST['id']); 

                            if ($filter) {
                                
                                //borrar los existentes
                                foreach ($filter->filterDetails as $detail){
                                    $detail->delete();
                                }
                                
                                for ($i = 0; $i < count($filters['fields']); $i++) {

                                    $filterDetails[] = new FilterDetail();
                                    $filterDetails[$i]->id_filter = $filter->id_filter;
                                    $filterDetails[$i]->column = $filters['fields'][$i];
                                    $filterDetails[$i]->operator = $filters['ops'][$i];
                                    $filterDetails[$i]->value = $filters['vals'][$i];
                                    $filterDetails[$i]->relation = $filters['rels'][$i];
                                    $filterDetails[$i]->save();
                                }

                                $response['status'] = 'success';
                                $response['message'] = 'Filtro <b>'.$filter->name.'</b> guardado con éxito';                                
                            //si NO existe el ID
                            } else {
                                $response['status'] = 'error';
                                $response['message'] = 'El filtro no existe'; 
                            }
                             
                         }
                        
                         echo CJSON::encode($response); 
                         Yii::app()->end();
                         
                     }//fin si esta guardando

                //si no hay filtros válidos    
                }else if (isset($_POST['save'])){
                    $response['status'] = 'error';
                    $response['message'] = 'No has seleccionado ningún criterio para filtrar'; 
                    echo CJSON::encode($response); 
                    Yii::app()->end();
                }
            }
            
            if (isset($_GET['nombre'])) {
               # echo $_GET['nombre'];
				#break;
				$palabras=explode( ' ',$_GET['nombre']);
                unset($_SESSION["todoPost"]);
                $criteria->alias = 'User';
				if (!isset($palabras[1]))
				{
					$criteria->join = 'JOIN tbl_profiles p ON User.id = p.user_id AND (p.first_name LIKE "%' . $_GET['nombre'] . '%" OR p.last_name LIKE "%' . $_GET['nombre'] . '%" OR User.email LIKE "%' . $_GET['nombre'] . '%")';
				}
				else {																					  
					$criteria->join = 'JOIN tbl_profiles p ON User.id = p.user_id AND ((p.first_name LIKE "%' . $palabras[0] . '%" AND p.last_name LIKE "%' . $palabras[1] . '%" ) OR
																 					   (p.first_name LIKE "%' . $palabras[1] . '%" AND p.last_name LIKE "%' . $palabras[0] . '%" ))';
					}
                
                
                $dataProvider = new CActiveDataProvider('User', array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => Yii::app()->getModule('user')->user_page_size,
                    ),
                ));
            }

            	Yii::app()->session['userCriteria']=$dataProvider->criteria;

		$this->render('admin',array(
			'model'=>$model,
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Empresas::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='empresas-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	    public function actionSelectdos()
        {
            $id_uno = $_POST['Empresas']['provincia'];
            #$lista = Ciudad::model()->findAll('provincia_id = :id_uno',array(':id_uno'=>$id_uno), array('order'=>'nombre asc'));
            $lista = Ciudad::model()->findAll('provincia_id = "'.$id_uno.'" order by nombre asc');
            $lista = CHtml::listData($lista,'id','nombre');
		
             
            echo CHtml::tag('option', array('value' => ''), 'Seleccione', true);
             
            foreach ($lista as $valor => $nombre)
            {
                echo CHtml::tag('option',array('value'=>$valor),CHtml::encode($nombre), true );
                 
            }
			echo $id_uno;
			Yii::app()->end();
             
        }

        public function actionVerEmpresa($id)
        {
        	$empresas=Empresas::model()->findByPk($id);
        	$provincia_id=Ciudad::model()->findByPk($empresas->ciudad)->provincia_id;
        	$this->render('verEmpresa',array(
			'empresas'=>$empresas,
			'provincia_id'=>$provincia_id,
			));

        }
}
