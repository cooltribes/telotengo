<?php

class ControlPanelController extends Controller
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
				'actions'=>array('index'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(''),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin', 'adminUsuarios'),
				'users'=>array('admin'), 
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	/*public function actionAdmin() ////viejo
	{
		$empresas = Empresas::model()->findAll(array('order' => 'id'));
		$mensaje = new Mensajes;
		$nuevomensaje = new Mensajes;
		
		if(isset($_POST['Mensajes'])){
			$nuevomensaje->attributes = $_POST['Mensajes'];
			$nuevomensaje->from_id = Yii::app()->user->id;
			$nuevomensaje->to_id = $_POST['empresa'];
			$nuevomensaje->fecha = date('Y-m-d H:i:s');
			$nuevomensaje->estado = 0; // sin leer
			
			if($nuevomensaje->save())
				Yii::app()->user->setFlash('success',"Email enviado exitosamente.");
			else
				Yii::app()->user->setFlash('error',"No enviado.");
				
		}
			
		$this->render('admin',array('empresas'=>$empresas,'mensaje'=>$mensaje));
	}*/

	public function actionAdminUsuarios()
	{
		$fechaIni="";
		$fechaFinal="";
		if($_GET)
		{
			$fechaFinal=$_GET['fechaFinal'];
			$fechaIni=$_GET['fechaIni'];
		}
		else
		{
			$fechaFinal=date('Y-m-d');
			$fechaIni=date('Y-m-d', strtotime('-1 month'));
		}

		/////////////////////////////////////////Contador///////////////////////////////////////////////////////////////////
		$sql="select sum(u.ingresos) as ing from tbl_users u join tbl_authAssignment asi on  u.id= asi.userid where asi.itemname<>'admin'";
		$sumatoria=Yii::app()->db->createCommand($sql)->queryRow();
		$sumatoria=$sumatoria['ing'];

		///////////////////////////////////////////////Todos los usuarios///////////////////////////////////////////////////////////////////
		$sql="select * from tbl_users u join tbl_authAssignment asi on  u.id= asi.userid where asi.itemname<>'admin'";
		$todosUsers=count(Yii::app()->db->createCommand($sql)->queryAll());
		////////////////////////////////////////////////////Usuarios Activos/////////////////////////////////////////////
		$sql="select * from tbl_users u join tbl_authAssignment asi on  u.id= asi.userid where u.status=1 and asi.itemname<>'admin'";
		$totaUsuariosActivos=count(Yii::app()->db->createCommand($sql)->queryAll());
		////////////////////////////////////////////////////////Usuarios con mas de tres visitas////////////////////////////
		$sql="select * from tbl_users u join tbl_authAssignment asi on  u.id= asi.userid where u.ingresos>3 and asi.itemname<>'admin'";
		$usuarioMasTresVisitas=count(Yii::app()->db->createCommand($sql)->queryAll());
		////////////////////////////////////////////////////////Usuarios con menos o igual a tres visitas/////////////
		$sql="select * from tbl_users u join tbl_authAssignment asi on  u.id= asi.userid where u.ingresos<=3 and asi.itemname<>'admin'";
		$usuarioMenosIgualTresVisitas=count(Yii::app()->db->createCommand($sql)->queryAll());
		




		//////////////////////////////////////////////////////USUARIOS////////////////////////////////////////////////////
		$sql='select  * from tbl_users where pendiente=0 and status=1 and type not in(0) and create_at between "'.$fechaIni.'" and "'.$fechaFinal.'" order by create_at asc';
		$todosUsuarios=User::model()->findAllBysql($sql);	
		$maxNumb=0;
		$usuarioDate="";
		$vectorUsuarioComprador=array();
		$vectorUsuarioCompraVenta=array();
		$vectorUsuarioVendedor=array();
		$vectorFecha=array();
		foreach($todosUsuarios as $each)
		{
			$fecha=date('Y-m-d',strtotime($each->create_at));
			if($fecha!=$usuarioDate)
			{
				$usuarioDate=$fecha;
				array_push($vectorFecha, Funciones::invertirFecha($fecha, true));

				$sql="select * from tbl_users where pendiente=0 and status=1 and type not in(0) and id in (select userid from tbl_authAssignment where itemname='compraVenta') and cast(create_at as DATE)='".$fecha."'";
				$compraVenta=User::model()->findAllBySql($sql);
				array_push($vectorUsuarioCompraVenta, count($compraVenta));
				if($maxNumb<count($compraVenta))
					$maxNumb=count($compraVenta);

				$sql="select * from tbl_users where pendiente=0 and status=1 and type not in(0) and id in (select userid from tbl_authAssignment where itemname='vendedor') and cast(create_at as DATE)='".$fecha."'";
				$vendedor=User::model()->findAllBySql($sql);
				array_push($vectorUsuarioVendedor, count($vendedor));
				if($maxNumb<count($vendedor))
					$maxNumb=count($vendedor);

				$sql="select * from tbl_users where pendiente=0 and status=1 and type not in(0) and id in (select userid from tbl_authAssignment where itemname='comprador') and cast(create_at as DATE)='".$fecha."'";
				$comprador=User::model()->findAllBySql($sql);
				array_push($vectorUsuarioComprador, count($comprador));
				if($maxNumb<count($comprador))
					$maxNumb=count($comprador);
			}
		
		}
		/////////////////////////////Login de usuarios por rol(solo cuenta un solo login por dia)//////////////////////////////////////////////////
		$sql='select distinct(cast(fecha as DATE)) as dates from tbl_historial_visitas where fecha between "'.$fechaIni.'" and "'.$fechaFinal.'"';
		$todosLogin=Yii::app()->db->createCommand($sql)->queryAll();
		$maxNumbLogin=0;
		$loginDate="";
		$vectorFechaLogin=array();
		$vectorLoginComprador=array();
		$vectorLoginVendedor=array();
		$vectorLoginCompraVenta=array();
		foreach($todosLogin as $each)
		{
			$fecha=date('Y-m-d',strtotime($each['dates']));
			if($fecha!=$loginDate)
			{
				$loginDate=$fecha;
				array_push($vectorFechaLogin, Funciones::invertirFecha($fecha, true));

				$sql="select distinct(id_user) from tbl_historial_visitas where cast(fecha as DATE)='".$fecha."' and id_user in (select userid from tbl_authAssignment where itemname='compraVenta')";
				$compraVenta=Yii::app()->db->createCommand($sql)->queryAll();
				array_push($vectorLoginCompraVenta, count($compraVenta));
				if($maxNumbLogin<count($compraVenta))
					$maxNumbLogin=count($compraVenta);

				$sql="select distinct(id_user) from tbl_historial_visitas where cast(fecha as DATE)='".$fecha."' and id_user in (select userid from tbl_authAssignment where itemname='vendedor')";
				$vendedor=Yii::app()->db->createCommand($sql)->queryAll();
				array_push($vectorLoginVendedor, count($vendedor));
				if($maxNumbLogin<count($vendedor))
					$maxNumbLogin=count($vendedor);

				$sql="select distinct(id_user) from tbl_historial_visitas where cast(fecha as DATE)='".$fecha."' and id_user in (select userid from tbl_authAssignment where itemname='comprador')";
				$comprador=Yii::app()->db->createCommand($sql)->queryAll();
				array_push($vectorLoginComprador, count($comprador));
				if($maxNumbLogin<count($comprador))
					$maxNumbLogin=count($comprador);
			}
		}


		$this->render('admin_usuarios', array(
									 'vectorUsuarioCompraVenta'=>$vectorUsuarioCompraVenta,
									 'vectorUsuarioVendedor'=>$vectorUsuarioVendedor,
									 'vectorUsuarioComprador'=>$vectorUsuarioComprador,
									 'vectorFecha'=>$vectorFecha,
									 'maxNumb'=>$maxNumb,			///////hasta aqui usuarios
									 'vectorLoginCompraVenta'=>$vectorLoginCompraVenta,
									 'vectorLoginVendedor'=>$vectorLoginVendedor,
									 'vectorLoginComprador'=>$vectorLoginComprador,
									 'vectorFechaLogin'=>$vectorFechaLogin,
									 'maxNumbLogin'=>$maxNumbLogin, ///hasta aqui el login por dia
									 'sumatoria'=>$sumatoria,
									 'usuarioMasTresVisitas'=>$usuarioMasTresVisitas,
									 'usuarioMenosIgualTresVisitas'=>$usuarioMenosIgualTresVisitas,
									 'todosUsers'=>$todosUsers,
									 'totaUsuariosActivos'=>$totaUsuariosActivos,
									 'fechaFinal'=>$fechaFinal,
									 'fechaIni'=>$fechaIni, 
									 ));
	}




	public function actionAdmin()
	{

		$fechaIni="";
		$fechaFinal="";
		if($_GET)
		{
			$fechaFinal=$_GET['fechaFinal'];
			$fechaIni=$_GET['fechaIni'];
		}
		else
		{
			$fechaFinal=date('Y-m-d');
			$fechaIni=date('Y-m-d', strtotime('-1 month'));
		}
		//////////////////////////////////////////////TOTAl de Empresas/////////////////////////////////////////////////////
		$sql="select * from tbl_empresas where rol<>'admin'";
		$sumatoria=count(Empresas::model()->findAllBysql($sql));
		///////////////////////////////////////////Total de empresas compradoras//////////////////////////////////////////
		$sql="select * from tbl_empresas where rol='comprador'";
		$totalEmpresasCompradoras=count(Empresas::model()->findAllBysql($sql));
		///////////////////////////////////////////Total de empresas Vendedoras//////////////////////////////////////////
		$sql="select * from tbl_empresas where rol='vendedor'";
		$totalEmpresasVendedoras=count(Empresas::model()->findAllBysql($sql));
		///////////////////////////////////////////Total de empresas compra-venta//////////////////////////////////////////
		$sql="select * from tbl_empresas where rol='compraVenta'";
		$totalEmpresasCompraVenta=count(Empresas::model()->findAllBysql($sql));
		///////////////////////////////////////////Almacenes comprador////////////////////////////////////////////////
		$sql="select * from tbl_almacen where empresas_id in (select id from tbl_empresas where rol='comprador')";
		$totalAlmacenComprador=count(Empresas::model()->findAllBysql($sql));
				///////////////////////////////////////////Almacenes vendedor//////////////////////////////////////////
		$sql="select * from tbl_almacen where empresas_id in (select id from tbl_empresas where rol='vendedor')";
		$totalAlmacenCompraVenta=count(Empresas::model()->findAllBysql($sql));

		/////////////////////////////////////////////Empresas////////////////////////////////////////////////////////////////
		$sql='select * from tbl_empresas_has_tbl_users empre join tbl_users users on empre.users_id=users.id  where (select min(create_at) from tbl_users) and users.pendiente=0 and users.status=1 and users.create_at between "'.$fechaIni.'" and "'.$fechaFinal.'" group by empre.empresas_id order by empre.empresas_id';
		$todasEmpresas=Yii::app()->db->createCommand($sql)->queryAll();
		$maxNumbEmpresas=0;
		$empresasDate="";
		$vectorFechaEmpresas=array();
		$vectorEmpresasComprador=array();
		$vectorEmpresasVendedor=array();
		$vectorEmpresasCompraVenta=array();
		foreach($todasEmpresas as $each)
		{
			$fecha=date('Y-m-d',strtotime($each['create_at']));
			if($fecha!=$empresasDate)
			{
				$empresasDate=$fecha;
				array_push($vectorFechaEmpresas, Funciones::invertirFecha($fecha, true));

				$sql="select * from tbl_empresas_has_tbl_users empre join tbl_users users on empre.users_id=users.id  where (select min(create_at) from tbl_users) and empre.users_id in (select userid from tbl_authAssignment where itemname='compraVenta') and users.pendiente=0 and users.status=1 and cast(users.create_at as DATE)='".$fecha."' group by empre.empresas_id order by empre.empresas_id";
				$compraVenta=Yii::app()->db->createCommand($sql)->queryAll();
				array_push($vectorEmpresasCompraVenta, count($compraVenta));
				if($maxNumbEmpresas<count($compraVenta))
					$maxNumbEmpresas=count($compraVenta);

				$sql="select * from tbl_empresas_has_tbl_users empre join tbl_users users on empre.users_id=users.id  where (select min(create_at) from tbl_users) and empre.users_id in (select userid from tbl_authAssignment where itemname='vendedor') and users.pendiente=0 and users.status=1 and cast(users.create_at as DATE)='".$fecha."' group by empre.empresas_id order by empre.empresas_id";
				$vendedor=Yii::app()->db->createCommand($sql)->queryAll();
				array_push($vectorEmpresasVendedor, count($vendedor));
				if($maxNumbEmpresas<count($vendedor))
					$maxNumbEmpresas=count($vendedor);

				$sql="select * from tbl_empresas_has_tbl_users empre join tbl_users users on empre.users_id=users.id  where (select min(create_at) from tbl_users) and empre.users_id in (select userid from tbl_authAssignment where itemname='comprador') and users.pendiente=0 and users.status=1 and cast(users.create_at as DATE)='".$fecha."' group by empre.empresas_id order by empre.empresas_id";
				$comprador=Yii::app()->db->createCommand($sql)->queryAll();
				array_push($vectorEmpresasComprador, count($comprador));
				if($maxNumbEmpresas<count($comprador))
					$maxNumbEmpresas=count($comprador);
			}
		}

		

		$this->render('admin', array(
									 'vectorEmpresasCompraVenta'=>$vectorEmpresasCompraVenta,
									 'vectorEmpresasVendedor'=>$vectorEmpresasVendedor,
									 'vectorEmpresasComprador'=>$vectorEmpresasComprador,
									 'vectorFechaEmpresas'=>$vectorFechaEmpresas,
									 'maxNumbEmpresas'=>$maxNumbEmpresas, //hasta aqui empresas
									 'sumatoria'=>$sumatoria,
									 'totalEmpresasCompraVenta'=>$totalEmpresasCompraVenta,
									 'totalEmpresasCompradoras'=>$totalEmpresasCompradoras,
									 'totalEmpresasVendedoras'=>$totalEmpresasVendedoras,
									 'fechaFinal'=>$fechaFinal,
									 'fechaIni'=>$fechaIni, 
									 ));
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}