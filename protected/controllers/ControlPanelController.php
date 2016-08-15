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
				'actions'=>array('admin', 'adminUsuarios', 'adminOrdenes', 'adminProductos', 'scriptAbandono'),
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
	public function retornarProducto($id)
	{
		$sql='select sum(cantidad) as sumatoria from tbl_orden_has_inventario where orden_id in (select id from tbl_orden where estado=1) and inventario_id in (select id from tbl_inventario where producto_id="'.$id.'")';
		$sumatoriaMontosPendientes=Yii::app()->db->createCommand($sql)->queryRow();
		if($sumatoriaMontosPendientes['sumatoria']=="")
			return '0';
		else
			return $sumatoriaMontosPendientes['sumatoria'];
	}
	public function actionAdminProductos()
	{
		$fechaIni="";
		$fechaFinal="";
		if(isset($_GET['fechaFinal']))
		{
			$fechaFinal=$_GET['fechaFinal'];
			$fechaIni=$_GET['fechaIni'];
		}
		else
		{
			$fechaFinal=date('Y-m-d');
			$fechaIni=date('Y-m-d', strtotime('-1 month'));
		}


		/////////////////////////////////Total de productos padres//////////////////////////////////////////////////////////
		$todosPadres=count(ProductoPadre::model()->findAll());
		/////////////////////////////////Total de productos padres activos//////////////////////////////////////////////////////////
		$todosPadresActivos=ProductoPadre::model()->countByAttributes(array('activo'=>1));
		/////////////////////////////////Total de productos padres Inactivos//////////////////////////////////////////////////////////
		$todosPadresInactivos=ProductoPadre::model()->countByAttributes(array('activo'=>0));
		/////////////////////////////////Total de variaciones//////////////////////////////////////////////////////////
		$variaciones=count(Producto::model()->findAll());
		/////////////////////////////////Total de variaciones activos//////////////////////////////////////////////////////////
		$variacionesActivas=Producto::model()->countByAttributes(array('aprobado'=>1));
		/////////////////////////////////Total de variaciones inactivos//////////////////////////////////////////////////////////
		$variacionesInactivas=Producto::model()->countByAttributes(array('aprobado'=>2));
		/////////////////////////////////Total de variaciones pendientes//////////////////////////////////////////////////////////
		$variacionesPendientes=Producto::model()->countByAttributes(array('aprobado'=>0));
		/////////////////////////////Visitas de un producto//////////////////////////////////////////////////
		$HistorialVisitas = new HistorialVisitas; 
		$HistorialVisitas->unsetAttributes();
		$bandera=false;
		$dataProvider = $HistorialVisitas->historialVendidoVisita();

		/* Para mantener la paginacion en las busquedas */
		if(isset($_GET['ajax']) && isset($_SESSION['searchVisitas']) && !isset($_POST['query'])){
			$_POST['query'] = $_SESSION['searchVisitas'];
			$bandera=true;
		}

        if($bandera==FALSE){
			unset($_SESSION['searchVisitas']);
        }
		/*$sql='select distinct(count(producto_id)) as cantidad, producto_id from tbl_historial_visitas where producto_id<>"" group by producto_id';
		$productosVisitas=Yii::app()->db->createCommand($sql)->queryAll();*/

		$this->render('admin_productos', array(
									   'fechaFinal'=>$fechaFinal,
									   'fechaIni'=>$fechaIni,
									   'todosPadres'=>$todosPadres,
									   'todosPadresActivos'=>$todosPadresActivos,
									   'todosPadresInactivos'=>$todosPadresInactivos,
									   'variaciones'=>$variaciones,
									   'variacionesActivas'=>$variacionesActivas,
									   'variacionesInactivas'=>$variacionesInactivas,
									   'variacionesPendientes'=>$variacionesPendientes,
									   //'productosVisitas'=>$productosVisitas,
									   'dataProvider'=>$dataProvider,
									   ));
	}

	public function actionAdminOrdenes()
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
		/////////////////////////////////////////////////////ORDENES//////////////////////////////////////////////////////
		$sql='select  * from tbl_orden where fecha between "'.$fechaIni.'" and "'.$fechaFinal.'" order by fecha asc';
		$todasOrdenes=Orden::model()->findAllBysql($sql);	
		$maxNumb=0;
		$ordenDate="";
		$vectorOrdenAceptada=array();
		$vectorOrdenPendiente=array();
		$vectorOrdenCancelada=array();
		$vectorFecha=array();
		foreach($todasOrdenes as $each)
		{
			$fecha=date('Y-m-d',strtotime($each->fecha));
			if($fecha!=$ordenDate)
			{
				$ordenDate=$fecha;
				array_push($vectorFecha, Funciones::invertirFecha($fecha, true));

				$sql="select * from tbl_orden where estado=1 and cast(fecha as DATE)='".$fecha."'";
				$ordenAceptada=Orden::model()->findAllBySql($sql);
				array_push($vectorOrdenAceptada, count($ordenAceptada));
				if($maxNumb<count($ordenAceptada))
					$maxNumb=count($ordenAceptada);

				$sql="select * from tbl_orden where estado=0 and cast(fecha as DATE)='".$fecha."'";
				$ordenPendiente=Orden::model()->findAllBySql($sql);
				array_push($vectorOrdenPendiente, count($ordenPendiente));
				if($maxNumb<count($ordenPendiente))
					$maxNumb=count($ordenPendiente);

				$sql="select * from tbl_orden where estado=2 and cast(fecha as DATE)='".$fecha."'";
				$ordenRechazada=Orden::model()->findAllBySql($sql);
				array_push($vectorOrdenCancelada, count($ordenRechazada));
				if($maxNumb<count($ordenRechazada))
					$maxNumb=count($ordenRechazada);
			}
		
		}

		//////////////////////////////////////ORDENES GENERADAS POR ROLES//////////////////////////////////////////////////////
		$maxNumbPorRol=0;
		$ordenDate="";
		$vectorOrdenCompraVenta=array();
		$vectorOrdenComprador=array();
		foreach($todasOrdenes as $each)
		{
			$fecha=date('Y-m-d',strtotime($each->fecha));
			if($fecha!=$ordenDate)
			{
				$ordenDate=$fecha;
				$sql="select * from tbl_orden where users_id in (select userid  from tbl_authAssignment where itemname='compraVenta') and cast(fecha as DATE)='".$fecha."'";
				$ordenCompraVenta=Orden::model()->findAllBySql($sql);
				array_push($vectorOrdenCompraVenta, count($ordenCompraVenta));
				if($maxNumbPorRol<count($ordenCompraVenta))
					$maxNumbPorRol=count($ordenCompraVenta);

				$sql="select * from tbl_orden where users_id in (select userid  from tbl_authAssignment where itemname='comprador')and cast(fecha as DATE)='".$fecha."'";
				$ordenCOmprador=Orden::model()->findAllBySql($sql);
				array_push($vectorOrdenComprador, count($ordenCOmprador));
				if($maxNumbPorRol<count($ordenCOmprador))
					$maxNumbPorRol=count($ordenCOmprador);

			}
		
		}
		/////////////////////////////////////////////////TASA DE ABANDONO////////////////////////////////////////////////////////////
  		$intencionCompraAbandonada=HistorialBolsa::model()->countBySql('select count(distinct(h.bolsa_has_inventario_id)) from tbl_historial_bolsa h JOIN tbl_bolsa_has_tbl_inventario bhi ON h.bolsa_has_inventario_id=bhi.id JOIN tbl_bolsa b ON b.id=bhi.bolsa_id JOIN tbl_almacen a ON a.id=bhi.almacen_id JOIN tbl_empresas e ON e.id=a.empresas_id  WHERE ultimo=1 and TIMESTAMPDIFF(WEEK,h.fecha,now()) order by h.fecha desc');
  		$intencionCompraTotal=HistorialBolsa::model()->countBySql('select count(*) from tbl_historial_bolsa h JOIN tbl_bolsa_has_tbl_inventario bhi ON h.bolsa_has_inventario_id=bhi.id JOIN tbl_bolsa b ON b.id=bhi.bolsa_id JOIN tbl_almacen a ON a.id=bhi.almacen_id JOIN tbl_empresas e ON e.id=a.empresas_id  WHERE ultimo=1 order by h.fecha desc');;
 		if($intencionCompraTotal>0)
 			$tasaAbandonoIntencionCompra=round($intencionCompraAbandonada*100/$intencionCompraTotal,2);
 		else
 			$tasaAbandonoIntencionCompra=0;
		///////////////////////////////////////////Promedio de productos por orden///////////////////////////////////////////
		$todasOrdenes=count(Orden::model()->findAll());
		$sql="select sum(cantidad) as sumatoria from tbl_orden_has_inventario";
		$sumatoria=Yii::app()->db->createCommand($sql)->queryRow();
		$sumatoria=$sumatoria['sumatoria'];
		////////////////////////////////////Valor medio de una orden////////////////////////////////////////////////////// 
		$sql="select sum(monto) as montos from tbl_orden";
		$sumatoriaMontos=Yii::app()->db->createCommand($sql)->queryRow();
		$sumatoriaMontos=$sumatoriaMontos['montos'];
		//////////////////////////////////Monto total de órdenes aprobadas////////////////////////////////////////////////
		$sql="select sum(monto) as montos from tbl_orden where estado=1";
		$sumatoriaMontosAprobados=Yii::app()->db->createCommand($sql)->queryRow();
		$sumatoriaMontosAprobados=$sumatoriaMontosAprobados['montos'];
		//////////////////////////////////Monto total de órdenes rechazadas////////////////////////////////////////////////
		$sql="select sum(monto) as montos from tbl_orden where estado=2";
		$sumatoriaMontosRechazados=Yii::app()->db->createCommand($sql)->queryRow();
		$sumatoriaMontosRechazados=$sumatoriaMontosRechazados['montos'];
		//////////////////////////////////Monto total de órdenes pendientes////////////////////////////////////////////////
		$sql="select sum(monto) as montos from tbl_orden where estado=0";
		$sumatoriaMontosPendientes=Yii::app()->db->createCommand($sql)->queryRow();
		$sumatoriaMontosPendientes=$sumatoriaMontosPendientes['montos'];
		//////////////////////////////////Tasa de conversion////////////////////////////////////////////////////////////
		$sql='select sum(ingresos) as tota from tbl_users where id in (select userid from tbl_authAssignment where itemname="comprador" or itemname="compraVenta")';
		$totaVisitaCompradorVendedor_Comprador=Yii::app()->db->createCommand($sql)->queryRow();
		$totaVisitaCompradorVendedor_Comprador=$totaVisitaCompradorVendedor_Comprador['tota'];

		$this->render('admin_ordenes', array(									 
									 'fechaFinal'=>$fechaFinal,
									 'fechaIni'=>$fechaIni,
									 'maxNumb'=>$maxNumb,
									 'vectorOrdenAceptada'=>$vectorOrdenAceptada,
									 'vectorOrdenPendiente'=>$vectorOrdenPendiente,
									 'vectorOrdenCancelada'=>$vectorOrdenCancelada,
									 'vectorFecha'=>$vectorFecha,
									 'maxNumbPorRol'=>$maxNumbPorRol,
									 'vectorOrdenCompraVenta'=>$vectorOrdenCompraVenta,
									 'vectorOrdenComprador'=>$vectorOrdenComprador,
									 'maxNumbPorRol'=>$maxNumbPorRol,
									 'tasaAbandonoIntencionCompra'=>$tasaAbandonoIntencionCompra,
									 'intencionCompraTotal'=>$intencionCompraTotal,
									 'intencionCompraAbandonada'=>$intencionCompraAbandonada,
									 'todasOrdenes'=>$todasOrdenes,
									 'sumatoria'=>$sumatoria,
									 'sumatoriaMontos'=>$sumatoriaMontos,
									 'sumatoriaMontosAprobados'=>$sumatoriaMontosAprobados,
									 'sumatoriaMontosRechazados'=>$sumatoriaMontosRechazados,
									 'sumatoriaMontosPendientes'=>$sumatoriaMontosPendientes,
									 'totaVisitaCompradorVendedor_Comprador'=>$totaVisitaCompradorVendedor_Comprador,
									 ));
	}

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
		////////////////////////////////////////////////////////usuarios compradores activos/////////////////////////////
		$sql='select * from tbl_users u join tbl_authAssignment aut on aut.userid=u.id where u.status =1 and aut.itemname="comprador"';
		$usuariosCompradoresActivos=count(Yii::app()->db->createCommand($sql)->queryAll());
		////////////////////////////////////////////////////////usuarios vendedores activos/////////////////////////////
		$sql='select * from tbl_users u join tbl_authAssignment aut on aut.userid=u.id where u.status =1 and aut.itemname="vendedor"';
		$usuariosVendedoresActivos=count(Yii::app()->db->createCommand($sql)->queryAll());
		////////////////////////////////////////////////////////usuarios compra-venta activos/////////////////////////////
		$sql='select * from tbl_users u join tbl_authAssignment aut on aut.userid=u.id where u.status =1 and aut.itemname="compraVenta"';
		$usuariosCompraVentaActivos=count(Yii::app()->db->createCommand($sql)->queryAll());
		////////////////////////////////////////////////////////usuarios compradores inactivos/////////////////////////////
		$sql='select * from tbl_users u join tbl_authAssignment aut on aut.userid=u.id where u.status =0 and aut.itemname="comprador"';
		$usuariosCompradoresInactivos=count(Yii::app()->db->createCommand($sql)->queryAll());
		////////////////////////////////////////////////////////usuarios vendedores inactivos/////////////////////////////
		$sql='select * from tbl_users u join tbl_authAssignment aut on aut.userid=u.id where u.status =0 and aut.itemname="vendedor"';
		$usuariosVendedoresInactivos=count(Yii::app()->db->createCommand($sql)->queryAll());
		////////////////////////////////////////////////////////usuarios compra-venta inactivos/////////////////////////////
		$sql='select * from tbl_users u join tbl_authAssignment aut on aut.userid=u.id where u.status =0 and aut.itemname="compraVenta"';
		$usuariosCompraVentaInactivos=count(Yii::app()->db->createCommand($sql)->queryAll());
		//////////////////////////////////////////////sumatoria de login de usuarios compradores//////////////////////////////////
		$sql='select sum(u.ingresos) as ing from tbl_users u join tbl_authAssignment aut on aut.userid=u.id where aut.itemname="comprador"';
		$sumatoriaLoginCompradores=Yii::app()->db->createCommand($sql)->queryRow();
		$sumatoriaLoginCompradores=$sumatoriaLoginCompradores['ing'];
		//////////////////////////////////////////////sumatoria de login de usuarios vendedores//////////////////////////////////
		$sql='select sum(u.ingresos) as ing from tbl_users u join tbl_authAssignment aut on aut.userid=u.id where aut.itemname="vendedor"';
		$sumatoriaLoginVendedores=Yii::app()->db->createCommand($sql)->queryRow();
		$sumatoriaLoginVendedores=$sumatoriaLoginVendedores['ing'];
		//////////////////////////////////////////////sumatoria de login de usuarios compra-venta//////////////////////////////////
		$sql='select sum(u.ingresos) as ing from tbl_users u join tbl_authAssignment aut on aut.userid=u.id where aut.itemname="compraVenta"';
		$sumatoriaLoginCompraVenta=Yii::app()->db->createCommand($sql)->queryRow();
		$sumatoriaLoginCompraVenta=$sumatoriaLoginCompraVenta['ing'];

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
		$sql='select distinct(cast(fecha as DATE)) as dates from tbl_historial_visitas where id_user<>"" and fecha between "'.$fechaIni.'" and "'.$fechaFinal.'"';
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
									 'usuariosCompradoresActivos'=>$usuariosCompradoresActivos,
									 'usuariosVendedoresActivos'=>$usuariosVendedoresActivos,
									 'usuariosCompraVentaActivos'=>$usuariosCompraVentaActivos,
									 'usuariosCompradoresInactivos'=>$usuariosCompradoresInactivos,
									 'usuariosVendedoresInactivos'=>$usuariosVendedoresInactivos,
									 'usuariosCompraVentaInactivos'=>$usuariosCompraVentaInactivos,
									 'sumatoriaLoginCompradores'=>$sumatoriaLoginCompradores,
									 'sumatoriaLoginVendedores'=>$sumatoriaLoginVendedores,
									 'sumatoriaLoginCompraVenta'=>$sumatoriaLoginCompraVenta,
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
		$totalAlmacenVendedor=count(Empresas::model()->findAllBysql($sql));
		///////////////////////////////////////////Almacenes compra-venta//////////////////////////////////////////
		$sql="select * from tbl_almacen where empresas_id in (select id from tbl_empresas where rol='compraVenta')";
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
									 'totalAlmacenComprador'=>$totalAlmacenComprador,
									 'totalAlmacenVendedor'=>$totalAlmacenVendedor,
									 'totalAlmacenCompraVenta'=>$totalAlmacenCompraVenta,
									 'fechaFinal'=>$fechaFinal,
									 'fechaIni'=>$fechaIni, 
									 ));
	}
	public function actionScriptAbandono()
	{
	 // http://telotengo.com/new
		header('Location: '.Yii::app()->getBaseUrl(true).'/scripts/script_abandono.php');
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