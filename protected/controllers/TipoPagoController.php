<?php

class TipoPagoController extends Controller
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
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
	public function actionCreate($id = null)
	{
		if(!$id){
			$tipo = new TipoPago;
		}else{
			$tipo = TipoPago::model()->findByPk($id);
		}
		
		if(isset($_POST['TipoPago'])){
			$tipo->attributes = $_POST['TipoPago'];
			//$marca->urlImagen = $_POST['Marca']['Urlimagen'];
		
			echo($_POST['url']);
		
			if(!is_dir(Yii::getPathOfAlias('webroot').'/images/tipopago/'))
				{
	   				mkdir(Yii::getPathOfAlias('webroot').'/images/tipopago/',0777,true);
	 			}
			
			$rnd = rand(0,9999);  
			$images=CUploadedFile::getInstanceByName('url');
			
			var_dump($images);
			echo "<br>".count($images);
			if (isset($images) && count($images) > 0) {
				$tipo->imagen_url = "{$rnd}-{$images}";
				
				$tipo->save();
		        
		        $nombre = Yii::getPathOfAlias('webroot').'/images/tipopago/'.$tipo->id;
		        $extension_ori = ".jpg";
				$extension = '.'.$images->extensionName;
		       
		       	if ($images->saveAs($nombre . $extension)) {
		
		       		$tipo->imagen_url = $tipo->id .$extension;
		            $tipo->save();
									
					Yii::app()->user->setFlash('success',"Tipo de pago agregado exitosamente.");

					$image = Yii::app()->image->load($nombre.$extension);
					$image->resize(150, 150);
					$image->save($nombre.'_thumb'.$extension);
					
					if($extension == '.png'){
						$image = Yii::app()->image->load($nombre.$extension);
						$image->resize(150, 150);
						$image->save($nombre.'_thumb.jpg');
					}	
					
				}
				else {
		        	$tipo->delete();
				}
		        
			}else{
		    	if($tipo->save()){
		        	Yii::app()->user->setFlash('success',"Tipo de pago agregado exitosamente.");
		        }else{
		        	Yii::app()->user->setFlash('error',"Tipo de pago no pudo ser agregado.");
		        }
			}// isset
			
		         $this->redirect(array('admin'));
		}
		
		
		$this->render('create',array('model'=>$tipo));
		
		/*
		
		$model=new TipoPago;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TipoPago']))
		{
			$model->attributes=$_POST['TipoPago'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
		 * */
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

		if(isset($_POST['TipoPago']))
		{
			$model->attributes=$_POST['TipoPago'];
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
		
		Yii::app()->user->setFlash('success',"Tipo de pago eliminado correctamente.");
		
		$this->redirect(array('admin'));
		
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('TipoPago');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		
		$tipo = new TipoPago; 
		$tipo->unsetAttributes();
		
		if (isset($_POST['query'])){
			$tipo->nombre = $_POST['query'];
		}
		
		$dataProvider = $tipo->search();
		
		$this->render('admin',
			array('model'=>$tipo,
			'dataProvider'=>$dataProvider,
		));	
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=TipoPago::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='tipo-pago-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
