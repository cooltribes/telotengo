<?php

class MarcaController extends Controller
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
				'actions'=>array('index','view','store','filtrar'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','update'),
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
			$marca = new Marca;
		}else{
			$marca = Marca::model()->findByPk($id);
		}
		
		if(isset($_POST['Marca'])){
			$marca->attributes = $_POST['Marca'];
			//$marca->urlImagen = $_POST['Marca']['Urlimagen'];
		
			#echo($_POST['url']);
		
			if(!is_dir(Yii::getPathOfAlias('webroot').'/images/marca/'))
				{
	   				mkdir(Yii::getPathOfAlias('webroot').'/images/marca/',0777,true);
	 			}
			
			$rnd = rand(0,9999);  
			$images=CUploadedFile::getInstanceByName('url');
			
			#var_dump($images);
			#echo "<br>".count($images);
			if (isset($images) && count($images) > 0) {
				$marca->url_imagen = "{$rnd}-{$images}";
				
				$marca->save();

		        $nombre = Yii::getPathOfAlias('webroot').'/images/marca/'.$marca->id;
		        $extension_ori = ".jpg";
				$extension = '.'.$images->extensionName;

		       	if ($images->saveAs($nombre . $extension)) {
					
		       		$marca->url_imagen = $marca->id.$extension;
		            $marca->save();
									
					Yii::app()->user->setFlash('success',"Marca guardada exitosamente.");

					$nombre_thumbJ = $nombre.'_thumb.jpg';
					$nombre_thumbP = $nombre.'_thumb.png';
					
					if(file_exists($nombre_thumbJ)){
						unlink($nombre_thumbJ);
					}

					if(file_exists($nombre_thumbP)){
						unlink($nombre_thumbP);
					}

				#	echo $nombre.$extension;
				#	Yii::app()->end();

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
					echo "error";
					Yii::app()->end();
		        	$marca->delete();
				}
		        
			}else{
		    	if($marca->save()){
		        	Yii::app()->user->setFlash('success',"Marca guardada exitosamente.");
		        }else{
		        	Yii::app()->user->setFlash('error',"Marca no pudo ser guardada.");
		        }
			}// isset
			
		                $this->redirect(array('admin'));
		}

		$this->render('create',array('model'=>$marca));		
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

		if(isset($_POST['Marca']))
		{
			$model->attributes=$_POST['Marca'];
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
		
		Yii::app()->user->setFlash('success',"Marca eliminada correctamente.");
		
		$this->redirect(array('admin'));
		
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Marca');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$marca = new Marca; 
		$marca->unsetAttributes();
		$bandera=false;
		$dataProvider = $marca->search();

		/* Para mantener la paginacion en las busquedas */
		if(isset($_GET['ajax']) && isset($_SESSION['searchMarca']) && !isset($_POST['query'])){
			$_POST['query'] = $_SESSION['searchMarca'];
			$bandera=true;
		}

		/* Para buscar desde el campo de texto */
		if (isset($_POST['query'])){
			$bandera=true;
			unset($_SESSION['searchMarca']);
			$_SESSION['searchMarca'] = $_POST['query'];
            $marca->nombre = $_POST['query'];
            $dataProvider = $marca->search();
        }	

        if($bandera==FALSE){
			unset($_SESSION['searchMarca']);
        }
/*
		if (isset($_POST['query'])){
			$marca->nombre = $_POST['query'];
		}*/
		
		$this->render('admin',
			array('model'=>$marca,
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
		$model=Marca::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='marca-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	
	/**
	 * Para el Storefront.
	 */
	public function actionStore()
	{
		if(isset($_GET['alias'])){
			$marca = Marca::model()->findByAttributes(array('nombre'=>$_GET['alias']));
			Yii::app()->session['marca'] = $marca->id;
		}
		
		if(isset($_GET['ajax'])){
			$marca = Marca::model()->findByAttributes(array('id'=>Yii::app()->session['marca']));
		}
		
		$producto = new Producto;
		$producto->unsetAttributes();
		  
		$producto->estado = 1; 
		$producto->marca_id = Yii::app()->session['marca'];
		
		$dataProvider = $producto->searchTwo();
		$rangos = Inventario::model()->getLimitesMarca(Yii::app()->session['marca']);
		
 		$this->render('storefront',
			array('model'=>$marca,
			'dataProvider'=>$dataProvider,
			'rangos'=>$rangos,
		));	
		
	}	
	
	// Action para filtrar en storefront
	public function actionFiltrar()
	{
		$marca = Yii::app()->session['marca'];	
		$rangos = Inventario::model()->getLimitesMarca($marca); 

		$producto = new Producto;
		$producto->unsetAttributes();  
		$producto->estado = 1;
		$producto->marca_id = Yii::app()->session['marca'];
		
			if (isset($_POST['categoria']) && $_POST['categoria']!="todas"){ // categorias
				$producto->categoria_id = $_POST['categoria'];				
				Yii::app()->getSession()->add('categoria', $_POST['categoria']);
			}
			
			if (isset($_POST['precio'])) // filtro por rango de precios
			{	if($_POST['precio']<4){
					Yii::app()->session['max']=$rangos[$_POST['precio']]['max'];
					Yii::app()->session['min']=$rangos[$_POST['precio']]['min'];
					Yii::app()->session['p_index']=$_POST['precio'];
				}
				else{
					if(isset(Yii::app()->session['p_index'])){
						unset(Yii::app()->session['p_index']);
					}
				}				
					
			}
				
			if( isset($_GET['Producto_page']) )
			{
				if ( Yii::app()->getSession()->get('categoria') )
					$producto->categoria_id = Yii::app()->getSession()->get('categoria');
					
				if ( Yii::app()->getSession()->get('nombre') )
					$producto->nombre = Yii::app()->getSession()->get('nombre');
				
				$todos = array();
				$todos = $this->getAllChildren(Categoria::model()->findAllByAttributes(array("id_padre"=>$producto->categoria_id)));
				$categorias = Categoria::model()->findAllByAttributes(array("id_padre"=>$producto->categoria_id));	
				$dataProvider = $producto->busqueda($todos);
		
				$this->render('index',
				array('index'=>$producto,
				'dataProvider'=>$dataProvider,'categorias'=>$categorias,
				));	
			
			}

			$marcanueva = Marca::model()->findByPk($marca);

			$todos = array();
			$todos = $this->getAllChildren(Categoria::model()->findAllByAttributes(array("id_padre"=>$producto->categoria_id)));
			
			$dataProvider = $producto->busqueda($todos);

			$this->render('storefront',
				array(
				'dataProvider'=>$dataProvider,
				'model' => $marcanueva,
				'rangos'=>$rangos,
			));	
	}

	public function getAllChildren($models){
		$items = array();
		foreach($models as $model){
			if (isset($model->id)){
				$items[] = $model->id;
			 	if($model->hasChildren()){
                        $items= CMap::mergeArray($items,$this->getAllChildren($model->getChildren()));
                }
			}
		}
		return $items;
	}	
	
	
}
