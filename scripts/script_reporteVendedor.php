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

$sql='select empresas_id from tbl_empresas_has_tbl_users where users_id in (select userid from tbl_authAssignment where itemname="vendedor") group by empresas_id';
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
	/////Contar el numero de miembros de la empresa Administradores que han aprobado ordenes esta semana//////////////////////
	$sql='select count(*) as totalMiembros from tbl_orden where id_vendedor in ( select users_id from tbl_empresas_has_tbl_users where empresas_id="'.$empresas['id'].'" and admin=1) AND fecha >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK) and estado=1';
	$value = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
	$totalAdministradoresAprobadores = $value->fetch_assoc();
	/////Contar el numero de miembros de la empresa Administradores que han negado ordenes esta semana//////////////////////
	$sql='select count(*) as totalMiembros from tbl_orden where id_vendedor in ( select users_id from tbl_empresas_has_tbl_users where empresas_id="'.$empresas['id'].'" and admin=1) AND fecha >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK) and estado=2';
	$value = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
	$totalAdministradoresNegadores = $value->fetch_assoc();
	/////Contar el numero de miembros de la empresa Managers que han aprobado ordenes esta semana//////////////////////
	$sql='select count(*) as totalMiembros from tbl_orden where id_vendedor in ( select users_id from tbl_empresas_has_tbl_users where empresas_id="'.$empresas['id'].'" and admin=0) AND fecha >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK) and estado=1';
	$value = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
	$totalManagersAprobadores = $value->fetch_assoc();
	/////Contar el numero de miembros de la empresa Managers que han negado ordenes esta semana//////////////////////
	$sql='select count(*) as totalMiembros from tbl_orden where id_vendedor in ( select users_id from tbl_empresas_has_tbl_users where empresas_id="'.$empresas['id'].'" and admin=0) AND fecha >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK) and estado=2';
	$value = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
	$totalManagersNegadores = $value->fetch_assoc();
	/////Numero total de ordenes aprobadas por empresa//////////////////////////////////////////////////////////////////
	$sql='select count(*) as total from tbl_orden where id_vendedor in ( select users_id from tbl_empresas_has_tbl_users where empresas_id="'.$empresas['id'].'") AND fecha >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK) and estado=1';
	$value = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
	$totalOrdenAprobadas = $value->fetch_assoc();
	/////Numero total de ordenes rechazadas por empresa//////////////////////////////////////////////////////////////////
	$sql='select count(*) as total from tbl_orden where id_vendedor in ( select users_id from tbl_empresas_has_tbl_users where empresas_id="'.$empresas['id'].'") AND fecha >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK) and estado=2';
	$value = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
	$totalOrdenRechazadas = $value->fetch_assoc();
	/////Numero total de ordenes pendientes por empresa//////////////////////////////////////////////////////////////////
	$sql='select count(*) as total from tbl_orden where id_vendedor in ( select users_id from tbl_empresas_has_tbl_users where empresas_id="'.$empresas['id'].'") AND fecha >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK) and estado=0';
	$value = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
	$totalOrdenPendientes = $value->fetch_assoc();
	/////////////////////////actualizacion de productos///////////////////////////////////////////////////////////////////
	$sql='select count(*) as total from tbl_inventario where fecha_act>= DATE_SUB(CURDATE(), INTERVAL 1 WEEK) and almacen_id in (select id from tbl_almacen where empresas_id="'.$empresas['id'].'")';
	$value = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
	$totalProductosActualizados = $value->fetch_assoc();


	/////////////////////////////////////////////////////ORDENES//////////////////////////////////////////////////////
	$sql='select  * from tbl_orden where fecha >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK) and almacen_id in (select id from tbl_almacen where empresas_id="'.$empresas['id'].'") order by fecha asc';
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
	
	}
	////////////////////////////////////MENSAJES PERSONALIZADOS///////////////////////////////////////////////////////////
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
	if($totalAdministradoresAprobadores['totalMiembros']<>1)
		$pluralSingle2="han";
	else
		$pluralSingle2="ha";

	if($totalAdministradoresNegadores['totalMiembros']<>1)
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


	if($totalManagersAprobadores['totalMiembros']<>1)
		$pluralSingle4="han";
	else
		$pluralSingle5="ha";

	if($totalManagersNegadores['totalMiembros']<>1)
		$pluralSingle5="han";
	else
		$pluralSingle5="ha";

	if($totalProductosActualizados['total']<>1)
		$productosInventario="productos";
	else
		$productosInventario="producto";
	if($totalOrdenAprobadas['total']<>1)
	{
		$pluralAprobadas="Se aprobaron";
		$pluralOrdenesA="órdenes";
	}
	else
	{
		$pluralAprobadas="se aprobo";
		$pluralOrdenesA="órden";
	}
	if($totalOrdenRechazadas['total']<>1)
	{
		$pluralRechazados="Se rechazaron";
		$pluralOrdenesR="órdenes";
	}
	else
	{
		$pluralRechazados="se rechazo";
		$pluralOrdenesR="órden";
	}
	if($totalOrdenPendientes['total']<>1)
	{
		$pluralPendiente="Quedaron";
		$pluralOrdenesP="órdenes pendientes";
	}
	else
	{
		$pluralPendiente="Quedo";
		$pluralOrdenesP="órden pendiente";
	}


	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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

		<li>'.$mensajeParrafoPrincipal.' '.$totalAdministradores['totalMiembros'].' '.$pluralAdministrador.', '.$totalAdministradoresConectados['totalMiembros'].' '.$pluralPalabra.', '.$totalAdministradoresInvitadores['totalMiembros'].' '.$pluralSingle.' realizado invitaciones a nuevos usuarios, '.$totalAdministradoresAprobadores['totalMiembros'].' '.$pluralSingle2.' aprobado solicitudes de compras y '.$totalAdministradoresNegadores['totalMiembros'].' '.$pluralSingle3.' rechazado solicitudes de compra.</li>

		<li> '.$mensajeParrafoManager.' '.$totalManagers['totalMiembros'].' '.$pluralManager.', '.$totalManagersConectados['totalMiembros'].' '.$pluralPalabraManager.', '.$totalManagersInvitadores['totalMiembros'].' '.$pluralSingleManager.' realizado invitaciones a nuevos usuarios, '.$totalManagersAprobadores['totalMiembros'].' '.$pluralSingle4.' aprobado solicitudes de compra y '.$totalManagersNegadores['totalMiembros'].' '.$pluralSingle5.' rechazado solicitudes de compra.</li>
		</ul>

		<p>Ventas</p><hr> 
		<ul>
			<li>Se actualizó el inventario de '.$totalProductosActualizados['total'].' '.$productosInventario.'.</li>
			<li>'.$pluralAprobadas.' '.$totalOrdenAprobadas['total'].' '.$pluralOrdenesA.'.</li>
			<li>'.$pluralRechazados.' '.$totalOrdenRechazadas['total'].' '.$pluralOrdenesR.'.</li>
			<li>'.$pluralPendiente.' '.$totalOrdenPendientes['total'].' '.$pluralOrdenesP.'.</li>
		</ul>

		<div id="ordenes'.$resultado['empresas_id'].'"  style="width: 1000px;"></div>

		</div>  
	</div>
	';?>

		<!--<img src="linear_plot.php?empresas_id="<?php echo $empresas['id'];?>" alt="" border="0"> -->

	<?php

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
	/*$to = array(
			 	$resultado['email']  => $resultado['email'],
				);*/

	/*$transport = Swift_SmtpTransport::newInstance('smtp.mandrillapp.com', 587);
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
