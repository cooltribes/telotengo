<?php

class AdminController extends Controller
{
	public $defaultAction = 'admin';
	public $layout='//layouts/column2';
	
	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return CMap::mergeArray(parent::filters(),array(
			'accessControl', // perform access control for CRUD operations
		));
	}
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','addSaldo','delete','create','update','view','cargarSaldo','reclamos','eliminarReclamo','adminInvite',
								'eliminarComentario','cargaSaldo', 'solicitudes', 'detalle'),
				'users'=>UserModule::getAdmins(),
			),
			array('allow', 
				'actions'=>array('invitarUsuario', 'validarEmail'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new User();
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
            $model->email = $_POST["query"];
            $model->username = $_POST["query"];
            $dataProvider = $model->search();
        }	

        if($bandera==FALSE){
			unset($_SESSION['searchBox']);
        }

        if(isset($_GET['User']))
            $model->attributes=$_GET['User'];

        $this->render('index',array(
            'model'=>$model,
            'dataProvider' => $dataProvider,
        ));
	}

	/**
	 * Cargar saldo a un usario
	 */
	public function actionCargarSaldo($id)
	{
		$balance = new Balance();
		$usuario = User::model()->findByPk($id);

		if(isset($_POST['Balance'])){
			$balance->attributes=$_POST['Balance'];
			$balance->orden_id = 0; // carga de saldo desde admin, no tiene orden_id
			$balance->user_id = $id;
			$balance->tipo = 3; // carga desde el admin
			if($balance->save()){
				Yii::app()->user->setFlash('success',"Saldo cargado");
				$this->redirect(array('admin'));
			}
		}

		$this->render('cargar_saldo',array(
			'balance'=>$balance,
			'usuario'=>$usuario,
		));
	}

	/**
	 * Admin de reclamos
	 */
	public function actionReclamos()
	{
		$model=new Reclamo;
		$model->unsetAttributes();  // clear any default values
		
		$dataProvider = $model->search();

		$this->render('reclamos',array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Eliminar reclamo
	 */
	public function actionEliminarReclamo($id)
	{
		$model = Reclamo::model()->findByPk($id);
		$model->delete();
		Yii::app()->user->setFlash('success',"Reclamo eliminado");
		$this->redirect(array('reclamos'));
	}

	/**
	 * Eliminar comentario para un reclamo
	 */
	public function actionEliminarComentario($id)
	{
		$model = ReclamoComentarios::model()->findByPk($id);
		$model->delete();
		Yii::app()->user->setFlash('success',"Comentario eliminado");
		$this->redirect(array('reclamos'));
	}


	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$model = $this->loadModel();
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id = null)
	{
		$model=new User;
		$profile=new Profile;
		$fecha='';
		if($id){
			$model = User::model()->findByPk($id);
			$profile = $model->profile;
		}
		$first_time=$model->registro_password;	//para que el llenado del password se envie una sola vez
		
		$this->performAjaxValidation(array($model,$profile));
		if(isset($_POST['User']))
		{
			
			$model->attributes=$_POST['User'];
			/*if($model->status==1 && $first_time==0)
			{
				$model->newPassword($model->id);
				$model->registro_password=1;
				
			}*/
			
			$fecha=$_POST['User']['fecha'];
			$model->activkey=Yii::app()->controller->module->encrypting(microtime().$model->password);
			$profile->attributes=$_POST['Profile'];
			$profile->user_id=0;
			if($model->validate()&&$profile->validate()) {
				$model->password=Yii::app()->controller->module->encrypting($model->password);
				if($model->save()) {
					$profile->user_id=$model->id;
					if($fecha!='')
					{
						$fecha = date("Y-m-d", strtotime($fecha));
						echo $fecha;
						$profile->fecha_nacimiento=$fecha;
						
					}
						
					$profile->save();
					Yii::app()->user->setFlash('success',"Usuario guardado");
				}
				$this->redirect(array('admin'));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}


	/**
	 * Genera un invitación a un nuevo usuario
	 */
	public function actionInvitarUsuario()
	{
		$model = new User;
		$profile = new Profile;

		$this->performAjaxValidation(array($model));
		
		if(isset($_POST['User']))
		{
			
			$model->attributes=$_POST['User'];
			$model->type=$_POST['User']['type'];	
			$model->status = 1; #Activo
			$model->username = $_POST['User']['email']; #Mismo Mail
			$model->email = $_POST['User']['email']; #Mismo Mail
			$model->password = User::generarPassword();
			$model->quien_invita = Yii::app()->user->id;
			$model->activkey=Yii::app()->controller->module->encrypting(microtime().$model->password);
			
			$profile->first_name = "Usuario";
			$profile->last_name = "Invitado";
			$profile->cedula = "10111222";
			$profile->fecha_nacimiento = "1980-01-01";
			$profile->user_id=0;
			$profile->sexo = 2; # hombre

			#enviar mail

			if($model->validate()&&$profile->validate()) {
				$model->password=Yii::app()->controller->module->encrypting($model->password);
				if($model->save()) {
					$model->refresh();
					$profile->user_id=$model->id;
					$profile->save();
					
					#opcion de que sea invitado por admin para ser parte de empresa
					if($model->type == 2)
					{
						$cargo = $_POST['cargo'];
						$empresa_id = $_POST['empresas'];
						#agregar a empresa tiene usuarios
						$nuevo = new EmpresasHasUsers;
						$nuevo->empresas_id = $empresa_id;
						$empre=Empresas::model()->findByPk($empresa_id);
						Yii::app()->authManager->assign($empre->rol,$model->id);
						$nuevo->users_id = $model->id;
						$nuevo->rol = $cargo;
						$nuevo->save();
						$model->emailEmpresaInvitado($empresa_id, $cargo, $model->id, Yii::app()->user->id);
					}
					
					if($model->type == 3) // invitar como cliente
					{
						/*if(!Yii::app()->user->isAdmin())
						{
							$model->pendiente=1;
							$model->save();
						}*/	
						$model->emailClienteInvitado($model->id, Yii::app()->user->id);
					}

					Yii::app()->user->setFlash('success',"Usuario invitado correctamente");
				}
				if(Yii::app()->user->isAdmin())
					$this->redirect(array('admin'));
				else 
					$this->redirect(Yii::app()->createUrl('user/profile/index'));
				
			}
		}

		$this->render('invitar',array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		$model=$this->loadModel();
		$profile=$model->profile;
		$this->performAjaxValidation(array($model,$profile));
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$profile->attributes=$_POST['Profile'];
			
			if($model->validate()&&$profile->validate()) {
				$old_password = User::model()->notsafe()->findByPk($model->id);
				if ($old_password->password!=$model->password) {
					$model->password=Yii::app()->controller->module->encrypting($model->password);
					$model->activkey=Yii::app()->controller->module->encrypting(microtime().$model->password);
				}
				$model->save();
				$profile->save();
				$this->redirect(array('view','id'=>$model->id));
			} else $profile->validate();
		}

		$this->render('update',array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}


	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete($id)
	{
		//if(Yii::app()->request->isPostRequest)
		//{
			// we only allow deletion via POST request
		$model = User::model()->findByPk($id);
		$profile = Profile::model()->findByPk($model->id);
		$profile->delete();
		$model->delete();
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		//if(!isset($_POST['ajax']))
		Yii::app()->user->setFlash('success',"Usuario eliminado");
		$this->redirect(array('/user/admin'));
		//}
		//else
		//	throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	/**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($validate)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
        {
            echo CActiveForm::validate($validate);
            Yii::app()->end();
        }
    }
	
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=User::model()->notsafe()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}

    public function actionCargaSaldo(){
        if(isset($_POST['id'])&&!isset($_POST['cant']))
            {   $id=$_POST['id'];
                
                $saldo=Balance::model()->getSaldo($_POST['id']);             
                $html='<div class="modal-header no_border no_padding_bottom row-fluid">';
                 $html=$html.'<h3 class="no_margin_top col-md-11">Cargar Saldo<small class="pull-right margin_top_xsmall">Saldo Actual: '.Yii::app()->numberFormatter->formatDecimal($saldo).' Bs</small></h3>';
                $html=$html.'<div class="col-md-1"><button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">&times;</button></div>';
                $html=$html.'</div><hr class="no_margin_top"/>';
                
                $html=$html.'<div class="modal-body  padding_small> row-fluid">';
                $html=$html."<div class='col-md-8 col-md-offset-2'>";
                $html=$html. CHtml::TextField('cant','',array('id'=>'cant','class'=>'form-control ','placeholder'=>'Escribe la cantidad separando los decimales con coma (,)')).
                "</div><div class='col-md-8 col-md-offset-2 margin_top_small'><a onclick='saldo(".$_POST['id'].")' class='btn btn-danger form-control'>Cargar Cantidad</a></div></div>";

                echo $html;
            }
    }

    public function actionAddSaldo()
    {
        $balance = new Balance();
        $usuario = User::model()->findByPk($_POST['id']);
        $response=array();
        if(isset($_POST['cant'])){
            $balance->total=$_POST['cant'];
            $balance->orden_id = 0; // carga de saldo desde admin, no tiene orden_id
            $balance->user_id = $_POST['id'];
            $balance->tipo = 3; // carga desde el admin
            if($balance->save()){
                Yii::app()->user->setFlash('success',"Saldo cargado"); 
                $reponse['status']="success";              
            }else{
                Yii::app()->user->setFlash('error',"Saldo no cargado");
                $reponse['status']="error"; 
            }
        }
        echo json_encode($response);

       
    }

    public function actionDetalle($id)
    {
    	if($id)
    	{
			$model = User::model()->findByPk($id);
			$profile = $model->profile;
			$empresas=Empresas::model()->findByPk((EmpresasHasUsers::model()->findByAttributes(array('users_id'=>$model->id))->empresas_id));
			$provincia=Ciudad::model()->findByPk($empresas->ciudad)->provincia_id;
			$this->render('detalle',array(
			'model'=>$model,
			'profile'=>$profile,
			'empresas'=>$empresas,
			'provincia'=>$provincia,
			));
		}

    }

	public function actionSolicitudes()
	{
		$model = new User();
		$model->unsetAttributes();  // clear any default values
        $bandera=false;
		$dataProvider = $model->buscarDesactivo();

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
            //$model->email = $_POST["query"];
            $dataProvider = $model->buscarDesactivo($_POST["query"]);
        }	

        if($bandera==FALSE){
			unset($_SESSION['searchBox']);
        }

        if(isset($_GET['User']))
            $model->attributes=$_GET['User'];

        $this->render('solicitudes',array(
            'model'=>$model,
            'dataProvider' => $dataProvider,
        ));
	}
	
    public function actionAdminInvite()
    {
        $model = new User();
        $model->unsetAttributes();  // clear any default values
        $bandera=false;
        $dataProvider = $model->invitedUsers;
        
                /* Para mantener la paginacion en las busquedas */
        if(isset($_GET['ajax']) && isset($_SESSION['searchInvite']) && !isset($_POST['query'])){
            $_POST['query'] = $_SESSION['searchInvite'];
            $bandera=true;
        }

        /* Para buscar desde el campo de texto */
        if (isset($_POST['query'])){
            $bandera=true;
            unset($_SESSION['searchInvite']);
            $_SESSION['searchInvite'] = $_POST['query'];
            $dataProvider = $model->searchInvited($_POST['query']);
            
        }   

        if($bandera==FALSE){
            unset($_SESSION['searchInvite']);
        }
            
        $this->render('adminInvite',array(
            'model'=>$model,
            'dataProvider'=>$dataProvider,
        ));
    }

	public function actionValidarEmail()
	{
		$email=$_POST['email'];
		if(User::model()->findByAttributes(array('email'=>$email)))
		{
			echo "0";
		}
		else
		{
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
   				 echo "1";
			}
			else {
				echo "2";
			}
		}
	}
    
    
}