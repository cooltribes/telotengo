<?php

class CategoriaController extends Controller
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
				'actions'=>array('index','view','store','substore'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(''),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','update','upload','listimages'),
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
			$categoria = new Categoria;
		}else{
			$categoria = Categoria::model()->findByPk($id);
		}
		
		if(isset($_POST['Categoria'])){
			$categoria->attributes = $_POST['Categoria'];
			$categoria->destacado = $_POST['Categoria']['destacado'];
			$categoria->descripcion= $_POST['Categoria']['descripcion'];
			
			if($_POST['Categoria']['id_padre'] != "") // significa que depende
				$categoria->id_padre = $_POST['Categoria']['id_padre'];
			else
				$categoria->id_padre = 0;
			
			
			
			echo($_POST['url']);
		
			if(!is_dir(Yii::getPathOfAlias('webroot').'/images/categoria/'))
				{
	   				mkdir(Yii::getPathOfAlias('webroot').'/images/categoria/',0777,true);
	 			}
			
			$rnd = rand(0,9999);  
			$images=CUploadedFile::getInstanceByName('url');
			
			var_dump($images);
			echo "<br>".count($images);
			if (isset($images) && count($images) > 0) {
				$categoria->imagen_url = "{$rnd}-{$images}";
				
				$categoria->save();
		        
		        $nombre = Yii::getPathOfAlias('webroot').'/images/categoria/'.$images->name;
		        $extension_ori = ".jpg";
				$extension = '.'.$images->extensionName;
		       
		       	if ($images->saveAs($nombre)) {
		
		       		$categoria->imagen_url = $images->name;
		            $categoria->save();
									
					Yii::app()->user->setFlash('success',"Categoria guardada exitosamente.");

					$image = Yii::app()->image->load($nombre);
					$image->resize(150, 150);
					$image->save(str_replace(".png","",$nombre).'_thumb'.$extension);
					
					if($extension == '.png'){
						$image = Yii::app()->image->load($nombre);
						$image->resize(150, 150);
						$image->save(str_replace(".png","",$nombre).'_thumb.jpg');
					}	
					
				}
				else {
		        	$categoria->delete();
				}
		        
			}else{
		    	if($categoria->save()){
		        	Yii::app()->user->setFlash('success',"Categoria guardada exitosamente.");
		        }else{
		        	Yii::app()->user->setFlash('error',"Categoria no pudo ser guardada.");
		        }
			}// isset
			
		    	$this->redirect(array('admin'));
		}
		
		$this->render('create',array('model'=>$categoria));
		
		/*
		$model=new Categoria;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Categoria']))
		{
			$model->attributes=$_POST['Categoria'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
		*/
		
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

		if(isset($_POST['Categoria']))
		{
			$model->attributes=$_POST['Categoria'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	
	// imagenes de la extension html editor
	public function actionUpload()
	{
	   //   $image = new Image;
	    //  $image->file=CUploadedFile::getInstanceByName('file');
		  
		  	if(!is_dir(Yii::getPathOfAlias('webroot').'/images/editor/')){
	   			mkdir(Yii::getPathOfAlias('webroot').'/images/editor/',0777,true);
			}
		  
			$images=CUploadedFile::getInstanceByName('file');
			
			if (isset($images) && count($images) > 0) {
		        
				$hora = date("Y-m-d H:i:s");
		        $nombre = $nombre = Yii::getPathOfAlias('webroot').'/images/editor/'.$hora;		        
				$extension = ".jpg";
				   
		       	if ($images->saveAs($nombre . $extension)) {
		       		
					/*$image = Yii::app()->image->load($nombre.$extension);
					$image->resize(120, 120);				
					$image->save($nombre.'_thumb'.$extension);*/
						
		       		echo CHtml::image(Yii::app()->baseUrl.'/images/editor/'.$hora.$extension);
					//echo "sirvio, falta mostar";
              		Yii::app()->end();
				}
		        
			}
	}
	
	// listar las imagenes de la extension html editor
	public function actionListimages()
	{
		$images = array();
 
	    $handler = opendir(Yii::getPathOfAlias('webroot').'/images/editor/');
	 
	    while ($file = readdir($handler))
	    {
	        if ($file != "." && $file != "..")
				$images[] = $file;
					
	            
	    }
	    closedir($handler);
	 
	    $jsonArray=array();
	 
	    foreach($images as $image)
	        $jsonArray[]=array(
	            'thumb'=>Yii::app()->baseUrl.'/images/editor/'.$image,
	            'image'=>Yii::app()->baseUrl.'/images/editor/'.$image
	        );
	 
	    header('Content-type: application/json');
	    echo CJSON::encode($jsonArray);
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
		
		Yii::app()->user->setFlash('success',"Categoria eliminada correctamente.");
		
		$this->redirect(array('admin'));
		
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Categoria');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new Categoria;
		$model->unsetAttributes();
		$bandera=false;
		$dataProvider = $model->search();

		/* Para mantener la paginacion en las busquedas */
		if(isset($_GET['ajax']) && isset($_SESSION['searchCate']) && !isset($_POST['query'])){
			$_POST['query'] = $_SESSION['searchCate'];
			$bandera=true;
		}

		/* Para buscar desde el campo de texto */
		if (isset($_POST['query'])){
			$bandera=true;
			unset($_SESSION['searchCate']);
			$_SESSION['searchCate'] = $_POST['query'];
            $model->nombre = $_POST['query'];
            $dataProvider = $model->search();
        }	

        if($bandera==FALSE){
			unset($_SESSION['searchCate']);
        }

		if(isset($_POST['query'])){
			$model->nombre = $_POST['query'];
		}
		
		$this->render('admin',
			array('model'=>$model,
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
		$model=Categoria::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='categoria-form')
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
			$categoria = Categoria::model()->findByAttributes(array('url_amigable'=>$_GET['alias']));
			Yii::app()->session['categoria'] = $categoria->id;
			$id_padre = $categoria->id_padre;
		}
		
		if(isset($_GET['ajax'])){
			$categoria = Categoria::model()->findByAttributes(array('id'=>Yii::app()->session['categoria']));
		}
		
		
		$sql='select b.id from tbl_categoria_has_tbl_producto a, tbl_producto b where a.categoria_id = '.Yii::app()->session['categoria'].' and b.id = a.producto_id';
		
		$dataProvider=new CSqlDataProvider($sql, array(
		    'sort'=>array(
		        'attributes'=>array(
		             'id',
		        ),
		    ),
		));

		if($id_padre != 0){ // es subcategoria
			$this->render('storefront',
				array(
					'model'=>$categoria,
					'dataProvider'=>$dataProvider,
				)
			);	
		}
		else{ // categoria principal
			$this->render('subcategorias',
				array(
					'model'=>$categoria,
					'dataProvider'=>$dataProvider,
					'categoria' => $categoria,
					'rangos' => Inventario::model()->getLimitesCategoria($categoria->id)
				)
			);	
		}
	}
     public function actionSubstore(){
            
        if(isset($_POST['marca'])){
            if($_POST['marca']>0){
                 Yii::app()->session['catMarca']=$_POST['marca'];
                if(isset(Yii::app()->session['catMax'])) unset(Yii::app()->session['catMax']);
                if(isset(Yii::app()->session['catMin'])) unset(Yii::app()->session['catMin']);
            }
        }
           
        
        if(isset($_POST['min'])&&isset($_POST['max'])){
             Yii::app()->session['catMax']=$_POST['max'];
              Yii::app()->session['catMin']=$_POST['min'];
               if(isset(Yii::app()->session['catMarca'])) unset(Yii::app()->session['catMarca']);
        }
         if(isset( Yii::app()->session['catMarca']))
            $condition=" AND pr.marca_id = ".  Yii::app()->session['catMarca']." "; 
        if(isset( Yii::app()->session['catMax'])&&isset( Yii::app()->session['catMin']))
            $condition=" AND p.precio >".  Yii::app()->session['catMin']." AND p.precio <".  Yii::app()->session['catMax']." ";  
           
        $ids=Yii::app()->session['categoria'];
        
        $categoria=Categoria::model()->findByPk($ids);
        if($categoria->id_padre>0)
            $ids.=','.$categoria->id_padre;     
        $sql='select pr.id from tbl_inventario p JOIN tbl_producto pr ON pr.id=p.producto_id JOIN tbl_marca m ON pr.marca_id=m.id 
        JOIN tbl_categoria_has_tbl_producto c ON c.producto_id=pr.id 
        where c.categoria_id IN ('.$ids.') '.$condition;   
        //$sql='select b.id from tbl_categoria_has_tbl_producto a, tbl_producto b  where a.categoria_id = '.Yii::app()->session['categoria'].' and b.id = a.producto_id';
        $data=array();
        $dataProvider=new CSqlDataProvider($sql, array(
            'sort'=>array(
                'attributes'=>array(
                     'id',
                ),
            ),
        ));
        $data['status']="ok";
        $data['render']=$this->renderPartial('substore',array(
            'dataProvider'=>$dataProvider, 'categoria'=>$categoria->nombre
        ),true);
        
        echo json_encode($data);
    }	
	
	
}
