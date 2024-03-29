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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view','store','substore'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','update','upload','listimages', 'menu', 'categoriaRelacionada', 'catRela', 'crearAvanzar', 'categoriaAtributo', 'catAtrib','categoriaSeo', 'activarDesactivar','storefrontConf','formConfImage','setSeoAll', 'activarDesactivarCategoria'),
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
	 
	 public function actionMenu($id,$opcion)
	 {
	 	$this->render('menu',array(
			'model'=>$id,'opcion'=>$opcion
		));
	 }
	 
	 public function actionCategoriaRelacionada() ///falta avanzar
	{
		if(isset($_GET['id'])){
			$id = $_GET['id'];			
			$model = Categoria::model()->findByPk($id);
			/// Categoria Atributo deberia ir aqui
		}
		else {
			$model = new Categoria;
		} 
		
		$this->render('categoriaRelacionada',array(
			'model'=>$model)); 
	} 
	 
	
	public function actionCatRela() ///falta avanzar
	{
	
		$cadena=""; 
		$cat_id=explode(",", $_POST['check']);	 
        $bool=true;  

			foreach($cat_id as $each)
			{
				$relacionada=new CategoriaRelacion;
                $relacionada->categoria1=$_POST['categoria'];
                $relacionada->categoria2=$each;
                if(!$relacionada->save()){
                    print_r($relacionada->errors);
                    $bool=false;
                }        
                $log=new Log;
				$log->id_categoria=$_POST['categoria'];
				$log->fecha=date('Y-m-d G:i:s');
				$log->id_admin=Yii::app()->user->id;
				$log->accion=64; //relaciono categorias
				$log->save();        
                  
			}
            Yii::app()->user->setFlash('success','Categorias relacionadas actualizadas');
          

	}
	
	public function actioncrearAvanzar() //el primer guardar de la 1era pestana
	{
		
		$categoria = new Categoria;  ///falta la imagen
		
		if($_POST['oculta']=="")
			$categoria = new Categoria;
		else 
			$categoria = Categoria::model()->findByPk($_POST['oculta']);
		
		if(isset($_POST['padre']))
			$categoria->id_padre = $_POST['padre'];
		else 
			$categoria->id_padre = 0;
		
		$categoria->nombre=$_POST['nombre'];
		$categoria->ultimo=$_POST['ultimo'];
		$categoria->nomenclatura=$_POST['nomenclatura'];
		
		//$this->redirect(array('admin'));
		
		if($categoria->save())
			echo $categoria->id;
			 
	}
	
	public function actionCreate($id = null)
	{
    	if(!is_null($id)) // si viene por get
            {
                $categoria = Categoria::model()->findByPk($id);
                $categoria->nuevo=0;
            }
        else{	    
		
    		if(!isset($_POST['Categoria'])) // si es primera vez que entra
    		{
    			$categoria = new Categoria;
    			$categoria->nuevo=1;
    		}else{
			
			
			   if($_POST['Categoria']['oculta']=="") // si nunca se ha creado y se va a crear
				{
					$categoria = new Categoria;
					$categoria->nuevo=1;
				}
				else 
				{
					$categoria = Categoria::model()->findByPk($_POST['Categoria']['oculta']); //si ya lo ha creado y sobrescribe
					$categoria->nuevo=0;
				}
            } 
        }
		
        $this->performAjaxValidation($categoria);
        
		if(isset($_POST['Categoria']))
		{   ///falta la imagen

			$categoria->attributes = $_POST['Categoria'];
			$categoria->nomenclatura = $_POST['Categoria']['nomenclatura'];
            $categoria->setSeo();
            


			if($_POST['Categoria']['id_padre'] != "") // significa que depende
				$categoria->id_padre = $_POST['Categoria']['id_padre'];
			else
				$categoria->id_padre = 0;
			
			$categoria->ultimo=$_POST['Categoria']['ultimo'];
			if(!is_dir(Yii::getPathOfAlias('webroot').'/images/categoria/'))
				{
	   				mkdir(Yii::getPathOfAlias('webroot').'/images/categoria/',0777,true);
	 			}
            if(!is_dir(Yii::getPathOfAlias('webroot').'/images/categoria/'.$categoria->id))
                {
                    mkdir(Yii::getPathOfAlias('webroot').'/images/categoria/'.$categoria->id,0777,true);
                } 
			
			$rnd = rand(0,9999);  
			$images=CUploadedFile::getInstanceByName('imagen');
            
			
           
			if (isset($images) && count($images) > 0) {
				$categoria->imagen_url = "{$rnd}-{$images}";
				
				
				 
				$nombre = Yii::getPathOfAlias('webroot').'/images/categoria/'.$categoria->id.'/'.$categoria->id;
				$extension = '.'.$images->extensionName;
		       	if ($images->saveAs($nombre . $extension)) {
		             
		       		$categoria->imagen_url = $categoria->id.$extension;
		            $categoria->save();
									
					Yii::app()->user->setFlash('success',"Categoria guardada exitosamente.");

					$image = Yii::app()->image->load($nombre.$extension);
					$image->resize(150, 150);
					$image->save(str_replace(".png","",$nombre).'_thumb'.$extension);
					
					if($extension == '.png'){
						$image = Yii::app()->image->load($nombre.$extension);
						$image->resize(150, 150);
						$image->save(str_replace(".png","",$nombre.$extension).'_thumb.jpg');
					}	
					
				}
				else {
				    $seo=Seo::model()->findByPk($categoria->id_seo);
                    if($seo) $seo->delete();
		        	$categoria->delete();
				}
		        
			}else{
				echo "sin imagenes";
				//Yii::app()->end();
		    	if($categoria->save()){
		        	Yii::app()->user->setFlash('success',"Categoria guardada exitosamente.");
		        }else{
		        	Yii::app()->user->setFlash('error',"Categoria no pudo ser guardada.");
		        }
			}// isset 
			
				if($categoria->save()){
		        	Yii::app()->user->setFlash('success',"Categoria guardada exitosamente.");
		        }else{
		        	Yii::app()->user->setFlash('error',"Categoria no pudo ser guardada.");
		        }
			
			$categoria->refresh();
			$log=new Log;
			$log->id_categoria=$categoria->id;
			$log->fecha=date('Y-m-d G:i:s');
			$log->id_admin=Yii::app()->user->id;
			if($categoria->nuevo==1)
				$log->accion=45; //creo la categoria
	        else
	            $log->accion=46; //modifico la categoria

			$log->save();
		}
		
		$this->render('create',array('model'=>$categoria));
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
    
     
    public function actionCategoriaSeo($id) 
    {
        $model=$this->loadModel($id);
        if(!$model->seo)
            $model->setSeo();
        $seo=$model->seo;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Seo']))
        {
            $seo->attributes=$_POST['Seo'];
            $seo->save();
            $log=new Log;
			$log->id_categoria=$id;
			$log->fecha=date('Y-m-d G:i:s');
			$log->id_admin=Yii::app()->user->id;
			$log->accion=66; //le modifico el seo
			$log->save(); 
            $this->redirect(array('categoria/admin'));
        }

        $this->render('categoriaSeo',array(
            'model'=>$seo, 'categoria'=>$model
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
	public function actionIndexOLD()
	{
		$dataProvider=new CActiveDataProvider('Categoria');
		$this->render('indexOLD',array(
			'dataProvider'=>$dataProvider,
		)); 
	}
    
    public function actionIndex($url)
    {   
        $seo=Seo::model()->findByAttributes(array('amigable'=>$url));
        if($seo){
        	$categoria=Categoria::model()->findByAttributes(array('id_seo'=>$seo->id)); 
            $vec =$categoria->buscarHijos($categoria->id); 
		    $cadena=Funciones::convertirVectoraCadena($vec);

		    $sql="select distinct(marca.id), marca.nombre from tbl_inventario inven join tbl_producto producto on inven.producto_id=producto.id join tbl_producto_padre padre on producto.padre_id=padre.id join tbl_marca marca on padre.id_marca=marca.id join tbl_categoria categoria on padre.id_categoria=categoria.id  
		    where inven.cantidad>0 and producto.estado=1 and categoria.id in(".$cadena.")";
		    $marcas=Marca::model()->findAllBySql($sql);  
            
            if($categoria)
                $this->render('category',array('model'=>$categoria,'imagenes'=>$categoria->getStorefrontImgs(2,7),'marcas'=>$marcas,'mainImg'=>$categoria->getStorefrontImgs(1,1))); 
        }
        else
            throw new CHttpException(404,'Categoría no encontrada');
            
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
	
	public function actionCategoriaAtributo($id = null)
	{  if(!is_null($id)){
    		$this->render('categoriaAtributo',array('model'=>Categoria::model()->findByPk($id)));
    	}
	}
	
	public function actionCatAtrib()
	{ 
		$vector=$_POST['vector'];
		$idAct=$_POST['idAct'];
		
		$categoriaAtributo = CategoriaAtributo::model()->findAllByAttributes(array('categoria_id'=>$idAct)); //borrar antiguos
		if($categoriaAtributo)
		{
			foreach($categoriaAtributo as $cat)
			{
				$cat->activo=0;
				$cat->save();
			}
		}

				
		foreach($vector as $vec) //agregar nuevos
		{
			$categoriaAtributo = CategoriaAtributo::model()->findByAttributes(array('categoria_id'=>$idAct, 'atributo_id'=>$vec));
			if(!$categoriaAtributo)
			{
				$model=new CategoriaAtributo;
				$model->atributo_id=$vec;
				$model->categoria_id=$idAct;
				$model->activo=1;	
				$model->save();
			}
			else
			{
				$categoriaAtributo->activo=1;
				$categoriaAtributo->save();	
			}
		}

        $log=new Log;
		$log->id_categoria=$idAct;
		$log->fecha=date('Y-m-d G:i:s');
		$log->id_admin=Yii::app()->user->id;
		$log->accion=65; //relaciono atributos
		$log->save(); 

		
	}
	
	public function actionActivarDesactivar()
	{
		$id=$_POST['id'];
        $model = Categoria::model()->findByPk($id);
        $model->destacado=1-$model->destacado;
        if($model->destacado==1)
            $model->fecha_destacado=date("Y-m-d h:i:s");
        $model->save();
        $model->refresh();                     
    	$log=new Log;
		$log->id_categoria=$model->id;
		$log->fecha=date('Y-m-d G:i:s');
		$log->id_admin=Yii::app()->user->id;
		if($model->destacado==1)
			$log->accion=47; //destaco
		else
			$log->accion=48; //quito destacado
		$log->save();
        echo $model->destacado;
	}
	public function actionActivarDesactivarCategoria($id)
	{
		$model = Categoria::model()->findByPk($id);
		$model->activo=1-$model->activo;
		$model->save();
		$model->refresh();
		$log=new Log;
		$log->id_categoria=$model->id;
		$log->fecha=date('Y-m-d G:i:s');
		$log->id_admin=Yii::app()->user->id;
		if($model->activo==0)
		{
			$log->accion=49; //desactivo la categoria
			$mensaje="Categoria desactivada correctamente."; 
		}
        else
        {
            $log->accion=50; //activo la categoria
            $mensaje="Categoria activada correctamente."; 
        }
		$log->save();
		Yii::app()->user->setFlash('success',$mensaje);
		
		$this->redirect(array('admin'));
				echo $model->activo;
	}
    
    public function actionStorefrontConf($id, $_=null, $index=null){ 

      $this->render('storefrontConf',array('model'=>Categoria::model()->findByPk($id),'imConf'=>new ConfImage, 'indexModal'=>$index));
    }
    
    public function actionFormConfImage() 
        { 
                                
        
            if(isset($_POST['ConfImage']))
            {   $model=new ConfImage; 
                $model->attributes=$_POST['ConfImage'];
                $previa=ConfImage::model()->findByAttributes(array('categoria_id'=>$_POST['ConfImage']['categoria_id'],'name'=>$_POST['ConfImage']['name'],'index'=>$_POST['ConfImage']['index']));
                    
                    $rnd = rand(0,9999);  
                    
                    $images=CUploadedFile::getInstanceByName('ConfImage[path]');
        
                    if (isset($images) && count($images) > 0) {
                     
                     
                        $model->path = "{$rnd}-{$images}";
                      
                        $dir = Yii::getPathOfAlias('webroot').'/images/categoria/storefront/'.$model->categoria_id;
                        $nombre = $dir.'/'.$model->name.$model->index; 
                        $url=Yii::app()->getBaseUrl(true).'/images/categoria/storefront/'.$model->categoria_id.'/'.$model->name.$model->index;  
 
                        if(!is_dir($dir))
                        {
                            mkdir($dir,0777,true);
                        }
                        $imgAttr=getimagesize(CUploadedFile::getInstanceByName('ConfImage[path]')->getTempName());

                        
                       if(($model->index==1&&($imgAttr[0]!=1200||$imgAttr[1]!=450))||($model->index!=1&&($imgAttr[0]!=380||$imgAttr[1]!=270)))
                        {
                            $this->redirect(array('categoria/storefrontConf', 'id'=>$model->categoria_id,'index'=>$model->index));
                        }       
                        $extension_ori = ".jpg";
                        $extension = '.'.$images->extensionName;
                        if(is_file($nombre.$extension)&&!is_null($previa)){
                            rename($nombre.$extension,$nombre."OLD".$previa->id.$extension);
                        }                       
                        $images->saveAs($nombre . $extension);  
                        $model->path=$url. $extension;
                       
                        if($model->save()){
                        	$log=new Log;
							$log->id_categoria=$model->categoria_id;
							$log->fecha=date('Y-m-d G:i:s');
							$log->id_admin=Yii::app()->user->id;
							$log->accion=44;
							$log->save();
                            if(!is_null($previa))    
                                $previa->delete();
                            $this->redirect(array('categoria/storefrontConf', 'id'=>$model->categoria_id, '_'=>rand(0, 100)));
                        }else{
                            print_r($model->errors);
                            break; 
                        }
                   
                
                    }
                    else{
                      echo "NANE";
                        break;
                    }
                    
                
                
            }else{
                $response=array();
                $model=ConfImage::model()->findByAttributes(array('name'=>$_POST['name'],'index'=>$_POST['index'],'categoria_id'=>$_POST['categoria_id']));
                $response['confirm']=true;
                if(is_null($model)){
                    $model=new ConfImage;
                    $response['confirm']=false;                    
                }
                //print_r($response['confirm']);                
                $response['form']= $this->renderPartial('confImagesform', array(
                    'model'=>$model,'name'=>$_POST['name'],'index'=>$_POST['index'],'group'=>$_POST['group'],'type'=>$_POST['type'], 'categoria_id'=>$_POST['categoria_id'], 'dimError'=> $_POST['confirm'] ),true)
                ;                
                 echo CJSON::encode($response); 
            }
            
        }
    
   
    public function actionSetSeoAll(){
        foreach(Categoria::model()->findAll() as $cat){
            $cat->url_amigable=Funciones::cleanUrlSeo($cat->url_amigable);
            var_dump($cat->seo);
            
        }
        
    }
}
