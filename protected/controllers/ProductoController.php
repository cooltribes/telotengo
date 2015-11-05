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
								 'agregarInventarioAjax','eliminarInventario','multi','orden', 'clasificar', 'niveles', 'nivelPartial', 'crearProducto', 'autoComplete'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','update','eliminar','orden','aprobar','rechazar','poraprobar','calificaciones','eliminarCalificacion','importar','inventario', 'verificarPadre', 'verificarNombre', 'details', 'caracteristicas','activarDesactivar', 'activarDesactivarDestacado'),
				#'users'=>array('admin'),
				'roles'=>array('admin'),
			),
			array('allow', // COMPRADORESVENDEDORES Y VENDEDORES
				'actions'=>array('inventario', 'cargarInbound', 'productoInventario'),
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
	
	// seleccion entre crear o buscar
	public function actionSeleccion() 
	{
		if(isset($_POST['busqueda'])){
			Yii::app()->session['busquedaPalabra']="";
		    $producto = new Producto;
            $producto->unsetAttributes();     
            $producto->nombre = $_POST['busqueda'];        
            $dataProvider = $producto->busquedaSeleccion();
            Yii::app()->session['busquedaPalabra']=$_POST['busqueda'];      
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
			$nombreCategoria=$model->padre->idCategoria->nomenclatura;
			$cate=Categoria::model()->findByPk($model->padre->idCategoria->id_padre);
			$nombreCategoria=$model->padre->idCategoria->nomenclatura; 
			$model->tlt_codigo=$model->buscarPadre($cate->id).$cate->nomenclatura.$nombreCategoria.'-'.$model->id;

			$model->attributes=$_POST['Producto'];
            $model->setSeo();
			$model->fabricante=$_POST['Producto']['fabricante'];
			$model->annoFabricacion=$_POST['Producto']['annoFabricacion'];
			$model->upc=$_POST['Producto']['upc'];
			$model->ean=$_POST['Producto']['ean'];
			$model->gtin=$_POST['Producto']['gtin'];
			$model->nparte=$_POST['Producto']['nparte'];
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
						'costo' => $inventario->costo,
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
						'costo' => $inventario->costo,
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
					'costo' => $inventario->costo,
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
							'costo' => $inventario->costo,
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
			unset(Yii::app()->session['almacen_id']); 
			$id = $_GET['id'];
			$producto = Producto::model()->findByPk($id);
			$empresas_id = EmpresasHasUsers::model()->findByAttributes(array('users_id'=>Yii::app()->user->id))->empresas_id;
			$almacen_id=$producto->busquedaInventarioAlmacen($empresas_id);
			if($almacen_id=="")
			{
				$inventario = new Inventario;
			}
			else 
			{
				Yii::app()->session['almacen_id']=$almacen_id;	
				$inventario = Inventario::model()->findByAttributes(array('producto_id'=>$id, 'almacen_id'=>$almacen_id));
			}

		}
		else {
			$inventario = new Inventario;
			$id="";
			$producto = new Producto;
		}

		if(isset($_POST['Inventario'])){
			$inventario->almacen_id = $_POST['Inventario']['almacen_id'];
			$inventario->producto_id = $_POST['Inventario']['producto_id'];
			
			if(isset(Yii::app()->session['almacen_id']))
			{
				/*echo $inventario->almacen_id."///";
				echo Yii::app()->session['almacen_id'];
				Yii::app()->end();*/
				
				if($inventario->almacen_id!=Yii::app()->session['almacen_id']) // si elegio guardar la informacion en otro almacen
				{	
					if(Inventario::model()->findByAttributes(array('producto_id'=>$_POST['Inventario']['producto_id'], 'almacen_id'=>$_POST['Inventario']['almacen_id']))) // si existe el registro
						$inventario=Inventario::model()->findByAttributes(array('producto_id'=>$_POST['Inventario']['producto_id'], 'almacen_id'=>$_POST['Inventario']['almacen_id']));
					else 
						$inventario = new Inventario;
					
					$inventario->almacen_id = $_POST['Inventario']['almacen_id'];
					$inventario->producto_id = $_POST['Inventario']['producto_id'];
				}
			}
			
			$inventario->attributes = $_POST['Inventario'];
			$inventario->sku = $_POST['Inventario']['sku'];
			//$inventario->numFabricante = $_POST['Inventario']['numFabricante'];
			$inventario->condicion = $_POST['Inventario']['condicion'];
			$inventario->notaCondicion = $_POST['Inventario']['notaCondicion'];
			
			if($inventario->condicion=="nuevo")
				$inventario->notaCondicion = "";
			
			$inventario->costo = $_POST['Inventario']['costo'];
			$inventario->cantidad = $_POST['Inventario']['cantidad'];
			$inventario->garantia = $_POST['Inventario']['garantia'];
			//$inventario->metodoEnvio = $_POST['Inventario']['metodoEnvio'];
			


			
			//$producto->saveAttributes(array('estado'=>1));

			if($inventario->save())	
				Yii::app()->user->setFlash('success',"Inventario guardado exitosamente. El producto está ahora activo.");
		}
		
		$this->render('inventario',array(
			'producto'=>$producto,
			'model'=>$inventario,
			'empresas_id'=>$empresas_id,
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
	
	public function actionProductoInventario()
	{	
		$model = new Producto;
		$model->unsetAttributes();  // clear any default values
		$bandera=false;
		$dataProvider = $model->busquedaInventario();

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
            $dataProvider = $model->busquedaInventario($_POST['query']);
        }	

        if($bandera==FALSE){
			unset($_SESSION['searchBox']);
        }

		if(isset($_GET['Producto']))
			$model->attributes=$_GET['Producto'];

		$this->render('productoInventario',array(
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
		$data=array();
		$connection = new MongoClass();
		if(Funciones::isDev())
		{
			$document = $connection->getCollection('ejemplo');	//DEVELOP
		}	
		else
		{

			$document = $connection->getCollection('stage');	//STAGE
		} 
			

		
		if(count($_POST)>0)
		{
			
			foreach($_POST as $key=>$aso)
			{
					if($aso!=""&& strpos($key,"*-*")=== false)
					{
						#echo $key." ".$aso." ";
						if($aso!="opcion-vacia") // si viene la opcion del select
							$data[$key]=$aso;
						if(isset($_POST[$key."*-*UNIDAD"]))
						{
							#echo $_POST[$key."*-*UNIDAD"]."</br>";
							$data[$key."*-*UNIDAD"]=$_POST[$key."*-*UNIDAD"];
						}
							
					}						
			}
			$data['producto']=$id;

					
			$prueba = array("producto"=>$id); 
			$user = $document->findOne($prueba); // vamos a buscar si existe el registro
			
			if($user==NULL) // si no existe el registro, inserte uno nuevo
			{
				$document->insert($data); // insertar el registro
			}
			else // en caso de que exista el registro, substituyalo
			{
				$document->remove(array("producto"=>$id));	//quito la coleccion
				//$existente=$document->update(array("producto"=>$id), array('$set'=>$data));
				$document->insert($data); //inserto un nuevo registro
			}
			//var_dump($user);
			//var_dump($existente);
			//var_dump($data);
			Yii::app()->user->setFlash('success', 'Se han cargado los datos con exito');
			//$this->render('admin');
			$this->redirect(array('admin'));
		}
		 

			//$GET['id'];
        if(!is_null($id)){

        	$prueba = array("producto"=>$id); 
			$busqueda = $document->findOne($prueba); 
			
			$producto=Producto::model()->findByPk($id);
			$categoria=Categoria::model()->findByPk($producto->padre->idCategoria->id);
			$categoriaAtributo=CategoriaAtributo::model()->findAllByAttributes(array('categoria_id'=>$categoria->id, 'activo'=>1));
			//var_dump($busqueda);
			$this->render('details',array(
				'producto'=>$producto,
				'categoria'=>$categoria,
				'categoriaAtributo'=>$categoriaAtributo,
				'busqueda'=>$busqueda		
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
	
	public function actionAutocomplete()
	{
	    	$res =array();
	    	if (isset($_GET['term'])) 
			{
				$qtxt ="SELECT nombre FROM tbl_producto WHERE nombre LIKE :nombre and estado=1";
				$command =Yii::app()->db->createCommand($qtxt);
				$command->bindValue(":nombre", '%'.$_GET['term'].'%', PDO::PARAM_STR);
				$res =$command->queryColumn();
	    	}
	     	echo CJSON::encode($res);
	    	Yii::app()->end();
	}
	
	public function actionActivarDesactivarDestacado()
	{
		$id=$_POST['id'];
        $model = Producto::model()->findByPk($id);
        $model->destacado=1-$model->destacado;
        $model->save();
        echo $model->destacado;
	}
	
	public function actionCargarInbound()
	{
		    $nuevos = 0;
            $actualizados = 0;
            $uploadedFileName = "";
            $error = false;    	
			ini_set('memory_limit', '-1');
			ini_set('max_execution_time', 300);
			
			/*			echo "wolfre";
			Yii::app()->end();*/
			            /*Segundo paso - Validar el archivo*/
            if(isset($_POST["validar"]))
            {
                $archivo = CUploadedFile::getInstancesByName('archivoValidacion');
                
                //Guardarlo en el servidor para luego abrirlo y revisar
                if (isset($archivo) && count($archivo) > 0) {
                    foreach ($archivo as $arc => $xls) {
                        $nombre = Yii::getPathOfAlias('webroot') . '/docs/xlsMasterData/' . "Temporal";
                        $extension = '.' . $xls->extensionName;                     
                        $uploadedFileName = $xls->name;
                        if (!$xls->saveAs($nombre . $extension)){
                            Yii::app()->user->updateSession();
                            Yii::app()->user->setFlash('error', UserModule::t("Error al cargar el archivo."));                            
                        }
                    }
                }else{
                    Yii::app()->user->updateSession();
                    Yii::app()->user->setFlash('error', UserModule::t("Debes seleccionar un archivo."));                            
                    $error = true;
                }              
				echo $extension;
                //Si no hubo errores
                if(!$error && is_array($resValidacion = $this->validarInbound($nombre . $extension))){

                    Yii::app()->user->updateSession();
                    Yii::app()->user->setFlash('success', "<h4>".Yii::app()->session['actualizaciones']."
                            Éxito! El archivo no tiene errores,
                            puedes continuar con el siguiente paso.</h4><br>
                                
                            Nombre del archivo: <b>$uploadedFileName</b>.<br>
                            Productos que contiene: <b>{$resValidacion['nProds']}</b>.");                    
                }
				 //Tercer paso - Subir el Archivo
              }elseif(isset($_POST["cargar"]))
              {
				$archivo = CUploadedFile::getInstancesByName('archivoCarga');
                           
                    if (isset($archivo) && count($archivo) > 0) {
                        $nombreTemporal = "Archivo";
                        $rutaArchivo = Yii::getPathOfAlias('webroot').'/docs/xlsMasterData/';
                        foreach ($archivo as $arc => $xls) {

                            $nombre = $rutaArchivo.$nombreTemporal;
                            $extension = '.' . $xls->extensionName;
                            
                            if ($xls->saveAs($nombre . $extension)) {
                                
                            } else {
                                Yii::app()->user->updateSession();
                                Yii::app()->user->setFlash('error', UserModule::t("Error al cargar el archivo."));
                                $this->render('importar_productos', array(
                                    'tabla' => $tabla,
                                    'total' => $total,
                                    'actualizar' => $actualizar,
                                    'totalInbound' => $totalInbound,
                                    'actualizadosInbound' => $actualizadosInbound,
                                ));
                                Yii::app()->end();
                                
                            }
                        }
                    }
                    
                    // ==============================================================================

                    // Validar (de nuevo)
                    if( !is_array($resValidacion = $this->validarArchivo($nombre . $extension)) ){
                        // Archivo con errores, eliminar del servidor
                        unlink($nombre . $extension);
							$this->render('cargarInbound', array(                
			                'fileName' => $uploadedFileName,
			                'nuevos' => $nuevos,
			                'actualizados' => $actualizados,               
			            ));

						Yii::app()->end();
                    }

				 $sheetArray = Yii::app()->yexcel->readActiveSheet($nombre . $extension);
				    
				    $fila = 1;
                    $totalCantidades = 0;
					
					// variable para los ids de ptc
					$combinaciones = array();
                    foreach ($sheetArray as $row){ 
                        if($fila > 1){
                        	
						                     		
                     	$sku=$row['A'];
						$condicion=$row['B'];
						$cantidad=$row['E'];
						$garantia=$row['F'];
						$almacen=$row['G'];
					    $tipoCodigo=$row['H'];
						$codigo=$row['I']; 
						$almacenCopy="";
						$producto="";
						$empresa=EmpresasHasUsers::model()->findByAttributes(array('users_id'=>Yii::app()->user->id));
						
						if(explode(",", $row['C']))
						{
							$partir=explode(",", $row['C']);
							if(isset($partir[1]))
								$row['C']=$partir[0].".".$partir[1];
						}
						$costo=$row['C'];
						
						if(explode(",", $row['D']))
						{
							$partir=explode(",", $row['D']);
							if(isset($partir[1]))
								$row['D']=$partir[0].".".$partir[1];
						}
						$precio=$row['D'];
						
						if($sku!="")
						{
							
							$almacenes=Almacen::model()->findByAttributes(array('alias'=>$almacen));	
							if($tipoCodigo!="" && $codigo!="") // cuando no existe y lo va a relacionar con un sku
							{
								if($row['H']=="TLT")
									if(Producto::model()->findByAttributes(array('tlt_codigo'=>$row['I'])))
										$producto=Producto::model()->findByAttributes(array('tlt_codigo'=>$row['I']))->id;	
											
									if($row['H']=="UPC")
										if(Producto::model()->findByAttributes(array('upc'=>$row['I'])))	
											$producto=Producto::model()->findByAttributes(array('upc'=>$row['I']))->id;	
										
									if($row['H']=="EAN")	
										if(Producto::model()->findByAttributes(array('ean'=>$row['I'])))
											$producto=Producto::model()->findByAttributes(array('ean'=>$row['I']))->id;	
										
									if($row['H']=="GTIN")	
										if(Producto::model()->findByAttributes(array('gtin'=>$row['I'])))
											$producto=Producto::model()->findByAttributes(array('gtin'=>$row['I']))->id;	
										
									if($row['H']=="NPF")
										if(Producto::model()->findByAttributes(array('nparte'=>$row['I'])))
											$producto=Producto::model()->findByAttributes(array('nparte'=>$row['I']))->id;	
									
								$inventario= new Inventario;
								$inventario->sku=$sku;
								$inventario->condicion=$condicion;
								$inventario->costo=$costo;
								$inventario->cantidad=$cantidad;
								echo $inventario->precio=$precio;
								$inventario->garantia=$garantia;
								$inventario->almacen_id=$almacenes->id;
								$inventario->producto_id=$producto;
								
								if(!$inventario->save())
								print_r($inventario->errors);
							}
							else //la forma normal
							{
								// si esta sustituyendo uno creado	
								if($inventario=Inventario::model()->findByAttributes(array('sku'=>$sku, 'almacen_id'=>$almacenes->id)))
								{
									$inventario=Inventario::model()->findByAttributes(array('sku'=>$sku, 'almacen_id'=>$almacenes->id));
									$inventario->condicion=$condicion;
									$inventario->costo=$costo;
									$inventario->cantidad=$cantidad;
									$inventario->precio=$precio;
									$inventario->garantia=$garantia;
								
								}
								else 
								{
									// si tiene en otro almacen el producto previamente, pero quiere crearlo en uno distinto
									$inven=Inventario::model()->findAllByAttributes(array('sku'=>$sku));
									foreach($inven as $invent)
									{
										if($invent->almacen->empresas_id==$empresa->empresas_id)
										{

											$producto=$invent->producto_id;
											
										}
									}	
									echo $empresa->empresas_id; 
									$inventario= new Inventario;
									$inventario->sku=$sku;
									$inventario->condicion=$condicion;
									$inventario->costo=$costo;
									$inventario->cantidad=$cantidad;
									$inventario->precio=$precio;
									$inventario->garantia=$garantia;
									$inventario->almacen_id=$almacenes->id;
									$inventario->producto_id=$producto;
									
								}
									$inventario->save();


								
							}
						}

                        }
                        $fila++;                        
                    } // foreach
				 
              }
              
				
			$this->render('cargarInbound', array(                
                'fileName' => $uploadedFileName,
                'nuevos' => $nuevos,
                'actualizados' => $actualizados,               
            ));
           
	}


	        protected function validarInbound($archivo){
            
            //Validar las columnas normales primero
            $response = $this->validarArchivo($archivo, 1);
            $errores = "";
            if(is_array($response)){
                //si son validas todas
                
            }else{
                //si hubo errores, capturarlos.
                $errores = Yii::app()->user->getFlash("error");
            }
            
            //VALIDAR LAS COLUMNAS RESTANTES
            $sheetArray = Yii::app()->yexcel->readActiveSheet($archivo);
            
            $erroresColumnasVacias = "";
            $erroresTienda = "";
            $erroresSku = "";

            
            $falla = "";
            $linea = 0;
            
            foreach ($sheetArray as $row) {
                
                $linea++;
                
                if(!isset($row['A']) || $row['A'] == ""){
                    continue;
                }
                
                if ($linea == 1) { // revisar los nombres / encabezados de las columnas

                    if ($falla != "") { // algo falló O:
                        Yii::app()->user->updateSession();
                        Yii::app()->user->setFlash('error', UserModule::t("La columna <b>" .
                                        $falla . "</b> no se encuentra en el lugar que debe ir o está mal escrita."));                                   

                        return false;
                    }
                }

                if($linea > 1){  
                      
                    //Revisar celdas vacias
                    if(!isset($row['A']) || $row['A'] == ""){                            
                            $erroresColumnasVacias.= "<li> Columna: <b>" . "A" .
                                    "</b>, en la línea <b>" . $linea."</b></li>";                                
                    }


                    //Referencias existentes                        
                    if (isset($row['B']) && $row['B'] != "") 
                    {                        
                        
                       
                        

                    }                        
                    //SKU existentes                        
                    if (isset($row['A']) && $row['A'] != "") 
                    {                        
                        

                    }                        
                        
                }                                        
                
                
            }
            
            //si hubo celdas vacias
            if($erroresColumnasVacias != ""){
                $erroresColumnasVacias = "Las siguientes Columnas están vacías:<br><ul>
                                 {$erroresColumnasVacias}
                                 </ul><br>";
            }            
            if($erroresTienda != ""){
                $erroresTienda = "Las siguientes Tiendas no existen en la plataforma o están mal escritas:<br><ul>
                                 {$erroresTienda}
                                 </ul><br>";
            }
            if($erroresSku != ""){
                $erroresSku = "Los siguientes Productos ya existen en la plataforma
                    como Catálogo Personaling:<br><ul>
                                 {$erroresSku}
                                 </ul><br>";
            }
            
            $errores .= $erroresColumnasVacias . $erroresTienda . $erroresSku;
           
            if($errores != ""){
                
                Yii::app()->user->updateSession();
                Yii::app()->user->setFlash('error', $errores);

                return false;                
            }             
            
            //No hubo errores.
            return $response; 
            
            
        }




		        /**
         * 
         * @param type $archivo Archivo que se valida
         * @param type $tipoProductos 1: si el archivo es de productos externos
         *                            0: si el archivo contiene productos personaling
         * @return boolean Si el archivo es valido o no
         */
        protected function validarArchivo($archivo, $tipoProductos = 0){
            
            $sheet_array = Yii::app()->yexcel->readActiveSheet($archivo);

            $skuRepetidos = array();
			$combinacionesRepetidas= array();
            $falla = "";
            $erroresMarcas = "";
            $erroresCategorias = "";
            $erroresCatRepetidas = "";
            $erroresCatVacias = "";
            $erroresTallas = "";
            $erroresColores = "";
            $erroresPeso = "";
            $erroresCosto = "";
            $erroresPrecio = "";
            $erroresColumnasVacias = "";
            $erroresSku = "";
			$erroresSkuTodaAplicacion = "";
            $erroresSkuRepetidos= "";
			$erroresTallaColorRepetidos="";
			$referenciasActualizadas="";
			$skuActualizados="";
			$referenciasNuevas="";
			$skuNuevos="";
			
			$erroresTipoCodigo="";
			$erroresCodigo="";
			$erroresCondicion="";
			$erroresCantidadVender="";
			$erroresAlmacen="";
			$erroresSkuLocal="";
			
            $linea = 1;
            $lineaProducto = 0;
			$entro=0; $entro2=0;
			$contadorReferenciasActualizadas=0;
			$contadorSkuActualizados=0;
			$contadorReferenciasNuevas=0;  
			$contadorSkuNuevos=0;          
            
            //Revisar cada fila de la hoja de excel.
            foreach ($sheet_array as $row) {

                if ($row['A'] != "") 
                {
                	//var_dump(memory_get_usage());	
                    if ($linea == 1) 
                    { // revisar los nombres / encabezados de las columnas
                       
						if(isset($row['A']))
						{
							if($row['A'] != "SKU" )
								$falla = "SKU";
						}
						else
						{
							$falla = "SKU";
						}
						if(isset($row['B']))
						{
							if($row['B'] != "Condicion" )
								$falla = "Condicion";
						}
						else
						{
							$falla = "Condicion";
						}
						if(isset($row['C']))
						{
							if($row['C'] != "Costo" )
								$falla = "Costo";
						}
						else
						{
							$falla = "Costo";
						}
						if(isset($row['D']))
						{
							if($row['D'] != "Precio" )
								$falla = "Precio";
						}
						else
						{
							$falla = "Precio";
						}
						if(isset($row['E']))
						{
							if($row['E'] != "Cantidad a vender" )
								$falla = "Cantidad a vender";
						}
						else
						{
							$falla = "Cantidad a vender";
						}
                        if(isset($row['F']))
						{
							if($row['F'] != "Garantia" )
								$falla = "Garantia";
						}
						else
						{
							$falla = "Garantia";
						}
						if(isset($row['G']))
						{
							if($row['G'] != "Almacen" )
								$falla = "Almacen";
						}
						else
						{
							$falla = "Almacen";
						}
						if(isset($row['H']))
							{
								if($row['H'] != "Tipo de Codigo" )
									$falla = "Tipo de Codigo";
							}
							else
							{
								$falla = "Tipo de Codigo";
							}
							if(isset($row['I']))
							{
								if($row['I'] != "Codigo" )
									$falla = "Codigo";
							}
							else
							{
								$falla = "Codigo";
							}
					 
               

                        if ($falla != "") { // algo falló O:
                       
                            Yii::app()->user->updateSession();
                            Yii::app()->user->setFlash('error', UserModule::t("La columna <b>" .
                                            $falla . "</b> no se encuentra en el lugar que debe ir o está mal escrita.<br><br>"));                                   

                            return false;
                        }
                    }

                    /*si pasa las columnas entonces revisar
                    Marcas, categorias, tallas y colores.. y todo lo demas.*/                          
                    if($linea > 1){
                        	
                        $categoriasRepetidas = array();
                        $cantCategorias = 0;           

                        /*Columnas Vacias*/
                        foreach ($row as $col => $valor){
                            if(!($col=="C" || $col=="F" || $col=="H" || $col=="I")) /// no revise esas columnas
							{
								if(!isset($valor) || $valor == ""){
                                $erroresColumnasVacias.= "<li> Columna: <b>" . $col .
                                        "</b>, en la línea <b>" . $linea."</b></li>";
                           		 }
							}

                            
                            if($col == "P"){
                                break;
                            }
                        }
						
						 $sku_revisar=$row['A'];
						 $empresa_id=EmpresasHasUsers::model()->findByAttributes(array('users_id'=>Yii::app()->user->id))->empresas_id;
						 $sku_revisar;
						 $sql="select * from tbl_inventario where sku= '".$sku_revisar."' and almacen_id in (select id from tbl_almacen where empresas_id=".$empresa_id.")";
						 $inventario=Yii::app()->db->createCommand($sql)->queryAll();
						 count($inventario);
						 
						if(count($inventario)==0) // si el sku propio no existe
						{
							$errorLocal=0;
							if($row['H']=="")
							{
								 $erroresTipoCodigo.= "<li> Tipo de Codigo - <b> Vacio </b>, en la línea <b>" . $linea."</b></li>";
								 if($errorLocal==0)
								 {
								 	$erroresSkuLocal.= "<li> Sku  - <b> no existe debe crear codigo y tipo de codigo existentes </b>, en la línea <b>" . $linea."</b></li>";
									$errorLocal++;
								 }
								 	
							}
							else   
							{
								if(!($row['H']=="TLT" || $row['H']=="UPC" || $row['H']=="EAN" || $row['H']=="GTIN" || $row['H']=="NPF")) // si no es ninguna de estas opciones
								{
									$erroresTipoCodigo.= "<li> Tipo de Codigo - <b> No corresponde a las opciones establecidas </b>, en la línea <b>" . $linea."</b></li>";
									if($errorLocal==0)
									 {
								 		$erroresSkuLocal.= "<li> Sku  - <b> no existe debe crear codigo y tipo de codigo existentes </b>, en la línea <b>" . $linea."</b></li>";
										$errorLocal++;
								 	}
								}

							}
							if($row['I']=="")
							{
								$erroresCodigo.= "<li> Codigo - <b> Vacio </b>, en la línea <b>" . $linea."</b></li>";
								if($errorLocal==0)
								 {
								 	$erroresSkuLocal.= "<li> Sku  - <b> no existe debe crear codigo y tipo de codigo existentes </b>, en la línea <b>" . $linea."</b></li>";
									$errorLocal++;
								 }	
							}
							else 
							{
								if($errorLocal==0)
								{
									$entro=0; // necesita entrar para no mostrar error
									
									if($row['H']=="TLT")
										if(Producto::model()->findByAttributes(array('tlt_codigo'=>$row['I'])))
											$entro=1;
											
									if($row['H']=="UPC")
										if(Producto::model()->findByAttributes(array('upc'=>$row['I'])))	
											$entro=1;
										
									if($row['H']=="EAN")	
										if(Producto::model()->findByAttributes(array('ean'=>$row['I'])))
											$entro=1;
										
									if($row['H']=="GTIN")	
										if(Producto::model()->findByAttributes(array('gtin'=>$row['I'])))
											$entro=1;
										
									if($row['H']=="NPF")
										if(Producto::model()->findByAttributes(array('nparte'=>$row['I'])))
											$entro=1;	
								
									if($entro==0)
										$erroresCodigo.= "<li> ".$row['I']. "- <b> no corresponde a ".$row['H']."</b>, en la línea <b>" . $linea."</b></li>";
								}	

							}
							
							
							
									
						}
		       
                        if($skuRepetidos!="")
						{
							$entro=0;	
							foreach($skuRepetidos as $skuLocal)
							{
								$dividir=explode("/", $skuLocal);
								if(($dividir[0]==$row['A'] && $dividir[1]==$row['G']) && $entro==0)
								{
									$erroresSkuRepetidos .= "<li> <b>" . $row['A'] . "</b>, en la línea <b>" . $linea."</b></li>";
									$entro=1;
								}
							}
						}
						array_push($skuRepetidos, $row['A']."/".$row['G']);
						
						
						if(!($row['B']=="Nuevo" || $row['B']=="Usado" || $row['B']=="Refabricado")) // si no es ninguna de estas opciones
						{
							$erroresCondicion.= "<li> Condicion - <b> No corresponde a las opciones establecidas </b>, en la línea <b>" . $linea."</b></li>";
						}
						
						if($row['C']!="")// si coloca costo
						{
								
							if(explode(",", $row['C']))
							{
								$partir=explode(",", $row['C']);
								if(isset($partir[1]))
									$row['C']=$partir[0].".".$partir[1];
								if(!(is_numeric($row['C'])))
								{
									$erroresCosto .= "<li> Costo - <b>".$row['C']."</b>, en la línea <b>" . $linea."</b></li>";
								} 
							}
							else 
							{
								if(!(is_numeric($row['C']))) 
								{
									$erroresCosto .= "<li> Costo - <b>".$row['C']."</b>, en la línea <b>" . $linea."</b></li>";
								}
							}

						}
						
							if(explode(",", $row['D'])) // Validacion de Precios
							{
								$partir=explode(",", $row['D']);
								if(isset($partir[1]))
									$row['D']=$partir[0].".".$partir[1];
								if(!(is_numeric($row['D'])))
								{
									$erroresPrecio .= "<li> Precio - <b>".$row['D']."</b>, en la línea <b>" . $linea."</b></li>";
								} 
							}
							else 
							{
								if(!(is_numeric($row['D']))) 
								{
									$erroresPrecio .= "<li> Precio - <b>".$row['D']."</b>, en la línea <b>" . $linea."</b></li>";
								}
							}
							
							if(!(is_numeric($row['E']))) 
							{
								$erroresCantidadVender .= "<li> Precio - <b>".$row['E']."</b>, en la línea <b>" . $linea."</b></li>";
							}
							
							///validar almacen
							
							if($row['G']!="")
							{
								if(!Almacen::model()->findByAttributes(array('alias'=>$row['G'], 'empresas_id'=>$empresa_id)))
								{
									$erroresAlmacen.="<li> Almacen- <b>".$row['G']."</b>, en la línea <b>" . $linea."</b></li>";
								}
							}
							
							
                        $lineaProducto++;
                    }
                    
                }

                $linea++;
            }
            

            //Si hubo errores en marcas, cat, tallas, colores
            if($erroresColumnasVacias != ""){
                $erroresColumnasVacias = "Las siguientes Columnas están vacías:<br><ul>
                                 {$erroresColumnasVacias}
                                 </ul><br>";
            }
            if($erroresCategorias != ""){
                $erroresCategorias = "Las siguientes Categorías no existen en la plataforma o están mal escritas:<br><ul>
                                 {$erroresCategorias}
                                 </ul><br>";
            }
            if($erroresCatRepetidas != ""){
                $erroresCatRepetidas = "Las siguientes Categorías están repetidas para el mismo producto:<br><ul>
                                 {$erroresCatRepetidas}
                                 </ul><br>";
            }
            if($erroresCatVacias != ""){
                $erroresCatVacias = "Los siguientes productos deben tener al menos dos (2) categorías asociadas:<br><ul>
                                 {$erroresCatVacias}
                                 </ul><br>";
            }
            if($erroresMarcas != ""){
                $erroresMarcas = "Las siguientes Marcas no existen en la plataforma o están mal escritas:<br><ul>
                                 {$erroresMarcas}
                                 </ul><br>";
            }
            if($erroresTallas != ""){
                $erroresTallas = "Las siguientes Tallas no existen en la plataforma o están mal escritas:<br><ul>
                                 {$erroresTallas}
                                 </ul><br>";
            }
            if($erroresColores != ""){
                $erroresColores = "Los siguientes Colores no existen en la plataforma o están mal escritos:<br><ul>
                                 {$erroresColores}
                                 </ul><br>";
            }
            
            //Errores numericos
            if($erroresPeso != ""){
                $erroresPeso = "Los siguientes Pesos están mal escritos, recuerde usar coma (,):<br><ul>
                                 {$erroresPeso}
                                 </ul><br>";
            }
            if($erroresCosto != ""){
                $erroresCosto = "Los siguientes Costos están mal escritos, recuerde usar coma (,):<br><ul>
                                 {$erroresCosto}
                                 </ul><br>";
            }
            if($erroresPrecio != ""){
                $erroresPrecio = "Los siguientes Precios están mal escritos, recuerde usar coma (,):<br><ul>
                                 {$erroresPrecio}
                                 </ul><br>";
            }
            
            if($erroresSku != ""){
                $erroresSku = "Los siguientes Productos ya existen en la plataforma como Catálogo Externo:<br><ul>
                                 {$erroresSku}
                                 </ul><br>";
            }
            if($erroresSkuRepetidos != ""){
                $erroresSkuRepetidos = "Los siguientes SKU Y Almacenes estan repetidos:<br><ul>
                                 {$erroresSkuRepetidos}
                                 </ul><br>";
            }
            if($erroresSkuTodaAplicacion != ""){
               					 $erroresSkuTodaAplicacion = "Los siguientes SKU no corresponden a las Referencias:<br><ul>
                                 {$erroresSkuTodaAplicacion}
                                  </ul><br>";
            }
             if($erroresTallaColorRepetidos != ""){
               					 $erroresTallaColorRepetidos = "Las Siguientes Combinaciones de Referencia Talla y Color ya estan repetidas :<br><ul>
                                 {$erroresTallaColorRepetidos}
                                  </ul><br>";
            }
             if($erroresTipoCodigo != ""){
               					 $erroresTipoCodigo = "Hay errores en el campo Tipo de Codigo :<br><ul>
                                 {$erroresTipoCodigo}
                                  </ul><br>";
            }
            if($erroresCodigo != ""){
               					 $erroresCodigo = "Hay errores en el campo Codigo :<br><ul>
                                 {$erroresCodigo}
                                  </ul><br>";
            }
			if($erroresCondicion != ""){
               					 $erroresCondicion = "Hay errores en el campo Condicion :<br><ul>
                                 {$erroresCondicion}
                                  </ul><br>";
            }
            
			if($erroresCantidadVender != ""){
                $erroresCantidadVender = "La Cantidad a vender debe ser un numero entero:<br><ul>
                                 {$erroresCantidadVender}
                                 </ul><br>";
            }
            if($erroresAlmacen != ""){
                $erroresAlmacen = "Los Siguientes Almacenes no existen o estan mal escritos:<br><ul>
                                 {$erroresAlmacen}
                                 </ul><br>";
            }
			
			 if($erroresSkuLocal != ""){
                $erroresSkuLocal = "Los siguientes sku no existen y se debe indicar un codigo y un Tipo de codigo:<br><ul>
                                 {$erroresSkuLocal}
                                 </ul><br>";
            }
			
			
			
            
            /////////////////////////////////los siguientes mensajes no son errores////////////////////////////////////////////////////
            if($referenciasActualizadas != ""){
               					 $referenciasActualizadas = "Seran actualizadas ".$contadorReferenciasActualizadas." Referencias :<br><ul>
                                 {$referenciasActualizadas}
                                  </ul><br>";
            }
            
            if($referenciasNuevas != ""){
               					 $referenciasNuevas = "Seran creadas ".$contadorReferenciasNuevas." Referencias :<br><ul>
                                 {$referenciasNuevas}
                                  </ul><br>";
            }
            if($skuActualizados!= ""){
               					 $skuActualizados = "Seran actualizados ".$contadorSkuActualizados." Sku :<br><ul>
                                 {$skuActualizados}
                                  </ul><br>";
            }
			if($skuNuevos!= ""){
               					 $skuNuevos = "Seran creados ".$contadorSkuNuevos." Sku :<br><ul>
                                 {$skuNuevos}
                                  </ul><br>";
            }
			
			Yii::app()->session['actualizaciones']=$referenciasActualizadas.$referenciasNuevas.$skuActualizados.$skuNuevos; 
			
			//////////////////////////////////////////////////////hasta aqui////////////////////////////////////////////////////////////
                
            $errores = $erroresTallas .$erroresColores . $erroresMarcas .
                    $erroresCatRepetidas. $erroresCategorias . $erroresCatVacias.
                    $erroresPrecio . $erroresCosto . $erroresPeso .
                    $erroresColumnasVacias . $erroresSku . $erroresSkuRepetidos. $erroresSkuTodaAplicacion. $erroresTallaColorRepetidos. 
					$erroresTipoCodigo. $erroresCodigo.$erroresCondicion. $erroresCantidadVender.$erroresAlmacen.$erroresSkuLocal;
            
            if($errores != ""){
                
                Yii::app()->user->updateSession();
                Yii::app()->user->setFlash('error', $errores);

                return false;                
            }
            
            return array(
                "valid"=>true,
                "nProds"=>$lineaProducto,
                "nLineas"=>$linea-2,
                );            
        }


}
