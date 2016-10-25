<?php

class ProductoPadreController extends Controller
{
	
	
	//public $nombreCategoria;
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
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete', 'busqueda', 'cambiarStatus', 'autocomplete', 'activarDesactivar', 'create', 'update'),
				'users'=>array('admin'),
			),
			array('allow', // COMPRADORESVENDEDORES Y VENDEDORES
				'actions'=>array('busqueda' , 'autocomplete'),
				#'users'=>array('admin'),
				'roles'=>array('vendedor', 'compraVenta'),
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
		$model=new ProductoPadre;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ProductoPadre']))
		{
			$model->attributes=$_POST['ProductoPadre'];
			if($model->save())
			{
			     $model->refresh();
			    # $this->redirect(array('view','id'=>$model->id));
			}
				
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

		if(isset($_POST['ProductoPadre']))
		{
			$model->attributes=$_POST['ProductoPadre'];
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

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('ProductoPadre');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	
	public function actionAdmin()
	{
		$model = new ProductoPadre; 
		$model->unsetAttributes();
		$bandera=false;
		$dataProvider = $model->search();

		/* Para mantener la paginacion en las busquedas */
		if(isset($_GET['ajax']) && isset($_SESSION['searchProductoPadre']) && !isset($_POST['query'])){
			$_POST['query'] = $_SESSION['searchProductoPadre'];
			$bandera=true;
		}

		/* Para buscar desde el campo de texto */
		if (isset($_POST['query'])){
			$bandera=true;
			unset($_SESSION['searchProductoPadre']);
			$_SESSION['searchProductoPadre'] = $_POST['query'];
            $model->nombre = $_POST['query'];
            $dataProvider = $model->search();
        }	

        if($bandera==FALSE){
			unset($_SESSION['searchProductoPadre']);
        }

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

		
		$this->render('admin',
			array('model'=>$model,
			'dataProvider'=>$dataProvider,
		));	
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ProductoPadre the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ProductoPadre::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ProductoPadre $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='producto-padre-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionBusqueda()
	{
		$padre_id="";
        $nombre=$_POST['nombre'];
        $idAct=$_POST['idAct'];
        $marca=$_POST['marca'];
        $categoria=$_POST['categoria'];
        $activo=$_POST['activo'];
        $result=array();
        $busqueda=ProductoPadre::model()->findByAttributes(array('nombre'=>$nombre));
        if($busqueda=="")
        {
            
            if($idAct=="")
                $guardar=1;
            else
                $guardar=2;
        }
        else 
        {
            if($busqueda->id==$idAct)
            {
                
                $guardar=2;
            }   
            else
            {
                $result['status']=0;
                $guardar=0; 
            }
                        
        }
        if($guardar==1)
        {
            $productoPadre = new ProductoPadre; 
            $productoPadre->nombre=$nombre;
            $productoPadre->id_marca=$marca;
            $productoPadre->id_categoria=$categoria;
            $productoPadre->activo=$activo;
            if($productoPadre->save())
            {
            	$padre_id=$productoPadre->id;
                if(isset($_GET['son']))
                {
                    $son=Producto::model()->findbyPk($_GET['son']);
                    if($son){
                        $son->padre_id=$productoPadre->id;
                        $son->save();
                        Yii::app()->user->setFlash('success',"Producto Padre asignado correctamente, ya puede verificar la información de la variación");
                        $result['status']="2";
                        $result['masterData']=$son->masterdata_id;                        
                    }                    
                }
            }else{
                $result['status']="1";
                 $result['id']=$productoPadre->id;
            }
            
            
        }
        if($guardar==2)
        {
            $model=ProductoPadre::model()->findByPk($idAct);
            $model->nombre=$nombre;
            $model->id_marca=$marca;
            $model->id_categoria=$categoria;
            $model->activo=$activo;
            $model->save();
            $model->refresh();
            $padre_id=$model->id;
            $result['status']="1";
            $result['id']=$model->id;
        }
		if(Yii::app()->user->isAdmin())
	     {
	     	 if($guardar==1)
	     	 {
	     	 	$log=new Log;
				$log->id_producto_padre=$padre_id;
				$log->fecha=date('Y-m-d G:i:s');
				$log->id_admin=Yii::app()->user->id;
				$log->accion=22; //creo un nuevo producto padre
				$log->save();	
	     	 }
	     	 else
	     	 {
	     	 	$log=new Log;
				$log->id_producto_padre=$padre_id;
				$log->fecha=date('Y-m-d G:i:s');
				$log->id_admin=Yii::app()->user->id;
				$log->accion=27; //has modificado un producto padre
				$log->save();
	     	 }
	     	 
	     }
		echo json_encode($result);
                
		
	
	}
	
	public function actionCambiarStatus()
	{
		$idAct=$_POST['id'];
		$status=$_POST['status'];
		$model=ProductoPadre::model()->findByPk($idAct);
		$model->activo=$status;
		$model->save();
	}
	
	public function actionAutocomplete()
	{
	    	$res =array();
	    	if (isset($_GET['term'])) 
			{
				$qtxt ="SELECT nombre FROM tbl_producto_padre WHERE nombre LIKE :nombre and activo=1";
				$command =Yii::app()->db->createCommand($qtxt);
				$command->bindValue(":nombre", '%'.$_GET['term'].'%', PDO::PARAM_STR);
				$res =$command->queryColumn();
	    	}
	     	echo CJSON::encode($res);
	    	Yii::app()->end();
	}
	
	public function actionActivarDesactivar()
	{
		$id=$_POST['id'];
		$model = ProductoPadre::model()->findByPk($id);
		$model->activo=1-$model->activo;
		$model->save();
		echo $model->activo;
		
	}
   

}
