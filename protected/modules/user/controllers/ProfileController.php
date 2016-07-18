<?php

class ProfileController extends Controller
{
	public $defaultAction = 'profile';
	public $layout='//layouts/column2';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','profile','welcome'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('edit','changepassword','editField'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}	


	/**
	 * Shows a particular model.
	 */
	public function actionProfile($id = null)
	{
		if($id){
			$model = User::model()->findByPk($id);
		}else{
			$model = User::model()->findByPk(Yii::app()->user->id);
		}
		if(isset($_POST['imagen']))
		{
			if(!is_dir(Yii::getPathOfAlias('webroot').'/images/user/'))
			{
	   			mkdir(Yii::getPathOfAlias('webroot').'/images/user/',0777,true);
	 		}	
			$rnd = rand(0,9999);  	
			$images=CUploadedFile::getInstanceByName('imagen');
			if (isset($images) && count($images) > 0) {
				$model->avatar_url = "{$rnd}-{$images}";
				$model->save();
				$nombre = Yii::getPathOfAlias('webroot').'/images/user/'.$model->id;
			    $extension_ori = ".jpg";
				$extension = '.'.$images->extensionName;
				if ($images->saveAs($nombre . $extension)) {
			
			       		$model->avatar_url = '/images/user/'.$model->id .$extension;
			            $model->save();
										
						Yii::app()->user->setFlash('success',"Avatar modificado exitosamente.");
	
						$image = Yii::app()->image->load($nombre.$extension);
						$image->resize(270, 270);
						$image->save($nombre.'_thumb'.$extension);					
					}
			/*	echo "s;kdfklsdf";
				Yii::app()->end();*/
			}
		}
		
	    $this->render('profile',array(
	    	'model'=>$model,
			'profile'=>$model->profile,
	    ));
	}

	/**
	 * Welcome screen after user registration
	 */
	public function actionWelcome()
	{
		$model = $this->loadUser();
	    $this->render('welcome',array(
	    	'model'=>$model,
			'profile'=>$model->profile,
	    ));
	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionEdit()
	{
		$model = $this->loadUser();
		$profile=$model->profile;
		
		// ajax validator
		if(isset($_POST['ajax']) && $_POST['ajax']==='profile-form')
		{
			echo UActiveForm::validate(array($model,$profile));
			Yii::app()->end();
		}
		
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$profile->attributes=$_POST['Profile'];
			
			if($model->validate()&&$profile->validate()) {
				$model->save();
				$profile->save();
				Yii::app()->user->setFlash("success", "Cambios actualizados.");

				if($profile->telefono!="" && $profile->sexo){
					$porcentaje = $profile->isAllPercentage();

	                if($porcentaje && ($model->perfil_completo==0)){
	                	$model->perfil_completo = 1;
	                	if($model->save()){
	                		# Sumar 500 bs al balance
	                		$balance = new Balance;
	                		$balance->total = 500;
	                		$balance->orden_id = 0;
	                		$balance->user_id = $model->id;
	                		$balance->tipo = 5;
	                		$balance->save();
	                		Yii::app()->user->setFlash('success', 'Cambios actualizados. Además hemos sumado 500 Bs a tu saldo.');
	               			$model->mailCompletarPerfil(); // correo por completar perfil
	               		}// save
	                }// porcentaje
				} // telefono y genero

                Yii::app()->user->updateSession();
				$this->redirect(array('/user/user/tucuenta'));
			} else $profile->validate();
		}

		$this->render('edit',array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}
	
	/**
	 * Change password
	 */
	public function actionChangepassword(){
		$model = new UserChangePassword;
		if (Yii::app()->user->id) {
			
			// ajax validator
			if(isset($_POST['ajax']) && $_POST['ajax']==='changepassword-form')
			{
				echo UActiveForm::validate($model);
				Yii::app()->end();
			}
			
			if(isset($_POST['UserChangePassword'])) {
					$model->attributes=$_POST['UserChangePassword'];
					if($model->validate()) {
						$new_password = User::model()->notsafe()->findbyPk(Yii::app()->user->id);
						$new_password->password = UserModule::encrypting($model->password);
						$new_password->activkey=UserModule::encrypting(microtime().$model->password);
						if ($new_password->save()) {
							Yii::app()->user->setFlash('success', 'Se ha cambiado correctamente la contraseña.');
							$this->redirect(array("user/tucuenta"));
						}else{
							print_r($new_password->getErrors());
							die();
						}
					}
			}
			$this->render('changepassword',array('model'=>$model));
	    }
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadUser()
	{
		if($this->_model===null)
		{
			if(Yii::app()->user->id)
				$this->_model=Yii::app()->controller->module->user();
			if($this->_model===null)
				$this->redirect(Yii::app()->controller->module->loginUrl);
		}
		return $this->_model;
	}
    
    public function actionIndex($_= null, $ide=NULL){
    	$entro=0;
    	if($ide==NULL)
		{
			$identificador=	Yii::app()->user->id;
			$model=User::model()->findByPk(Yii::app()->user->id);
			if(Yii::app()->user->isAdmin()) // si es el admin el que esta entrando
				$entro=1;
		}	
		else
		{
			if(Yii::app()->user->isAdmin())	// si es el admin si puede ver el perfil de otros usuarios, del resto vea solamente el de el
			{
				$model=User::model()->findByPk($ide);
				$identificador=	$ide;
				$way=1;
			}
					
			else
			{
				$model=User::model()->findByPk(Yii::app()->user->id);
				$identificador=	Yii::app()->user->id;
				$way=2;
			}
				
				
		}	
	    $avatar=false;
    	if(isset($_POST['imagen']))
		{     /*
		        $images=CUploadedFile::getInstanceByName('imagen');
                if (isset($images) && count($images) > 0) {
                    foreach ($images as $image => $pic) {
                        $nombre = Yii::getPathOfAlias('webroot').'/images/'.Yii::app()->language.'/avatar/'. $id .'/'. $image;
                        $extension = '.'.$pic->extensionName;
                        $model->avatar_url = $id .'/'. $image .$extension;
                        if (!$model->save())    
                            Yii::trace('username:'.$model->username.' Crear Avatar Error:'.print_r($model->getErrors(),true), 'registro');
                
                                if ($pic->saveAs($nombre ."_orig". $extension)) {
                                    //echo $nombre;
                                    $image = Yii::app()->image->load($nombre ."_orig". $extension);
                                    $avatar_x = isset($_POST['avatar_x'])?$_POST['avatar_x']:0;
                                    $avatar_x = $avatar_x*(-1);
                                    $avatar_y = isset($_POST['avatar_y'])?$_POST['avatar_y']:0;
                                    $avatar_y = $avatar_y*(-1);
                                    
                                    $proporcion = $image->__get('width')<$image->__get('height')?Image::WIDTH:Image::HEIGHT;
                                    $image->resize(270,270,$proporcion)->crop(270, 270,$avatar_y,$avatar_x);
                                    $image->save($nombre . $extension);
                                    
                                    $proporcion = $image->__get('width')<$image->__get('height')?Image::WIDTH:Image::HEIGHT;
                                    $image->resize(30,30,$proporcion)->crop(30, 30,$avatar_y,$avatar_x);
                                    $image->save($nombre . "_x30". $extension);
                                    
                                    $proporcion = $image->__get('width')<$image->__get('height')?Image::WIDTH:Image::HEIGHT;
                                    $image->resize(60,60,$proporcion)->crop(60, 60,$avatar_y,$avatar_x);
                                    $image->save($nombre . "_x60". $extension);
                                    
                                    Yii::app()->user->updateSession();
                                    Yii::app()->user->setFlash('success',UserModule::t("La imágen ha sido cargada exitosamente.")); 

                                    // reload page with no cache to show the new avatar
                                    header("Refresh: 0; URL=".$this->createUrl('avatar'));
                                }
                    }
                 }  
            */
            
			if(!is_dir(Yii::getPathOfAlias('webroot').'/images/user/'))
			{
	   			mkdir(Yii::getPathOfAlias('webroot').'/images/user/',0777,true);
	 		}	
			$rnd = rand(0,9999);  	
			$images=CUploadedFile::getInstanceByName('imagen');
			if (isset($images) && count($images) > 0) {
				$model->avatar_url = "{$rnd}-{$images}";
				$model->save();
				$nombre = Yii::getPathOfAlias('webroot').'/images/user/'.$model->id;
			    $extension_ori = ".jpg";
				$extension = '.'.$images->extensionName;
				if ($images->saveAs($nombre . $extension)) {
			
			       		$model->avatar_url = '/images/user/'.$model->id .$extension;
			            $model->save();
										
						Yii::app()->user->setFlash('success',"Avatar modificado exitosamente.");
	
						$image = Yii::app()->image->load($nombre.$extension);
						$image->resize(270, 270);
						$image->save($nombre.'_thumb'.$extension);
                        $avatar=true;
                        $log=new Log;
						$log->id_user=Yii::app()->user->id;
						$log->fecha=date('Y-m-d G:i:s');
						$log->accion=55;
						$log->save();				
					}
				/*echo "s;kdfklsdf";
				Yii::app()->end();*/
				header("Refresh: 0; URL=".$this->createUrl('index'));
			}
		}
		$totaAprobadaCompra="";
		$totaPendienteCompra="";
		$totaRechazadasCompra="";
		$totaPendienteVendidas="";
		$totaRechazadasVendidas="";
		$totaAprobadaVendidas="";
		$producComprados=0;
		$producInventario=0;
		if($entro==0)
		{
				
			$empresas_id=EmpresasHasUsers::model()->findByAttributes(array('users_id'=>$identificador))->empresas_id; // id del que esta intentado entrar
			
			$empresa=Empresas::model()->findByPk($empresas_id);
			$almacen=Almacen::model()->findAllByAttributes(array('empresas_id'=>$empresas_id));
			if(Yii::app()->authManager->checkAccess("comprador", $identificador) || Yii::app()->authManager->checkAccess("compraVenta", $identificador))
			{
				// ORDENES APROBADAS, PENDIENTES O RECHAZADAS POR EL COMPRADOR o COMPRAVENTA	
				$totaPendienteCompra=Orden::model()->countByAttributes(array('empresa_id'=>$empresas_id, 'estado'=>0)); //pendiente
				$totaRechazadasCompra=Orden::model()->countByAttributes(array('empresa_id'=>$empresas_id, 'estado'=>2)); //Rechazadas
				$totaAprobadaCompra=Orden::model()->countByAttributes(array('empresa_id'=>$empresas_id, 'estado'=>1)); //Aprobadas
				$sql="select sum(cantidad) as sumatoria from tbl_orden_has_inventario where orden_id in (select id from tbl_orden where empresa_id='".$empresas_id."' and estado=1)";
				$variable = Yii::app()->db->createCommand($sql)->queryRow();
				$producComprados=$variable['sumatoria'];
				
			}
			if(Yii::app()->authManager->checkAccess("vendedor", $identificador) || Yii::app()->authManager->checkAccess("compraVenta", $identificador))
			{
				// ORDENES APROBADAS, PENDIENTES O RECHAZADAS POR EL VENDEDOR o COMPRAVENTA
				
				$sql = "select count(*) as contador  from tbl_orden where  estado=0 and almacen_id in (select id from tbl_almacen where empresas_id=".$empresas_id.")";
				$pendiente = Yii::app()->db->createCommand($sql)->queryRow();
				$totaPendienteVendidas=$pendiente['contador'];
				
				$sql = "select count(*) as contador  from tbl_orden where  estado=2 and almacen_id in (select id from tbl_almacen where empresas_id=".$empresas_id.")";
				$rechazado = Yii::app()->db->createCommand($sql)->queryRow();
				$totaRechazadasVendidas=$rechazado['contador'];
						
				$sql = "select count(*) as contador  from tbl_orden where  estado=1 and almacen_id in (select id from tbl_almacen where empresas_id=".$empresas_id.")";
				$aprobado = Yii::app()->db->createCommand($sql)->queryRow();
				$totaAprobadaVendidas=$aprobado['contador'];	
				
				$sql="select sum(cantidad) as sumatoria from tbl_inventario where almacen_id in(select id from tbl_almacen where empresas_id='".$empresas_id."')";
				$variable = Yii::app()->db->createCommand($sql)->queryRow();
				$producInventario=$variable['sumatoria'];

				$sql="select count(distinct(producto_id)) as conta from tbl_inventario where almacen_id in(select id from tbl_almacen where empresas_id='".$empresas_id."')";
				$variable = Yii::app()->db->createCommand($sql)->queryRow();
				$totalProduc=$variable['conta'];
				
			}
			$ultimosLog=Log::model()->findAllByAttributes(array('id_user'=>$identificador), array('order'=>'fecha desc', 'limit'=>10));
	
	        $this->render('index',array(
		        'model'=>$model,
				'totaPendienteCompra'=>$totaPendienteCompra,
				'totaRechazadasCompra'=>$totaRechazadasCompra,
				'totaAprobadaCompra'=>$totaAprobadaCompra,
				'totaPendienteVendidas'=>$totaPendienteVendidas,
				'totaRechazadasVendidas'=>$totaRechazadasVendidas,
				'totaAprobadaVendidas'=>$totaAprobadaVendidas,
				'producComprados'=>$producComprados,
				'producInventario'=>$producInventario,
				'empresa'=>$empresa,
				'almacen'=>$almacen,
				'avatar'=>$avatar,
				'entro'=>$entro,
				'identificador'=>$identificador,
				'ultimosLog'=>$ultimosLog,
				'totalProduc'=>$totalProduc,
				
			
			));
		
		}
         else{
				$ultimosLog=Log::model()->findAllByAttributes(array('id_admin'=>Yii::app()->user->id), array('order'=>'fecha desc', 'limit'=>13));
                $this->render('index',array('ultimosLog'=>$ultimosLog,'model'=>$model , 'avatar'=>$avatar, 'entro'=>$entro, 'identificador'=>$identificador,));
            }
    }

public function actionEditField(){
     $data=array();
    if(isset($_POST['editMode']))
    {
       $save=false;
   
        $profile=Profile::model()->findByPk(Yii::app()->user->id);    
        if(isset ($_POST['first_name']))
            $profile->first_name=$_POST['first_name'];  
        if(isset ($_POST['last_name']))
            $profile->last_name=$_POST['last_name'];
        if(isset ($_POST['telefono']))
            $profile->telefono=$_POST['telefono'];
        if(isset ($_POST['first_name'])||isset ($_POST['last_name'])||isset ($_POST['telefono']))
            $save=$profile->save();
        if(!$save)
            $errors=$profile->errors;
        if(isset ($_POST['rol'])){
            $ehu=EmpresasHasUsers::model()->findByAttributes(array('users_id'=>Yii::app()->user->id));
            $ehu->rol=$_POST['rol'];
            $save=$ehu->save();
            $errors=$ehu->errors;
        }
        if(isset ($_POST['password'])){
            $user=User::model()->findByPk(Yii::app()->user->id);
            $identity=new UserIdentity($user->username,$_POST['password']);
            if($identity->authenticate()){
                if($_POST['new_password']==$_POST['new_password2']){
                    if(strlen($_POST['new_password'])>3&&strlen($_POST['new_password'])<128){
                        $user->password=Yii::app()->controller->module->encrypting($_POST['new_password']);
                        if($user->save()){   
                            $save=true;
                        }else{
                            $errors=$users->errors;
                        }
                    }else{
                        $errors=array('Nueva contraseña'=>array('Debe tener entre 4 y 128 caracteres'));
                    }
                    
                                  
                }else{
                     $errors=array('Nueva contraseña'=>array('Los campos de nueva contraseña no coinciden'));
                }
            }else{
                $errors=array('identificación'=>array('Contrasena incorrecta'));
            }
        } 

        if($save){
          	$log=new Log;
			$log->fecha=date('Y-m-d G:i:s');
			$log->id_user=Yii::app()->user->id;
			$log->fecha=date('Y-m-d G:i:s');
			switch ($_POST['opcion'])
        	{
	       		case 1:
	            	$log->accion=51;
	            	break;
	           	case 2:
	            	$log->accion=52;
	            	break;
	            case 4:
	            	$log->accion=53;
	            	break;
	            case 6:
	            	$log->accion=54;
	            	break;
        	}
        	$log->save();
         	$data['status']="ok";
          	echo json_encode($data);
        }else{

            $data['error']="";
             foreach($errors as $key=>$error){ 
                 $data['error'].=ucwords($key).": ".implode(', ',$error);      
         
             }  
            echo json_encode($data);
        }
    } else{
        
       $data['status']="ok";
        $data['content']=$this->renderPartial('editField',array( 'fname'=>$_POST['fname'], 'field'=>$_POST['field'], 'profile'=>Profile::model()->findByPk(Yii::app()->user->id),'rol'=>EmpresasHasUsers::model()->findByAttributes(array('users_id'=>Yii::app()->user->id))),true);   
        echo json_encode($data);
    }
       
    
}
}