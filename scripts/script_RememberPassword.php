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

$sql='select * from tbl_users where (type=4 and pendiente=0 and ingresos=0) or (type=3 and pendiente=0 and ingresos=0 and registro_password=1) or (type=2 and ingresos=0 and  id not in(select user_id from tbl_profiles where first_name="Usuario" and last_name="Invitado" and cedula="10111222"))';
$result = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
$subject = 'Has olvidado crear tu contraseña para ingresar a Telotengo';
$from = array('info@telotengo.com' =>'Telotengo');
foreach($result as $resultado)
{

		$enlace='http://telotengo.com/'.$entorno.'user/recovery?activkey='.$resultado['activkey'].'&email='.$resultado['email'].'&solicitud=nueva';
		$body='

	<div>
	     <div style="width:100%;min-height:70px;line-height:70px;background:#000">
	         <img src="https://ci6.googleusercontent.com/proxy/eulxA7clmsEtrKINwkCYvYmNyOnPsspK8IP4C0702GpeqFHGyBdQ_KGyLT6i0ldzSRfkeAkMXVznNWJ2BJ2yU7aI7XTM3F4hEwBBxB9EU1L9KwXtf2kOcPezGw=s0-d-e1-ft#http://telotengo.com/new/themes/bootstrap/images/layout/whitelogo.png" height="40px" style="margin-left:25px;margin-top:15px" class="CToWUd">
	    </div>
	</div>
	<div id="orderDetail" class="row-fluid" style="font-size:15px; padding-top: 23px;">

		<div class="col-md-7 orderInfo no_horizontal_padding" >

		Estimado cliente. <br><br>
		<p>
		Hemos observado que recientemente te has registrado en Telotengo pero aún no has creado tu contraseña. Debes hacerlo a la brevedad posible si quieres empezar a disfrutar de todos los beneficios que te ofrece nuestra plataforma. </p>
		<form>
		 <input onclick="window.location.href='.$enlace.'" type="submit" Value="Go">
		</form>
		<form method="get" action="'.$enlace.'">
	    <input   type="submit" value="Crea tu nueva contraseña" style="
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: normal;
    line-height: 1.428571429;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    cursor: pointer;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    -o-user-select: none;
    user-select: none;
    background-color: #ff5b0b;
    height: 34px;
    border: solid 1px #FFF;
    font-weight: 600;
    border-radius: 0;
    color: #fff;
    margin-left: 41.6%;
"/>
	</form>
		</div>  
	</div>
	';
	$to = array(
			 	$resultado['email']  => $resultado['email'],
				);

	echo "se lo envie a".$resultado['email'];
	$transport = Swift_SmtpTransport::newInstance('smtp.mandrillapp.com', 587);
	$transport->setUsername('Te lo Tengo');
	$transport->setPassword('1GOkG9_dtKzZivouvSRCqA');
	$swift = Swift_Mailer::newInstance($transport);


	$message = new Swift_Message($subject);
	$message->setFrom($from);
	$message->setBody($body, 'text/html');
	$message->setTo($to);
	//$message->addPart($text, 'text/plain');

	if ($recipients = $swift->send($message, $failures))
	{
	 echo 'Message successfully sent!';
	} else {
	 echo "There was an error:";
	 print_r($failures);
	}
	break;
}



mysqli_select_db($link,$baseDatos);
mysqli_set_charset($link,"utf8");
header('Location: http://telotengo.com/'.$entorno);
?>
