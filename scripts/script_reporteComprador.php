<?php
// Start the session
session_start();
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">



    /* function ordenes(vectorOrdenAceptada,vectorOrdenPendiente,vectorOrdenCancelada,vectorFecha,maxNumb, empresas_id) 
    {
       google.charts.load('current', {'packages':['corechart']});
 google.charts.setOnLoadCallback(ordenes); 
            var data = new google.visualization.DataTable();
        //data.addColumn('number', 'Usuarios');
        data.addColumn('string', 'Fecha');
        data.addColumn('number', 'Aprobada');
        data.addColumn('number', 'Pendiente');
        data.addColumn('number', 'Rechazada');

        for(i = 0; i < vectorFecha.length; i++)
          data.addRow([vectorFecha[i],vectorOrdenAceptada[i],vectorOrdenPendiente[i],vectorOrdenCancelada[i]]);

        if(maxNumb<4) // 4 es el numero minimo para que la grafica se vea bien
          maxNumb=4;

        var options = {
         // title: 'Usuarios',
          hAxis: {title: 'Fecha',  titleTextStyle: {color: '#333'}},
          vAxis: {title: 'Ordenes', minValue: 0, maxValue:maxNumb, format:'0'},
          legend: {position: 'top', alignment: 'center'},

        };

        var chart = new google.visualization.AreaChart(document.getElementById('ordenes'+empresas_id));
        chart.draw(data, options);
    }*/
</script>


<?php
if (strpos(getcwd(),'new')>0)
{
 	$entorno="new/";
	$entorno2="new";
	$baseDatos="db_telotengoNEW"; 
}
else
{
	if (strpos(getcwd(),'staging')>0)
	{
		 $entorno="staging/";
		 $entorno2="staging";
		$baseDatos="db_telotengoSTAGING"; 

	}
	else
	{
		$entorno="production/";
		$entorno2="production";
		$baseDatos="db_telotengoPRODUCTION";  //falta definir


	}
}

$path=$_SERVER['DOCUMENT_ROOT']."/".$entorno."protected/extensions/yii-mail/vendors/swiftMailer/swift_required.php";
require $path;

// Conectando, seleccionando la base de datos
$link = mysqli_connect('telotengo.com', 'telotengo', 'SFGth$$%67')
    or die('No se pudo conectar: ' . mysql_error());

mysqli_select_db($link,$baseDatos);
mysqli_set_charset($link,"utf8");

$sql='select empresas_id from tbl_empresas_has_tbl_users where users_id in (select userid from tbl_authAssignment where itemname="comprador") group by empresas_id';
$result = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
$subject = 'Reporte semanal de las actividades de tu empresa';
$from = array('info@telotengo.com' =>'Telotengo');
foreach($result as $resultado)
{
	////////////////////////////////////////EMPRESA////////////////////////////////////////////////////////////////////////
	$sql='select * from tbl_empresas where id="'.$resultado['empresas_id'].'"';
	$value = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
	$empresas = $value->fetch_assoc();
	///////////////////////////////////////Contar el numero de miembros de la empresa/////////////////////////////////////
	$sql='select  count(*) as totalMiembros from tbl_empresas em join tbl_empresas_has_tbl_users emu on em.id=emu.empresas_id where empresas_id="'.$empresas['id'].'"';
	$value = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
	$total = $value->fetch_assoc();
	///////////////////////////Contar el numero de miembros de la empresa administradores/////////////////////////////////////
	$sql='select  count(*) as totalMiembros from tbl_empresas em join tbl_empresas_has_tbl_users emu on em.id=emu.empresas_id where empresas_id="'.$empresas['id'].'" and admin=1';
	$value = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
	$totalAdministradores = $value->fetch_assoc();
	///////////////////////////////////////Contar el numero de miembros de la empresa manager///////////////////////////////
	$sql='select  count(*) as totalMiembros from tbl_empresas em join tbl_empresas_has_tbl_users emu on em.id=emu.empresas_id where empresas_id="'.$empresas['id'].'" and admin=0';
	$value = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
	$totalManagers = $value->fetch_assoc();
	/////Contar el numero de miembros de la empresa Administradores que se han conectado esta semana//////////////////////////
	$sql='select count(*) as totalMiembros from tbl_empresas em join tbl_empresas_has_tbl_users emu on em.id=emu.empresas_id join tbl_users users on users.id=emu.users_id where empresas_id="'.$empresas['id'].'" and admin=1 AND lastvisit_at >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)';
	$value = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
	$totalAdministradoresConectados = $value->fetch_assoc();
	/////Contar el numero de miembros de la empresa Manager que se han conectado esta semana//////////////////////////////////
	$sql='select count(*) as totalMiembros from tbl_empresas em join tbl_empresas_has_tbl_users emu on em.id=emu.empresas_id join tbl_users users on users.id=emu.users_id where empresas_id="'.$empresas['id'].'" and admin=0 AND lastvisit_at >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)';
	$value = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
	$totalManagersConectados = $value->fetch_assoc();
	/////Contar el numero de miembros de la empresa Administradores que han invitado esta semana/////////////////////////////
	$sql='select count(*) as totalMiembros from tbl_users where create_at >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK) and quien_invita in (select users_id from tbl_empresas_has_tbl_users where empresas_id="'.$empresas['id'].'" and admin=1)';
	$value = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
	$totalAdministradoresInvitadores = $value->fetch_assoc();
	/////Contar el numero de miembros de la empresa Managers que han invitado esta semana/////////////////////////////
	$sql='select count(*) as totalMiembros from tbl_users where create_at >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK) and quien_invita in (select users_id from tbl_empresas_has_tbl_users where empresas_id="'.$empresas['id'].'" and admin=0)';
	$value = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
	$totalManagersInvitadores = $value->fetch_assoc();
	///Contar el numero de miembros de la empresa Administradores que han generado solicitudes de compra
	$sql='select count(distinct(users_id)) as totalMiembros from tbl_orden where empresa_id="'.$empresas['id'].'" and users_id in ( select users_id from tbl_empresas_has_tbl_users where admin=1) and fecha >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)';
	$value = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
	$totalAdministradoresCompradores = $value->fetch_assoc();
	///Contar el numero de miembros de la empresa Managers que han generado solicitudes de compra
	$sql='select count(distinct(users_id)) as totalMiembros from tbl_orden where empresa_id="'.$empresas['id'].'" and users_id in ( select users_id from tbl_empresas_has_tbl_users where admin=0) and fecha >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)';
	$value = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
	$totalManagersCompradores = $value->fetch_assoc();
	//////////////////////////////Total de productos en el carrito de compras//////////////////////////////////////////
	$sql='select count(*) as total from tbl_bolsa_has_tbl_inventario where bolsa_id in (select id from tbl_bolsa where empresas_id="'.$empresas['id'].'") and fecha >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)';
	$value = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
	$numProductosCarrito = $value->fetch_assoc();
	////////////////////////////////Pedidos aprobados/////////////////////////////////////////////////////////////////
	$sql='select count(*) as total from tbl_orden where estado=1 and empresa_id="'.$empresas['id'].'" and fecha >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)';
	$value = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
	$pedidosAprobados = $value->fetch_assoc();
	////////////////////////////////Pedidos aprobados/////////////////////////////////////////////////////////////////
	$sql='select count(*) as total from tbl_orden where estado=2 and empresa_id="'.$empresas['id'].'" and fecha >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)';
	$value = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
	$pedidosRechazados = $value->fetch_assoc();
	////////////////////////////////Pedidos pendientes/////////////////////////////////////////////////////////////////
	$sql='select count(*) as total from tbl_orden where estado=0 and empresa_id="'.$empresas['id'].'" and fecha >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)';
	$value = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
	$pedidosPendientes = $value->fetch_assoc();


	/////////////////////////////////////////////////////ORDENES//////////////////////////////////////////////////////
	/*$sql='select  * from tbl_orden where fecha >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK) and almacen_id in (select id from tbl_almacen where empresas_id="'.$empresas['id'].'") order by fecha asc';
	$todasOrdenes = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
	$maxNumb=0;
	$ordenDate="";
	$vectorOrdenAceptada=array();
	$vectorOrdenPendiente=array();
	$vectorOrdenCancelada=array();
	$vectorFecha=array();
	foreach($todasOrdenes as $each)
	{
		$fecha=date('Y-m-d',strtotime($each['fecha']));
		if($fecha!=$ordenDate)
		{
			$ordenDate=$fecha;
			$invert = explode("-",$fecha); 
            $fecha_invert = $invert[2]."-".$invert[1]."-".$invert[0]; 
			array_push($vectorFecha, $fecha_invert);

			$sql="select count(*) as contador from tbl_orden where estado=1 and cast(fecha as DATE)='".$fecha."'";
			$value= mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
			$ordenAceptada = $value->fetch_assoc();
			array_push($vectorOrdenAceptada, $ordenAceptada['contador']);
			if($maxNumb<$ordenAceptada['contador'])
				$maxNumb=$ordenAceptada['contador'];

			$sql="select count(*) as contador from tbl_orden where estado=0 and cast(fecha as DATE)='".$fecha."'";
			$value= mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
			$ordenPendiente = $value->fetch_assoc();
			array_push($vectorOrdenPendiente, $ordenPendiente['contador']);
			if($maxNumb<$ordenPendiente['contador'])
				$maxNumb=$ordenPendiente['contador'];

			$sql="select count(*) as contador from tbl_orden where estado=2 and cast(fecha as DATE)='".$fecha."'";
			$value= mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
			$ordenRechazada = $value->fetch_assoc();
			array_push($vectorOrdenCancelada, $ordenRechazada['contador']);
			if($maxNumb<$ordenRechazada['contador'])
				$maxNumb=$ordenRechazada['contador'];
		}
	
	}*/
////////////////////////////////////////////MENSAJES PERSONALIZADOS///////////////////////////////////////////////////////////
if($total['totalMiembros']<>1)
	{
		$mensajePrincipal="miembros";
		$mensajeSecundario="de los cuales";
	}
	else
	{
		$mensajePrincipal="miembro";
		$mensajeSecundario="el cual";
	}
	if($totalAdministradores['totalMiembros']<>1)
	{
		$mensajePrincipalAdministrador="son administradores";
		$mensajeParrafoPrincipal="De los";
		$pluralAdministrador="Administradores";

	}
	else
	{
		$mensajePrincipalAdministrador="es administrador";
		$mensajeParrafoPrincipal="De";
		$pluralAdministrador="Administrador";

	}
	if($totalAdministradoresConectados['totalMiembros']<>1)
	{
		$pluralPalabra="se han conectado";
		$pluralSingle="han";
	}
	else
	{		
		$pluralPalabra="se ha conectado";
		$pluralSingle="han";
	}
	if($totalAdministradoresCompradores['totalMiembros']<>1)
		$pluralSingle2="han";
	else
		$pluralSingle2="ha";

	if($totalManagersCompradores['totalMiembros']<>1)
		$pluralSingle3="han";
	else
		$pluralSingle3="ha";

	

	if($totalManagers['totalMiembros']<>1)
	{
		$mensajePrincipalManager="son mánager";
		$mensajeParrafoManager="De los";
		$pluralManager="Managers";

	}
	else
	{
		$mensajePrincipalManager="es mánager";
		$mensajeParrafoManager="De";
		$pluralManager="Manager";

	}
	if($totalManagersConectados['totalMiembros']<>1)
	{
		$pluralPalabraManager="se han conectado";
		$pluralSingleManager="han";
	}
	else
	{		
		$pluralPalabraManager="se ha conectado";
		$pluralSingleManager="ha";
	}

	if($numProductosCarrito['total']<>1)
		$productosCarro="productos";
	else
		$productosCarro="producto";
	if($pedidosAprobados['total']<>1)
		$pedidosA="pedidos";
	else
		$pedidosA="pedido";
	if($pedidosRechazados['total']<>1)
		$pedidosN="pedidos";
	else
		$pedidosN="pedido";
	if($pedidosPendientes['total']<>1)
		$pedidosP="pedidos pendientes";
	else
		$pedidosP="pedido pendiente";


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		echo $body='

	<div>
	     <div style="width:100%;min-height:70px;line-height:70px;background:#000">
	         <img src="https://ci6.googleusercontent.com/proxy/eulxA7clmsEtrKINwkCYvYmNyOnPsspK8IP4C0702GpeqFHGyBdQ_KGyLT6i0ldzSRfkeAkMXVznNWJ2BJ2yU7aI7XTM3F4hEwBBxB9EU1L9KwXtf2kOcPezGw=s0-d-e1-ft#http://telotengo.com/new/themes/bootstrap/images/layout/whitelogo.png" height="40px" style="margin-left:25px;margin-top:15px" class="CToWUd">
	    </div>
	</div>
	<div id="orderDetail" class="row-fluid" style="font-size:15px; padding-top: 23px;">

		<div class="col-md-7 orderInfo no_horizontal_padding" >

		Estimado cliente. <br><br>
		<p>
		Esperamos que hayas tenido un buen fin de semana. A continuación te presentaremos un resumen de lo que sucedió en '.$empresas['razon_social'].' la semana pasada.</p>

		<p>Miembros</p><hr>

		Hay '.$total['totalMiembros'].' '.$mensajePrincipal.' en tu empresa, '.$mensajeSecundario.': '.$totalAdministradores['totalMiembros'].' '.$mensajePrincipalAdministrador.' y '.$totalManagers['totalMiembros'].' '.$mensajePrincipalManager.'.<br><br>

		<ul>

		<li> '.$mensajeParrafoPrincipal.' '.$totalAdministradores['totalMiembros'].' '.$pluralAdministrador.', '.$totalAdministradoresConectados['totalMiembros'].' '.$pluralPalabra.', '.$totalAdministradoresInvitadores['totalMiembros'].' '.$pluralSingle.' realizado invitaciones a nuevos usuarios y '.$totalAdministradoresCompradores['totalMiembros'].' '.$pluralSingle2.' generado solicitudes de compras.</li>

		<li> '.$mensajeParrafoManager.' '.$totalManagers['totalMiembros'].' '.$pluralManager.', '.$totalManagersConectados['totalMiembros'].' '.$pluralPalabraManager.', '.$totalManagersInvitadores['totalMiembros'].' '.$pluralSingleManager.' realizado invitaciones a nuevos usuarios y  '.$totalManagersCompradores['totalMiembros'].' '.$pluralSingle3.' generado solicitudes de compras.</li>
		</ul>

		<p>Compras</p><hr> 
		<ul>
			<li>Mantienes '.$numProductosCarrito['total'].' '.$productosCarro.' en tu carrito. </li>
			<li>Te aprobaron '.$pedidosAprobados['total'].' '.$pedidosA.'.</li>
			<li>Te rechazaron '.$pedidosRechazados['total'].' '.$pedidosN.'. </li>
			<li>Tienes '.$pedidosPendientes['total'].' '.$pedidosP.' de revisión.</li>

		</ul>

		<div id="ordenes'.$resultado['empresas_id'].'"  style="width: 1000px;"></div>

		</div>  
	</div>
	';

	/*$correosEnviar=array();
	$sql="select * from tbl_empresas_has_tbl_users where admin=1 and empresas_id='".$empresas['id']."'";
	$consul = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
	foreach($consul as $correos)
	{
		$sql="select * from tbl_users where id='".$correos['users_id']."'";
		$value = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
		$persona = $value->fetch_assoc();
		array_push($correosEnviar, $persona['email']);
	}

	$transport = Swift_SmtpTransport::newInstance('smtp.mandrillapp.com', 587);
	$transport->setUsername('Te lo Tengo');
	$transport->setPassword('1GOkG9_dtKzZivouvSRCqA');
	$swift = Swift_Mailer::newInstance($transport);


	$message = new Swift_Message($subject);
	$message->setFrom($from);
	$message->setBody($body, 'text/html');
	$message->setTo($correosEnviar);
	//$message->addPart($text, 'text/plain');

	if ($recipients = $swift->send($message, $failures))
	{
	 echo 'Message successfully sent!';
	} else {
	 echo "There was an error:";
	 print_r($failures);
	}*/
	//break;
}



mysqli_select_db($link,$baseDatos);
mysqli_set_charset($link,"utf8");
#header('Location: http://telotengo.com/'.$entorno);
?>