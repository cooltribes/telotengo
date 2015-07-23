<?php

class ProductoController extends Controller
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
				'actions'=>array('index','view','detalle','loadInventario','calificar','agregarFavorito'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('seleccion','busqueda','create','hijos','imagenes','seo','create','agregarCaracteristica','eliminarCaracteristica','agregarInventario',
								 'agregarInventarioAjax','eliminarInventario','multi','orden', 'clasificar', 'niveles', 'nivelPartial', 'crearProducto'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','update','eliminar','orden','aprobar','rechazar','poraprobar','calificaciones','eliminarCalificacion','importar','inventario', 'verificarPadre', 'verificarNombre', 'details', 'caracteristicas','activarDesactivar'),
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
	
	// seleccion entre crear o buscar
	public function actionSeleccion() 
	{
		if(isset($_POST['busqueda'])){
		    $producto = new Producto;
            $producto->unsetAttributes();     
            $producto->nombre = $_POST['busqueda'];        
            $dataProvider = $producto->searchTwo();
                    
            $this->render('seleccion',array('dataProvider'=>$dataProvider));
		}
		else
			$this->render('seleccion');
	}
	
	public function actionClasificar()
	{
		$this->render('clasificar');
	}
	
	public function actionNiveles()
	{
		if (isset($_POST['id']))
        {	
			echo $this->renderPartial('nivelPartial', array('id'=>$_POST['id'],'nivel'=>$_POST['nivel']),true);
			Yii::app()->end();
		}
			
		
	}
	
	// el usuario decidio buscar el producto
	public function actionBusqueda() 
	{		
		$producto = new Producto;
		$producto->unsetAttributes();  
		
		if(Yii::app()->session['busqueda']){
			$producto->nombre = Yii::app()->session['busqueda'];
		}

		$dataProvider = $producto->searchTwo();
		$this->render('busqueda',array('dataProvider'=>$dataProvider));
	}

	// Guardar calificación para un producto
	public function actionCalificar() {
		$return = array();
		if(Yii::app()->user->isGuest){
			Yii::app()->user->setReturnUrl(Yii::app()->baseUrl.'/producto/detalle/id/'.$_POST['producto_id']);
			Yii::app()->user->setFlash('loginMessage',"Debes iniciar sesión para calificar el producto");
			$array['result'] = 'error';
			$array['description'] = 'login';
		}else{
			if(isset($_POST['producto_id']) && isset($_POST['calificacion'])){
				$calificacion = CalificacionProducto::model()->findByAttributes(array('producto_id'=>$_POST['producto_id'], 'user_id'=>Yii::app()->user->id));

				if($calificacion){ // ya este usuario calificó el producto, edito la calificación
					$calificacion->puntuacion = $_POST['calificacion'];
					$calificacion->fecha = date('Y-m-d h:i:s', time());
				}else{ // creo una nueva calificación para este usuario
					$calificacion = new CalificacionProducto();
					$calificacion->puntuacion = $_POST['calificacion'];
					$calificacion->fecha = date('Y-m-d h:i:s', time());
					$calificacion->producto_id = $_POST['producto_id'];
					$calificacion->user_id = Yii::app()->user->id;
				}

				if($calificacion->save()){ // ya tengo la calificacion, guardo y busco el promedio para retornar
					$numero_calificaciones = CalificacionProducto::model()->countByAttributes(array('producto_id'=>$_POST['producto_id']));
					$calificaciones = CalificacionProducto::model()->findAllByAttributes(array('producto_id'=>$_POST['producto_id']));
					$puntaje_acumulado = 0;
					foreach ($calificaciones as $calificacion) {
						$puntaje_acumulado += $calificacion->puntuacion;
					}
					$average = $puntaje_acumulado / $numero_calificaciones;

					$array['result'] = 'ok';
					$array['average'] = $average;
					$array['votes'] = $numero_calificaciones;
				}else{
					$array['result'] = 'error';
					$array['description'] = $calificacion->getErrors();
				}
			}
		}
		echo json_encode($array);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCrearProducto()
	{
		if(isset($_GET['id'])) //buscar los atributos correspondientes a esa categoria, para llenarlos a continuacion (categoriaAtributo)..
		{
			$model=1; //por ahora	//aqui voy a crear un nuevo producto en base a una categoria, pero ese producto no existe aun....
			$this->render('crearProducto',array( /// aqui va el modelo nuevo 
				'model'=>$model,
			));
		}
		
	}
	
	public function actionCreate($id = null)
	{
     
		 
         if(is_null($id)){
             $model=new Producto;
          
         }
         else{
             $model=Producto::model()->findByPk($id);
         }

         if(isset($_POST['padre']))
            {
                $model->padre_id=$_POST['padre'];
                //$model->padre->nombre;
            }   
            
		
		// Uncomment the following line if AJAX validation is needed
		  $this->performAjaxValidation($model);

		if(isset($_POST['Producto']))
		{
			if(isset($_POST['padre_id']))
			{   $modelado=ProductoPadre::model()->findByAttributes(array('nombre'=>$_POST['padre_id']));	
	
				$model->padre_id=$modelado->id;
			}
			$model->attributes=$_POST['Producto'];
            $model->setSeo();
			$model->fabricante=$_POST['Producto']['fabricante'];
			$model->annoFabricacion=$_POST['Producto']['annoFabricacion'];
			$model->upc=$_POST['Producto']['upc'];
			$model->ean=$_POST['Producto']['ean'];
			$model->gtin=$_POST['Producto']['gtin'];
			$model->isbn=$_POST['Producto']['isbn'];
			$model->color=$_POST['Producto']['color'];
			if($model->save())
			{
					 $this->redirect(Yii::app()->baseUrl.'/producto/imagenes/'.$model->id);     

			}
			
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	
	
	/*public function actionCreate()
	{
		$user = Yii::app()->user->id;

		//$empresas_user = EmpresasHasUsers::model()->findAllByAttributes(array('users_id'=>$user));
		
		$u = User::model()->findByPk($user);
		
		if( $u->superuser==1) //sizeof($empresas_user)>0 || $u->superuser==1) // el usuario tiene al menos una empresa registrada		{
		{
			if(isset($_GET['id']))
				$model = Producto::model()->findByPk($_GET['id']);
			else
				$model=new Producto;
			
			//$mongo = new Mongo('72.167.13.125:1234');
			//$carro = new Carro();
			$caracteristica = new Caracteristica();
	
			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);
		
			if(isset($_POST['Producto']))
			{ 
				$model->attributes=$_POST['Producto'];

				/*if(UserModule::isAdmin()){
					$model->estado = 1; // aprobado
					$model->notificado = 1; // no aparece como notificacion
				}
				else{
					$model->estado = 0; // solicitado	
					$model->notificado = 0; // El administrador aun no ha visto
				}*/
				/*$model->notificado = 1; // no aparece como notificacion
				$model->interno = "por ahora"; // mientras definimos la estructura del mismo
				$model->users_id =  Yii::app()->user->id;
				$model->estado = $_POST['Producto']["estado"];

				if($model->save()){

					// autocompletando algo del seo
					$tags = explode(" ",$model->nombre);
					array_push($tags,$model->modelo);
					
					if(!$seo = Seo::model()->findByAttributes(array('producto_id'=>$model->id)))
						$seo = new Seo;
					
					$seo->producto_id = $model->id;
					$guardar="";
					$seo->amigable = str_replace(" ", "-", $model->nombre);
					
					foreach($tags as $tag)
						$guardar = $guardar." ".$tag.",";
					
					$seo->tags = $guardar;
					$seo->save();
					
					$prod_has = CategoriaHasProducto::model()->findAllByAttributes(array('producto_id'=>$model->id));
				
					if(count($prod_has)>0){
						$id1 = $prod_has[0]->id;
						$id2 = $prod_has[1]->id;
					}
					
					// revisando si hay categoria padre e hija
					if(isset($_POST['cate_padre']))
					{
						if(isset($id1))
							$a = CategoriaHasProducto::model()->findByPk($id1);
						else
							$a = new CategoriaHasProducto;
						
						$a->categoria_id = $_POST['cate_padre'];
						$a->producto_id = $model->id;
						
						$a->save();
					}
					
					if(isset($_POST['cate_hijos']))
					{
						if(isset($id2))
							$b = CategoriaHasProducto::model()->findByPk($id2);
						else
							$b = new CategoriaHasProducto;
						
						$b->categoria_id = $_POST['cate_hijos'];
						$b->producto_id = $model->id;
						
						$b->save();
					}	
					
					//$caracteristica->producto_id = $model->id;
					//$caracteristica->nombre = 'pantalla';
					//$caracteristica->valor = '15'; 
					//if($caracteristica->save()){
					if(UserModule::isAdmin())	
						Yii::app()->user->setFlash('success',"El producto se ha guardado correctamente.");
					else{
						Yii::app()->user->setFlash('success',"El producto se ha creado, se enviará la información al administrador para su aprobación.");
						Yii::app()->user->setFlash('info',"Por favor complete el resto de la información. (Imagenes y Características)");
					}
					
					 	$this->redirect(array('producto/create/'.$model->id)); 
					
				}
			}
			
			$this->render('create',array(
				'model'=>$model,
			));
			
			
		} // isset
		else {
			$model = new Producto;
			Yii::app()->user->setFlash('error',"Debe tener asociada una empresa para poder crear un producto.");
			
			$this->redirect(array('empresas/create'));
		}
		
			
			
	}*/
	 
	/**
	 * Imagenes
	 */
	public function actionImagenes($id)
	{
		
		if(isset($_GET['id'])){
			
			$id = $_GET['id'];
			
			if(!$imagen = Imagenes::model()->findByAttributes(array('producto_id'=>$id)))
				$imagen = new Imagenes;
			
			$model = Producto::model()->findByPk($id);
			
		}
		else {
			$imagen = new Imagenes;
			$model = new Producto;
			$id="";
		}

		$this->render('_view_imagenes',array(
			'model'=>$model,
			'imagen'=>$imagen,
		));
	}

	public function actionDetalle()
	{
		if(isset($_POST['Pregunta']))
		{
			$model=new Pregunta;	
			
			$model->attributes=$_POST['Pregunta'];
			$model->fecha = date('Y-m-d H:i:s');
			$model->producto_id = $_POST['id'];
			$model->users_id = Yii::app()->user->id;
			
			if($model->save())
			{
				Yii::app()->user->setFlash('success',"Pregunta enviada.");
				$this->redirect(array('detalle','id'=>$model->producto_id));
			}		
		}
		

		if( isset($_GET['id']) || isset($_GET['alias']) ){

			if(isset($_GET['alias'])){
				$seo = Seo::model()->findByAttributes(array('amigable'=>$_GET['alias']));
				$model = Producto::model()->findByPk($seo->producto_id);
				$marca = Marca::model()->findByPk($model->marca_id);
			}else if(isset($_GET['id'])){
				$model = Producto::model()->findByPk($_GET['id']);
				$marca = Marca::model()->findByPk($_GET['id']);
			}
			
			$numero_calificaciones = CalificacionProducto::model()->countByAttributes(array('producto_id'=>$model->id));
			$calificacion_total = 0;
			$calificacion_promedio = 0;
			$calificaciones = CalificacionProducto::model()->findAllByAttributes(array('producto_id'=>$model->id));
			foreach ($calificaciones as $c) {
				$calificacion_total += $c->puntuacion;
			}
			if ($numero_calificaciones > 0) {
				$calificacion_promedio = $calificacion_total / $numero_calificaciones;
			}
			if(Yii::app()->user->isGuest){
				$calificacion_usuario = null;
			}else{
				$calificacion_usuario = CalificacionProducto::model()->findByAttributes(array('producto_id'=>$model->id, 'user_id'=>Yii::app()->user->id));
			}
			
			$this->render('_view_producto',array(
				'model'=>$model,
				'marca'=>$marca,
				'numero_calificaciones'=>$numero_calificaciones,
				'calificacion_usuario' => $calificacion_usuario,
				'calificacion_promedio' => $calificacion_promedio,
			));
			
		}
		
	}

	/* Cargar el inventario con mejor precio al seleccionar una característica en el detalle de producto. Retorna un objeto json con los detalles del inventario */

	public function actionLoadInventario(){
		$inventario_buscado_id = 0;
		$found = false;

		$selected = explode(',', $_POST['selected']);
		$buscar = array($_POST['clicked']);
		// Agrego todas las caracteristicas buscada a un array
		foreach ($selected as $new) {
			if($new != ''){
				$buscar[] = $new;
			}
		}

		// Busco todos los objetos que tengan alguna de las caracteristicas buscadas
		$criteria = new EMongoCriteria(array(
            'conditions'=>array(
                'valor'=>array('in' => $buscar), 
            ),
            //'sort'=>array('valor' => EMongoCriteria::SORT_ASC),
        ));
        //$criteria->condition = "caracteristica_id = ".$c_caracteristica->caracteristica->id.' AND producto_id = '.$model->id;
        $caracteristicas_nosql = Caracteristica::model()->findAll($criteria);

        // Recorro los objetos dos veces para buscar el inventario_id repetido, que es el que necesito
        foreach ($caracteristicas_nosql as $first) {
        	$cont = 0;
        	foreach ($caracteristicas_nosql as $second) {
        		// Si el inventario_id se repite, aumento el contador de repeticiones
        		if($first->inventario_id == $second->inventario_id){
        			$cont++;
        		}
        	}
        	
        	if($cont == sizeof($buscar)){
        		$inventario_buscado_id = $first->inventario_id;
        		$found = true;
        	}else{
        		
        	}
        } 
        
        // Si el contador de repeticiones es igual al numero de valores buscados, este es el inventario que necesito
        // De lo contario, busco un inventario basado en la caracteristica clickeada, sin tomar en cuenta las demás seleccionadas
        if($found){
	        $inventario = Inventario::model()->findByPk($inventario_buscado_id);
		}else{

			// Revisar Mongo DB. La combinacion no la consigue en Caracteristica por tanto da error
			// el error es que las pulgadas de la pantalla se envian en numero y en mongo tienen las pulgadas (ejm 11 \"")

			$caracteristica_nosql = Caracteristica::model()->findByAttributes(array('producto_id'=>$_POST['producto_id'], 'valor'=>$_POST['clicked']));
    		$inventario = Inventario::model()->findByPk($caracteristica_nosql->inventario_id);
		}
        
		if(isset($inventario)){

			$flashsale = Flashsale::model()->findByAttributes(array('inventario_id'=>$inventario->id,'estado'=>1));  // activo
				
			$almacen = Almacen::model()->findByPk($inventario->almacen_id);
            $ciudad = Ciudad::model()->findByPk($almacen->ciudad_id);
			$provincia = Provincia::model()->findByPk($almacen->provincia_id);

			$otras_caracteristicas = Caracteristica::model()->findAllByAttributes(array('inventario_id'=>$inventario->id));
			
			if(isset($flashsale))
			{
				$return = array( 
					'inventario' => array(
						'id' => $inventario->id,
						'precio' => $inventario->precio,
						'precio_tienda' => $inventario->precio_tienda,
						'cantidad' => $inventario->cantidad,
					),
					'caracteristicas' => $otras_caracteristicas,
					'almacen' => array(
	
					),
					'ciudad' => array(
						'nombre' => $ciudad->nombre,
					),
					'provincia' => array(
						'nombre' => $provincia->nombre,
					),
					'flashsale' => array(
						'status' => true,
						'precio' => $inventario->precio - $flashsale->descuento,
						'descuento' => $flashsale->descuento,
						'cantidad' => $flashsale->cantidad,
						'fecha_fin' => $flashsale->fecha_fin,
					),
					
					//'not_found' => $not_found
				);
				
				echo json_encode($return);
			}
			else
			{
				$return = array(
					'inventario' => array(
						'id' => $inventario->id,
						'precio' => $inventario->precio,
						'precio_tienda' => $inventario->precio_tienda,
						'cantidad' => $inventario->cantidad,
					),
					'caracteristicas' => $otras_caracteristicas,
					'almacen' => array(
	
					),
					'ciudad' => array(
						'nombre' => $ciudad->nombre,
					),
					'provincia' => array(
						'nombre' => $provincia->nombre,
					),
					'flashsale' => array( 
						'status' => false,
					),
					//'not_found' => $not_found
				);
				
				echo json_encode($return);
			} // else

		}else{
			echo json_encode(array(
				'error' => 'No inventory',
				//'buscar' => $buscar,
			));
		}


		
		/*$caracteristica_nosql = Caracteristica::model()->findByAttributes(array('producto_id'=>$_POST['producto_id'], 'valor'=>$_POST['clicked']));
		$inventario_id = $caracteristica_nosql->inventario_id;
		$not_found = array();
		foreach ($selected as $valor) {
			if($valor != ''){
				$c_nosql = Caracteristica::model()->findByAttributes(array('producto_id'=>$_POST['producto_id'], 'valor'=>$valor, 'inventario_id'=>$inventario_id));
				if(!$c_nosql){
					$not_found[] = $valor;
				}else{
					//$not_found[] = $c_nosql;
				}
			}
		}
		$inventario = Inventario::model()->findByPk($caracteristica_nosql->inventario_id);
		if(isset($inventario)){
			$otras_caracteristicas = Caracteristica::model()->findAllByAttributes(array('inventario_id'=>$inventario->id));
			$return = array(
				'inventario' => array(
					'id' => $inventario->id,
					'precio' => $inventario->precio,
					'precio_tienda' => $inventario->precio_tienda,
				),
				'caracteristicas' => $otras_caracteristicas,
				'not_found' => $not_found
			);
			
			echo json_encode($return);
		}*/
		//echo json_encode($caracteristicas_nosql);
		/*if(isset($_POST['caracteristica_id'])){
			//$caracteristica_nosql = Caracteristica::model()->findByPk(new MongoID($_POST['caracteristica_nosql_id']));
			$caracteristica_nosql = Caracteristica::model()->findByAttributes(array('caracteristica_id'=>$_POST['caracteristica_id'], 'producto_id'=>$_POST['producto_id'], 'valor'=>$_POST['valor']));
			//var_dump($caracteristica_nosql);
			if(isset($caracteristica_nosql)){
				$inventario = Inventario::model()->findByPk($caracteristica_nosql->inventario_id);
				if(isset($inventario)){
					$otras_caracteristicas = Caracteristica::model()->findAllByAttributes(array('inventario_id'=>$inventario->id));
					$return = array(
						'inventario' => array(
							'id' => $inventario->id,
							'precio' => $inventario->precio,
							'precio_tienda' => $inventario->precio_tienda,
						),
						'caracteristicas' => $otras_caracteristicas
					);
					
					echo json_encode($return);
				}
			}
		}*/
	}
	
	/*
	 * Action para que el administrador apruebe un producto creado por un usuario
	 */ 
	public function actionPorAprobar()
	{
		$model=new Producto('search');
		$model->unsetAttributes();  // clear any default values
		
		$model->notificado = 0;
		$dataProvider = $model->search();

		$this->render('aprobar',array(
			'model'=>$model,
			'dataProvider' => $dataProvider,
		));
		
	}	
	
	/*
	 * Action para que el administrador apruebe un producto creado por un usuario
	 */ 
	public function actionAprobar()
	{
		$id = $_GET['id'];
		
		$producto = Producto::model()->findByPk($id);
		$producto->estado = 1; // aprobado
		$producto->notificado = 1; // revisado
		
		$producto->save();
		
		Yii::app()->user->setFlash('success',"El producto se ha aprobado correctamente.");
		
		$this->redirect(array('producto/poraprobar'));	
	}
		
	/*
	 * Action para que el administrador apruebe un producto creado por un usuario
	 */ 
	public function actionRechazar()
	{
		$id = $_GET['id'];
		
		$producto = Producto::model()->findByPk($id);
		$producto->estado = 2; // aprobado
		$producto->notificado = 1; // revisado
		
		$producto->save();
		
		Yii::app()->user->setFlash('error',"El producto se ha rechazado correctamente.");
		
		$this->redirect(array('producto/poraprobar'));	
	}	
	
	
	// carga de imagenes
	public function actionMulti() {
				
		if(!isset($_GET['id'])){
			$this->redirect(array('producto/imagenes'));
		}
		else {
				$id = $_GET['id'];
			
			// make the directory to store the pic:
				if(!is_dir(Yii::getPathOfAlias('webroot').'/images/producto/'. $id))
				{
	   				mkdir(Yii::getPathOfAlias('webroot').'/images/producto/'. $id,0777,true);
	 			}
				
	        	$images = CUploadedFile::getInstancesByName('url');

		        if (isset($images) && count($images) > 0) {
		            foreach ($images as $image => $pic) {
												
						$imagen = new Imagenes;
		                $imagen->producto_id = $_GET['id'];
						
						$imagen->orden = 1 + Imagenes::model()->countByAttributes(array('producto_id'=>$_GET['id']));
						
		                // $imagen->orden = 1 + Imagenes::model()->count('`producto_id` = '.$_GET['id'].'');
		                
		               	if($imagen->save())
						{
													
		                $nombre = Yii::getPathOfAlias('webroot').'/images/producto/'. $id .'/'. $imagen->id;
		                $extension_ori = ".jpg";
						$extension = '.'.$pic->extensionName;
						
		                if ($pic->saveAs($nombre . $extension)) {
		
		                    $imagen->url = '/images/producto/'. $id .'/'. $imagen->id .$extension;
		                    $imagen->save();
							
							Yii::app()->user->updateSession();
							Yii::app()->user->setFlash('success',UserModule::t("La imágen ha sido cargada exitosamente."));
			
							$image = Yii::app()->image->load($nombre . $extension);
		                    $image->save($nombre . "_orig".$extension); 
							
							if ($extension == '.png')
								$image->save($nombre ."_orig". $extension_ori);
							
							/* thumb */
							$image = Yii::app()->image->load($nombre . $extension);
		                    $image->resize(300, 240);
		                    $image->save($nombre . "_thumb".$extension);
							
							if ($extension == '.png'){
								$image->resize(300, 240)->quality(95);	
								//$image->super_crop(300,240,"top","left");
								$image->save($nombre .  "_thumb".$extension_ori);	
							}	
							
							/* productos thumb */
							$image = Yii::app()->image->load($nombre . $extension);
		                    $image->resize(90, 90);
		                    $image->save($nombre . "_x90".$extension);
							
							if ($extension == '.png'){
								$image->resize(90, 90)->quality(95);	
								//$image->super_crop(90,90,"top","left");
								$image->save($nombre .  "_x90".$extension_ori);	
							}
							
							/* productos thumb retina */
							$image = Yii::app()->image->load($nombre . $extension);
		                    $image->resize(180, 180);
		                    $image->save($nombre . "_x180".$extension);
							
							if ($extension == '.png'){
								$image->resize(180, 180)->quality(95);	
								//$image->super_crop(180,180,"top","left");
								$image->save($nombre .  "_x180".$extension_ori);	
							}		
							
							/* imagen principal del producto */
							$image = Yii::app()->image->load($nombre . $extension); 
		                    $image->resize(566, 566);
		                    $image->save($nombre . $extension);
							
							if ($extension == '.png'){
								$image->resize(566, 566)->quality(95);	
								//$image->super_crop(566,566,"top","left");
								$image->save($nombre . $extension_ori);		
							}
																	
		                } else {
		                	
							echo "error: ";
							
		                    $imagen->delete();
		                }
						
		                }
		                else
						{
							print_r($imagen->getErrors());
							Yii::app()->end();
						}	
						
						
		            }// foreach
		        }// isset
		        else {
						Yii::app()->user->updateSession();
						Yii::app()->user->setFlash('success',UserModule::t("Los cambios han sido guardados."));	
				}


        		$this->redirect(array('producto/imagenes', 'id' => $id));
        }//else principal
    }

   /* public function actionCaracteristicas(){
		
		$user = Yii::app()->user->id;
		$empresas_user = EmpresasHasUsers::model()->findAllByAttributes(array('users_id'=>$user));
	
		if(isset($empresas_user)>0) // el usuario tiene al menos una empresa registrada
		{
			
			if(isset($_GET['id']))
				$producto = Producto::model()->findByPk($_GET['id']);
			else{
				Yii::app()->user->setFlash('error',"Debe crear o seleccionar un producto");
				$this->redirect(array('producto/create')); 
			}
			
			$model = new CaracteristicasProducto();
			$model->producto_id = $_GET['id'];

			$caracteristicas = array();
			$categorias_producto = CategoriaHasProducto::model()->findAllByAttributes(array('producto_id'=>$model->producto_id));
			foreach ($categorias_producto as $cp) {
				$categorias_caracteristicas = CategoriaHasCaracteristicaSql::model()->findAllByAttributes(array('categoria_id'=>$cp->categoria_id));
				foreach ($categorias_caracteristicas as $cc) {
					$c = CaracteristicasSql::model()->findByAttributes(array('id'=>$cc->caracteristica_id));
					if($c){
						$caracteristicas[] = $c;
					}
				}
			}
			
			$this->render('caracteristicas',array(
				'model'=>$model,
				'producto'=>$producto,
				'caracteristicas'=>$caracteristicas,
			));
		} // isset
		else {
			$model = new Producto;
			Yii::app()->user->setFlash('error',"El usuario debe tener asociada una empresa para poder crear un producto.");
			
			$this->redirect(array('producto/admin'));
		}
	}*/

	public function actionAgregarInventario($producto_id){
		$model = new Inventario();
		$model->unsetAttributes();
		$model->producto_id = $producto_id;
		//$caracteristica = new Caracteristica(); 
		$user_id = Yii::app()->user->id;
		$empresas_user = EmpresasHasUsers::model()->findAllByAttributes(array('users_id'=>$user_id));
		$almacenes = array();

		if((sizeof($empresas_user)>0) || Yii::app()->user->isAdmin()) { // el usuario tiene al menos una empresa registrada o es admin
			$producto = Producto::model()->findByPk($producto_id);
			$inventario_menor_precio = Inventario::model()->getMenor($producto->id);
			if($producto){
				if(!Yii::app()->user->isAdmin()){
					// guardo las sucursales disponibles para las empresas del usuario
					foreach ($empresas_user as $empresa_user) {
					    $temp = Almacen::model()->findAllByAttributes(array('empresas_id'=>$empresa_user->empresas_id));
					    if(sizeof($temp) > 0){
					        foreach ($temp as $almacen) {
					            $almacenes[] = $almacen;
					        }
					    }
					}
					if(sizeof($almacenes) == 0){ //no tiene ninguna sucursal disponible, lo llevo al listado de empresas para que cree una
						Yii::app()->user->setFlash('error',"No tiene ninguna sucursal disponible en ninguna empresa, por favor agregue una para poder vender");
						$this->redirect(array('empresas/listado'));
					}
				}

				$inv = new Inventario;
				$inv->producto_id = $producto_id;
				$dataProvider = $inv->search();
				//var_dump($dataProvider->getData());
				//Yii::app()->end();
				//$dataProvider = new CActiveDataProvider('Inventario',array('data'=>array()));

				if(isset($_GET['Inventario'])){
					$dataProvider = $model->getInventariosAlmacen($producto->id, $_GET['Inventario']['almacen_id']);
				}

				$this->render('confirmar_inventario',array(
					'model'=>$model,
					'producto'=>$producto,
					'user_id'=>$user_id,
					'empresas_user'=>$empresas_user,
					'inventario_menor_precio'=>$inventario_menor_precio,
					'dataProvider' => $dataProvider,
					'almacenes' => $almacenes,
				));
			}else{
				Yii::app()->user->setFlash('error',"El producto no existe");
				
				$this->redirect(array('producto/seleccion'));
			}
		}
	}

	public function actionAgregarInventarioAjax(){
		if(isset($_POST['Inventario'])){
			$model = new Inventario();
			$model->sku = $_POST['Inventario']['sku'];
			$model->attributes=$_POST['Inventario'];
			if($model->save()){
				
				// Wishilists que tengan el producto
				$Wishlists = WishlistHasProducto::model()->findAllByAttributes(array('producto_id'=>$model->producto_id));
				
				// A cada wishlist que tenga el producto se le envia un correo avisando
				// que se el producto esta disponible
				
				foreach($Wishlists as $wish){
					$wishlist = Wishlist::model()->findByPk($wish->wishlist_id);
					$user = User::model()->findByPk($wishlist->users_id);
					$producto = Producto::model()->findByPk($model->producto_id);
					
					$message = new YiiMailMessage;				
					$message->view = "mail_template";
					$subject = '¡Tu lista de deseos está disponible en Telotengo.com!';
							$body = "Uno de los productos que tienes en tu lista de deseos <b>".$wishlist->nombre."</b><br/>
									<br/>
									Producto: ".$producto->nombre."<br/>
									
									<br/>
									¡Visitanos y compralo antes de que se agote!<br/> 
									";
					$params              = array('subject'=>$subject, 'body'=>$body);
					$message->subject    = $subject;
					$message->setBody($params, 'text/html');                
					$message->addTo($user->email);
					$message->from = array('info@telotengo.com' => 'Telotengo');
					Yii::app()->mail->send($message);
				}
				
				
				$caracteristicas_producto = CaracteristicasProducto::model()->findAllByAttributes(array('producto_id'=>$model->producto_id));
				if(sizeof($caracteristicas_producto) > 0){
					foreach ($caracteristicas_producto as $cp) {
						$caracteristica_nosql = new Caracteristica();
						$caracteristica_nosql->producto_id = $model->producto_id;
						$caracteristica_nosql->caracteristica_id = $cp->caracteristica->id;
						$caracteristica_nosql->valor = $_POST[$cp->caracteristica->id];
						$caracteristica_nosql->inventario_id = $model->id;
						$caracteristica_nosql->save();

						//echo 'Guardado';
					}
				}
			}else{
				//echo 'nooooo';
			}
		}
	}

	public function actionEliminarInventario(){
		if(isset($_POST['id'])){
			$model = Inventario::model()->findByPk($_POST['id']);
			$model->estado = 3;
			$model->save();
		}
	}

	public function actionAgregarCaracteristica(){
		if(isset($_POST['CaracteristicasProducto'])){
			$model = new CaracteristicasProducto();
			$model->attributes=$_POST['CaracteristicasProducto'];
			$model->save();
			//echo 'Saved: '.$_POST['CaracteristicasProducto']['nombre'];
		}
	}

	public function actionEliminarCaracteristica($id){
		$model = CaracteristicasProducto::model()->findByPk($id);
		$model->delete();
	}

	// eliminacion en bd y fisica
    public function actionEliminar() {
        if (Yii::app()->request->isPostRequest) {

			$model=Imagenes::model()->findByPk($_POST['id']);
            
            if ($model) {
                if (is_file(Yii::app()->basePath . '/..' . $model->url))
				{
                    unlink(Yii::app()->basePath . '/..' . $model->url);
					unlink(Yii::app()->basePath . '/..' . str_replace(".","_thumb.",$model->url));
					unlink(Yii::app()->basePath . '/..' . str_replace(".","_orig.",$model->url));
					unlink(Yii::app()->basePath . '/..' . str_replace(".","_x180.",$model->url));
					unlink(Yii::app()->basePath . '/..' . str_replace(".","_x90.",$model->url));
					
					$pos = strpos($model->url,".png");
					
					if($pos!==false) // la imagen fue un .png
					{
						
						$url = str_replace(".png",".jpg",$model->url);
						
						unlink(Yii::app()->basePath . '/..' . $url);
						unlink(Yii::app()->basePath . '/..' . str_replace(".","_thumb.",$url));
						unlink(Yii::app()->basePath . '/..' . str_replace(".","_orig.",$url));
						unlink(Yii::app()->basePath . '/..' . str_replace(".","_x180.",$url));
						unlink(Yii::app()->basePath . '/..' . str_replace(".","_x90.",$url));
					}
					
				}
                $model->delete();
            }
            echo "OK";
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }
	
	// le da un nuevo orden a las imagenes
    public function actionOrden() {
        if (Yii::app()->request->isPostRequest) {

            $action = $_POST['action'];
            $actualizarImgs = $_POST['img'];
			
			if ($action == "actualizar_orden") {
                $orden = 1;
                foreach ($actualizarImgs as $img) {
                    Imagenes::model()->updateByPk($img, array('orden' => $orden));
                    echo("<br> ".$img);
					echo($orden);
                    $orden++;
				}
            }
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }
		
	
	/** 
	 * seo
	 */
	public function actionSeo($id)
	{
		  
		if(isset($_GET['id'])){
		    $model=Producto::model()->findByPk($id);
              if(is_null($model->seo))
                    $model->setSeo();  
            
		}
		    
        else{
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
            Yii::app()->end;
        }

			
            
		  
		
        $seo=$model->seo;

		
		if(isset($_POST['Seo'])){
			$seo->attributes = $_POST['Seo'];

			
			if($seo->save()){
			     Yii::app()->user->setFlash('success',"Datos guardados exitosamente.");
                 $this->redirect(Yii::app()->baseUrl.'/producto/caracteristicas/'.$model->id);     
            }
			
					
		}
		
		$this->render('_view_seo',array(
			'model'=>$model,
			'seo'=>$seo,
		));
	}
	
	public function actionCaracteristicas($id=null)
	{
					

			$model = Producto::model()->findByPk($id);
			
			if(isset($_POST['Producto']))
			{
				/*$seo->attributes = $_POST['Seo'];
				$seo->producto_id = $_GET['id'];*/
				//echo $model->caracteristica4;
				$var="";
				if(isset($_POST['Producto']['caracteristica1']))
				{
					$var=$_POST['Producto']['caracteristica1'];
					if(isset($_POST['Producto']['caracteristica2']))
					{
						 $var=$var."*-*".$_POST['Producto']['caracteristica2'];
						if(isset($_POST['Producto']['caracteristica3']))
						{
							 $var=$var."*-*".$_POST['Producto']['caracteristica3'];
							if(isset($_POST['Producto']['caracteristica4']))
							{
								 $var=$var."*-*".$_POST['Producto']['caracteristica4'];
								if(isset($_POST['Producto']['caracteristica5']))
								{
									 $var=$var."*-*".$_POST['Producto']['caracteristica5'];
								}
							}
						}
					}
					
				} 
				
                $model->descripcion=$_POST['Producto']['descripcion'];
				$model->caracteristicas=$var;
				if($model->save())
                    $this->redirect(Yii::app()->baseUrl.'/producto/details/'.$model->id);     
				//HACER ALGO IR ALGUN LADO
			
					
			}		
			else{

			$model->scenario="caracteristicas";
			if(!is_null($model->caracteristicas)) //imprimir las caracteristicas
			{
				$vector=explode("*-*", $model->caracteristicas);
				$i=0;
				foreach($vector as $vec)
				{
					if($i==0)
					{
						$model->caracteristica1=$vec;
					}
					if($i==1)
					{
						$model->caracteristica2=$vec;
					}
					if($i==2)
					{
						$model->caracteristica3=$vec;
					}
					if($i==3)
					{
						$model->caracteristica4=$vec;
					}
					if($i==4)
					{
						$model->caracteristica5=$vec;
					}
					 
					$i++;
				}
			} 
			
					$this->render('caracteristicas',array(
				'model'=>$model,
			));
		}
		

		
		
 

	}

	/* inventario */
	public function actionInventario()
	{
		if(isset($_GET['id'])){
			$id = $_GET['id'];
			if(!$inventario = Inventario::model()->findByAttributes(array('producto_id'=>$id)))
				$inventario = new Inventario;

			$producto = Producto::model()->findByPk($id);
		}
		else {
			$inventario = new Inventario;
			$id="";
			$producto = new Producto;
		}
		
		if(isset($_POST['Inventario'])){
			$inventario->attributes = $_POST['Inventario'];
			$inventario->sku = $_POST['Inventario']['sku'];
			$inventario->producto_id = $_POST['Inventario']['producto_id'];
			$inventario->almacen_id = $_POST['Inventario']['almacen_id'];
			$inventario->precio_tienda = $_POST['Inventario']['precio_tienda'];
			
			$producto->saveAttributes(array('estado'=>1));

			$inventario->save();	
			
			Yii::app()->user->setFlash('success',"Inventario guardado exitosamente. El producto está ahora activo.");
		}
		
		$this->render('inventario',array(
			'producto'=>$producto,
			'model'=>$inventario,
		));
	}
	
	public function actionHijos(){
		
		if(isset($_POST['categoria_id'])){
				
			$categ = Categoria::model()->findAllByAttributes(array('id_padre'=>$_POST['categoria_id']), array('order'=>'id ASC'));
			//$ciudades = Ciudad::model()->findAllByAttributes(array('provincia_id'=>$_POST['provincia_id']), array('order'=>'nombre ASC'));
			
			if(sizeof($categ) > 0){
				$return = '';
				
				foreach ($categ as $una) {
					$return .= '<option value="'.$una->id.'">'.$una->nombre.'</option>';
				}
				
				echo $return;
			}
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

		if(isset($_POST['Producto']))
		{
			$model->attributes=$_POST['Producto'];
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
		$model=Imagenes::model()->findByPk($_GET['id']);
        $inventarios = Inventario::model()->findAllByAttributes(array('producto_id'=>$_GET['id']));   
		$producto = Producto::model()->findByPk($_GET['id']);
		   
		if(isset($inventarios)){
			foreach($inventarios as $inventario){
				$inventario->delete();
			}
		}   
		// inventarios eliminados.
			
			if ($model) {
                if (is_file(Yii::app()->basePath . '/..' . $model->url))
				{
                    unlink(Yii::app()->basePath . '/..' . $model->url);
					unlink(Yii::app()->basePath . '/..' . str_replace(".","_thumb.",$model->url));
					unlink(Yii::app()->basePath . '/..' . str_replace(".","_orig.",$model->url));
					unlink(Yii::app()->basePath . '/..' . str_replace(".","_x180.",$model->url));
					unlink(Yii::app()->basePath . '/..' . str_replace(".","_x90.",$model->url));
					
					$pos = strpos($model->url,".png");
					
					if($pos!==false) // la imagen fue un .png
					{
						
						$url = str_replace(".png",".jpg",$model->url);
						
						unlink(Yii::app()->basePath . '/..' . $url);
						unlink(Yii::app()->basePath . '/..' . str_replace(".","_thumb.",$url));
						unlink(Yii::app()->basePath . '/..' . str_replace(".","_orig.",$url));
						unlink(Yii::app()->basePath . '/..' . str_replace(".","_x180.",$url));
						unlink(Yii::app()->basePath . '/..' . str_replace(".","_x90.",$url));
					}
					
				}
                $model->delete();
            }
		
		$producto->delete();
		
		Yii::app()->user->setFlash('success',"Producto eliminado exitosamente.");
       	$this->redirect(array('producto/admin')); 
	}

	/**
	 * Eliminar calificacion de un producto desde el admin
	 */
	public function actionEliminarCalificacion($id){
		$calificacion = CalificacionProducto::model()->findByPk($id);
		$producto_id = $calificacion->producto_id;
		$calificacion->delete();
		Yii::app()->user->setFlash('success',"Calificacion eliminada");

		$this->redirect(array('producto/calificaciones/'.$producto_id));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Producto');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{	
		$model = new Producto;
		$model->unsetAttributes();  // clear any default values
		$bandera=false;
		$dataProvider = $model->listar();

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
            $model->nombre = $_POST['query'];
            $dataProvider = $model->listar();
        }	

        if($bandera==FALSE){
			unset($_SESSION['searchBox']);
        }

		if(isset($_GET['Producto']))
			$model->attributes=$_GET['Producto'];

		$this->render('admin',array(
			'model'=>$model,
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Ver calificaciones para un producto desde el panel de admin
	 */
	public function actionCalificaciones($id)
	{
		$model=$this->loadModel($id);
		$calificacion = new CalificacionProducto();
		$calificacion->producto_id = $model->id;
		$dataProvider = $calificacion->search();

		$numero_calificaciones = CalificacionProducto::model()->countByAttributes(array('producto_id'=>$model->id));
		$calificacion_total = 0;
		$calificacion_promedio = 0;
		$calificaciones = CalificacionProducto::model()->findAllByAttributes(array('producto_id'=>$model->id));
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

	/*
	 * Action para que la usuaria le encante un producto
	 * 
	 * */
	public function actionAgregarFavorito(){
		if(Yii::app()->user->isGuest==false){ // si está logueado
			$like = UserFavoritos::model()->findByAttributes(array('user_id'=>Yii::app()->user->id,'producto_id'=>$_POST['idProd']));
				if(isset($like)){ // si ya le dio like
					$like->delete();
					//$total = UserEncantan::model()->countByAttributes(array('producto_id'=>$_POST['idProd']));  	
					echo CJSON::encode(array(
						'mensaje'=> 'borrado'
						//'total'=> $total
					));
					exit; 
				}
				else{ // esta logueado y es un like nuevo
				$favorito = new UserFavoritos;
				$favorito->producto_id = $_POST['idProd'];
				$favorito->user_id = Yii::app()->user->id;
				
				if($favorito->save()){
					//$total = UserEncantan::model()->countByAttributes(array('producto_id'=>$_POST['idProd']));  	
					echo CJSON::encode(array(
						'mensaje'=> 'ok'
						//'total'=> $total
					));
					exit;
				}
				}// else
			}
			else{
				echo CJSON::encode(array(
					'mensaje'=> 'no'
				));
			}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Producto::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='producto-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/*
	Action para importar los productos desde Magento
	*/
	public function actionImportar(){
			
			ini_set('memory_limit', '-1');

			$archivo = CUploadedFile::getInstancesByName('archivoCarga');
			$nombre = "";
			$extension = "";
			
			if (isset($archivo) && count($archivo) > 0) {
            	$nombreTemporal = "ProductosImportar";
                $rutaArchivo = Yii::getPathOfAlias('webroot').'/docs/productos/';
                foreach ($archivo as $arc => $xls) {

                        $nombre = $rutaArchivo.$nombreTemporal;
                        $extension = '.' . $xls->extensionName;
                        $uploadedFileName = $xls->name;
                        
						if ($xls->saveAs($nombre . $extension)) {

                        } else {
                            Yii::app()->user->updateSession();
                            Yii::app()->user->setFlash('error', UserModule::t("Error al cargar el archivo."));
                		}
					}
      		}else{
            	Yii::app()->user->updateSession();
                Yii::app()->user->setFlash('error', UserModule::t("Debes seleccionar un archivo."));                            
				$error = true;
			} 

	        // Si pasa la validacion
	     	if($nombre != "")
	     		$sheetArray = Yii::app()->yexcel->readActiveSheet($nombre . $extension);
					
			$i=0;
			$totalProductos = 0;

			if(isset($sheetArray)){
	           	//para cada fila del archivo
	           	foreach ($sheetArray as $row) {
					
	            	if ($row['A'] != "" && $row['A'] != "sku") { // para que no tome la primera ni vacios
						$i++; // fila
	               		$totalProductos++;

	               		$sku = $row['A'];
						$name = $row['B'];
	                    $metaTitle = $row['C'];
						$metaDescription = $row['D'];
	                    $url = $row['E'];
						$marca = $row['F'];
						$precio = $row['G'];
						$peso = $row['H'];
						$status = $row['I'];
						$descripcion = $row['J'];
						$descripcionCorta = $row['K'];
						$keywords = $row['L'];
						$cantidad = $row['M'];
						
						$producto = new Producto;
						$producto->nombre = $name;
						$producto->descripcion = $descripcion;
						$producto->destacado = 0;
						$producto->estado = $status;
						$producto->notificado = 1;
						$producto->interno = "por ahora";
						$producto->peso = $peso;
						$producto->codigo = $sku;

						// busqueda de la marca
						$marcaMayuscula = ucfirst($marca);

						$marcaBusqueda = Marca::model()->findByAttributes(array('nombre'=>$marcaMayuscula));
						if(isset($marcaBusqueda)){
							$producto->marca_id = $marcaBusqueda->id; // id de la marca conseguida
						}else{
							$nuevaMarca = new Marca;
							$nuevaMarca->nombre = $marcaMayuscula;
							$nuevaMarca->descripcion = "cambiar";
							$nuevaMarca->destacado = 0; // no

							if($nuevaMarca->save()){
								$producto->marca_id = $nuevaMarca->id;
							}
						}

						// guardar producto
						$producto->save(); // guardado

						// seo
						$seo = new Seo;
						$seo->descripcion = $metaDescription;
						$seo->tags = $keywords;
						$seo->amigable = $url;
						$seo->producto_id = $producto->save();

						$seo->save();
	                    
	              	}// if
				}// foreach			
				Yii::app()->user->setFlash("success", "Se ha cargado con éxito el archivo. Se han importado ".$totalProductos." producto(s)"); 	
			} // if
			ini_set('memory_limit', '32M');
			$this->render('importarProductos');
		}

	public function actionVerificarPadre()
	{
		$nombre=$_POST['nombre'];
		$model=ProductoPadre::model()->findByAttributes(array('nombre'=>$nombre));
		if($model)
			echo "1";
		else 
			echo "0";
		
		
	}
	
	public function actionVerificarNombre()
	{
		$nombre=$_POST['nombre'];
		$model=Producto::model()->findByAttributes(array('nombre'=>$nombre));
		if($model)
			echo "1";
		else 
			echo "0";
		
		
	}
	
	public function actionDetails($id = null)
	{
			//$GET['id'];
        if(!is_null($id)){
			$producto=Producto::model()->findByPk($id);
			$categoria=Categoria::model()->findByPk($producto->padre->idCategoria->id);
			$categoriaAtributo=CategoriaAtributo::model()->findAllByAttributes(array('categoria_id'=>$categoria->id, 'activo'=>1));
			$this->render('details',array(
				'producto'=>$producto,
				'categoria'=>$categoria,
				'categoriaAtributo'=>$categoriaAtributo,		
		));
		}else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}
	
    public function actionActivarDesactivar()
    {
        $id=$_POST['id'];
        $model = Producto::model()->findByPk($id);
        $model->estado=1-$model->estado;
        $model->save();
        echo $model->estado;
        
    }


}
