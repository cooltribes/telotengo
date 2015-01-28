<?php

class WishlistController extends Controller
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
				'actions'=>array('create','update','listado','add','modalchoose','agregar','crearagregar','productos','eliminarproducto','eliminar','enviarbolsa'),
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
	public function actionCreate()
	{
		if($_GET['id'])
			$model=Wishlist::model()->findByPk($_GET['id']);
		else
			$model=new Wishlist;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Wishlist']))
		{
			$model->attributes=$_POST['Wishlist'];
			$model->fecha = date('Y-m-d');
			
			if($model->save())
			{
				Yii::app()->user->setFlash('success',"Lista de deseos creada correctamente.");
				$this->redirect(array('listado'));
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

		if(isset($_POST['Wishlist']))
		{
			$model->attributes=$_POST['Wishlist'];
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
		$hasproductos = WishlistHasProducto::model()->findAllByAttributes(array('wishlist_id'=>$id));
		
		foreach($hasproductos as $eachone){
			$eachone->delete();
		}
			
		$this->loadModel($id)->delete();

		Yii::app()->user->setFlash('success',"Lista de deseos eliminada correctamente.");
		$this->redirect(array('admin'));
		
	}


	public function actionEliminar($id)
	{
		$hasproductos = WishlistHasProducto::model()->findAllByAttributes(array('wishlist_id'=>$id)); 
		
		foreach($hasproductos as $eachone){
			$eachone->delete();
		}
			
		$this->loadModel($id)->delete();

		Yii::app()->user->setFlash('success',"Lista de deseos eliminada correctamente.");
		$this->redirect(array('listado'));
		
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Wishlist');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	/**
	 * Agregar Wishlist.
	 */
	public function actionModalchoose()
	{
		
		$id = $_POST['id'];	
		$producto = Producto::model()->findByPk($id);
		$user = User::model()->findByPk(Yii::app()->user->id);
		$wishlist = Wishlist::model()->findAllByAttributes(array('users_id'=>$user->id));
			
		$datos="";
  		$datos=$datos.'<div class="modal-dialog">';
    	$datos=$datos.'<div class="modal-content">';
		
		$datos=$datos."	<div class='modal-header'>"; 
		$datos=$datos. "<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>";
		$datos=$datos."<h3 id='myModalLabel'> Agregar ";
		$datos=$datos. $producto->nombre;
		$datos=$datos." a una lista de deseos.</h3></div>";	
// fin del header

		$datos=$datos."<div class='modal-body'>";
		if(count($wishlist)>0){
			//listado con los wishlist
			$datos=$datos."<div><h4>Tus listas</h4>";
      		$datos=$datos."<table width='100%' border='0' cellspacing='0' cellpadding='0' class='table table-bordered table-condensed'>";
	        $datos=$datos."<tr>";
	        $datos=$datos."<th scope='row'>Nombre</th>";
			$datos=$datos."<th scope='row'>Fecha de creación</th>";
			$datos=$datos."<th scope='row'>Agregar</th>";
			$datos=$datos."</tr>";
			
			foreach($wishlist as $wish){
				$datos=$datos."<tr>";
				$datos=$datos."<td>".$wish->nombre."</td>";
				$datos=$datos."<td>".date('d/m/Y', strtotime($wish->fecha))."</td>";
				$datos=$datos."<td><button class='small btn btn-info' onclick='add(".$wish->id.",".$producto->id.",".$user->id.");'><span class='glyphicon glyphicon-heart'></span> Añadir a esta lista</button></td>";
		        $datos=$datos."</tr>";
			}
			$datos=$datos."</table></div>"; 
			
		}
		$datos=$datos."<hr/>";
		$datos=$datos."<div>O agregue este producto a una nueva lista</div>";

		$model = new Wishlist;
		
		/*$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
				'id'=>'new-wishlist-form',
				'action'=>Yii::app()->baseUrl.'/wishlist/crearagregar',
				'enableAjaxValidation'=>false,
				'enableClientValidation'=>true,
				'type'=>'horizontal',
				'clientOptions'=>array(
					'validateOnSubmit'=>true, 
				),
				'htmlOptions'=>array('class'=>'form-horizontal','role'=>"form"),
			));*/

		$datos .= '<form method="post" action="'.Yii::app()->baseUrl.'/wishlist/crearagregar'.'" id="new-wishlist-form" class="form-horizontal" role="form" enctype="multipart/form-data">';

		$datos=$datos.'<div class="form-group">';
		$datos=$datos.CHtml::activeLabel($model,'nombre');
		$datos=$datos.CHtml::activeTextField($model,'nombre',array('class'=>'form-control','maxlength'=>65));
		$datos=$datos.CHtml::error($model, 'nombre');
		$datos=$datos."</div>"; 
	
		$datos=$datos.CHtml::hiddenField('id_user', $user->id, array('id'=>'id_user'));
		$datos=$datos.CHtml::hiddenField('id_producto', $producto->id, array('id'=>'id_producto'));
		
		$datos=$datos."<button class='small btn btn-info'>Crear</button>";
		$datos=$datos."</div>";

		$datos=$datos."</form>";
		
		$datos=$datos."<hr/>";
		$datos=$datos."</div>";
		// fin del body
		
		$datos=$datos."<div class='modal-footer'>";
		$datos=$datos."</div>";	
		$datos=$datos."</div>";	
		$datos=$datos."</div>";

		echo $datos;
	}

	/**
	 * Agregar a Wishlist
	 */
	public function actionAgregar()
	{
		$wishlisthas = new WishlistHasProducto;
		$wishlisthas->wishlist_id = $_POST['id'];
		$wishlisthas->producto_id = $_POST['producto_id'];
		$wishlisthas->save();
		
		Yii::app()->user->setFlash('success',"Producto correctamente agregado a la lista de deseos.");
		
		echo "ok";		
	}
	
	/**
	 * Crear y agregar al nuevo wishlist
	 */
	public function actionCrearagregar() 
	{
		$wish = new Wishlist;
		$wish->nombre = $_POST['Wishlist']['nombre'];
		$wish->users_id = $_POST['id_user'];
		$wish->fecha = date('Y-m-d');
		
		if($wish->save()){
			$wishlisthas = new WishlistHasProducto;
			$wishlisthas->wishlist_id = $wish->id;
			$wishlisthas->producto_id = $_POST['id_producto']; 
			$wishlisthas->save();
			
			Yii::app()->user->setFlash('success',"Producto agregado a la nueva lista de deseos.");
		
			$this->redirect(array('wishlist/listado'));	
		}
		else{
			Yii::app()->user->setFlash('error',"Ingrese un nombre para la lista de deseos");
			$this->redirect(array('producto/detalle/'.$_POST['id_producto']));	
		}	
		
	}
	
	/**
	 * Listado de usuario
	 */
	public function actionListado()
	{
		$user = User::model()->findByPk(Yii::app()->user->id);
		
		$wishlist = new Wishlist;
		$wishlist->unsetAttributes();  // clear any default values
		$wishlist->users_id = $user->id;
		
		$dataProvider = $wishlist->search();
		
		$this->render('listado',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Wishlist('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Wishlist']))
			$model->attributes=$_GET['Wishlist'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Ver los productos asociados a un wishlist
	 */
	public function actionProductos($id)
	{
		$model = Wishlist::model()->findByPk($id);
		
		$wishlisthas = new WishlistHasProducto;
		$wishlisthas->wishlist_id = $id;
		
		$dataProvider = $wishlisthas->search();
		
		$this->render('productos',array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));		
	}

	/**
	 * Elimina el producto del wishlist
	 */
	public function actionEliminarproducto($id)
	{
			
		$wishlisthas = WishlistHasProducto::model()->findByPk($id);
		$wish = $wishlisthas->wishlist_id;
		$wishlisthas->delete();
		
		Yii::app()->user->setFlash('success',"Producto eliminado de la lista.");
		
		$this->redirect(array('productos','id'=>$wish));
	}

	/**
	 * Pasa el producto de Wishlist a Bolsa y redirecciona
	 */
	public function actionEnviarBolsa($id){
			
		$wishlisthas = WishlistHasProducto::model()->findByPk($id);
		
		$user = Yii::app()->user->id;
		$bolsa = Bolsa::model()->findByAttributes(array('users_id'=>$user));
		$inventario = Inventario::model()->findByAttributes(array('producto_id'=>$wishlisthas->producto_id));

		if(isset($bolsa)){ 
			$ag = new BolsaHasInventario; 
			$ag->bolsa_id = $bolsa->id;
			$ag->inventario_id = $inventario->id; 
			$ag->cantidad = 1;

			if($ag->save()){
				Yii::app()->user->setFlash('success', 'Se ha agregado correctamente el producto a la bolsa.');
			}else{
				Yii::trace('Wishlist a Bolsa: Wishlisthas '.$wishlisthas->id.' Error al pasar :'.print_r($detalle->getErrors(),true), 'Wish a Bolsa');
				Yii::app()->user->setFlash('error', 'Error al agregar.');
			}	
		} 
		else{ // no tenia bolsa aún
			$nueva = new Bolsa;
			$nueva->users_id = $user;
			$nueva->save();
			
			$ag = new BolsaHasInventario;
			$ag->bolsa_id = $nueva->id;
			$ag->inventario_id = $inventario->id; 
			$ag->cantidad = 1;
			
			if($ag->save()){
				Yii::app()->user->setFlash('success', 'Se ha agregado correctamente el producto a la bolsa.');
			}else{
				Yii::trace('Wishlist a Bolsa: Wishlisthas '.$wishlisthas->id.' Error al pasar :'.print_r($detalle->getErrors(),true), 'Wish a Bolsa');
				Yii::app()->user->setFlash('error', 'Error al agregar.');
			}
							
		}

		$wishlisthas->delete();
		$this->redirect(array('bolsa/view'));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Wishlist::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='wishlist-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
