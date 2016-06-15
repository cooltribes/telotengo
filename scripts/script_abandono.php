<?php
//////////////////////////////////////////////////////////////ESTAR PENDIENTE DEL IVA///////////////////////////////////
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
		$entorno="";
		$entorno2="";
		$baseDatos="FALTA DEFINIR";  //falta definir


	}
}
$iva=0.12;
$sumIva=1.12;

$path=$_SERVER['DOCUMENT_ROOT']."/".$entorno."protected/extensions/yii-mail/vendors/swiftMailer/swift_required.php";
require $path;
// Conectando, seleccionando la base de datos
$link = mysqli_connect('telotengo.com', 'telotengo', 'SFGth$$%67')
    or die('No se pudo conectar: ' . mysql_error());



mysqli_select_db($link,$baseDatos);
mysqli_set_charset($link,"utf8");

$sql="select * from  tbl_bolsa_has_tbl_inventario group by bolsa_id,almacen_id";
$result = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
foreach($result as $resultado)
{
	//// busco el maxima fecha de modificacion de una intencion de compra
	$sql="select * from  tbl_bolsa_has_tbl_inventario where almacen_id='".$resultado['almacen_id']."'
	 and bolsa_id='".$resultado['bolsa_id']."' order by fecha desc limit 1";
	 //and TIMESTAMPDIFF(WEEK,h.fecha,now())
	 $result2 = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
	 $bolsa_has_inventario = $result2->fetch_assoc();
	 ///comparo fechas para ver si la compra esta abandonada
	 $fecha1 = new DateTime($bolsa_has_inventario['fecha']);
	 $hoy=date("Y-m-d H:i:s"); 
	 $fecha2 = new DateTime($hoy);
	 $diferencia = $fecha1->diff($fecha2);
 	 $bolsa_has_inventario['fecha'];
 	 $daysbetween = $diferencia->format('%d');


	 if($daysbetween>=7) ///////////////////////7 dias//////////////////////////////////////////
	 {
	 	////////////////////busco el ultimo que modifico el carrito//////////////////////////////////////////////////////////
	 	$sql="select * from tbl_historial_bolsa where bolsa_has_inventario_id='".$bolsa_has_inventario['id']."' order by fecha desc limit 1";
	 	$result2 = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
	 	$ultimo_modifico = $result2->fetch_assoc();
	 	$ultimo_modifico['users_id'];
	 	////////////////////////////////busco el que creo el carrito//////////////////////////////////////////////////////////
	 	$sql="select * from tbl_historial_bolsa where bolsa_has_inventario_id='".$bolsa_has_inventario['id']."' order by fecha asc limit 1";
	 	$result2 = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
	 	$creador = $result2->fetch_assoc();
	 	$creador['users_id'];
	 	//////////////////////////////busco los atributos de usuario creador/////////////////////////////////////////
	 	$sql="select * from tbl_users where id='".$creador['users_id']."'";
	 	$result2 = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
	 	$usuario = $result2->fetch_assoc();
	 	///////////////////////////////busco el id de la empresa creadora///////////////////////////////////////////////
	 	$sql="select * from tbl_empresas_has_tbl_users where users_id='".$creador['users_id']."'";
	 	$result2 = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
	 	$empresa = $result2->fetch_assoc();
	 	///////////////////////////////busco el nombre de la empresa creador///////////////////////////////////////////////
	 	$sql="select * from tbl_empresas where id='".$empresa['empresas_id']."'";
	 	$result2 = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
	 	$empresa = $result2->fetch_assoc();
	 	//// el ultimo que modifico es el mismo que creo la intencion de compra
	 	if($creador['users_id']==$ultimo_modifico['users_id'])
	 	{
	 		$to = array(
		 	$usuario['email']  => $usuario['email'], // el segundo campo deberia ir el nombre
			);

			echo "se lo envie a".$usuario['email'];
	 	}
	 	else
	 	{
		 	//busco los atributos de ultimo usuario que modifico la orden
		 	$sql="select * from tbl_users where id='".$ultimo_modifico['users_id']."'";
		 	$result2 = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
		 	$usuario2 = $result2->fetch_assoc();

		 	$to = array(
		 	$usuario['email']  => $usuario['email'], // el segundo campo deberia ir el nombre
		 	$usuario2['email']  => $usuario2['email'], // el segundo campo deberia ir el nombre
			);
		 	echo "se lo envie a".$usuario['email']." y a ".$usuario2['email'];
	 	}
	 	//enviar el correo
	 	$subject = 'Tu carrito de compras';
		$from = array('info@telotengo.com' =>'Telotengo');
		////////////se tiene el almacen de la empresa vendedora///////////////////////////////
		$sql="select * from tbl_almacen where id='".$resultado['almacen_id']."'";
		$result2 = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
		$almacen = $result2->fetch_assoc();
		////////////se tiene la empresa vendedora///////////////////////////////
		$sql="select * from tbl_empresas where id='".$almacen['empresas_id']."'";
		$result2 = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
		$empresaVendedora = $result2->fetch_assoc();
		$up='

<div>
     <div style="width:100%;min-height:70px;line-height:70px;background:#000">
         <img src="https://ci6.googleusercontent.com/proxy/eulxA7clmsEtrKINwkCYvYmNyOnPsspK8IP4C0702GpeqFHGyBdQ_KGyLT6i0ldzSRfkeAkMXVznNWJ2BJ2yU7aI7XTM3F4hEwBBxB9EU1L9KwXtf2kOcPezGw=s0-d-e1-ft#http://telotengo.com/new/themes/bootstrap/images/layout/whitelogo.png" height="40px" style="margin-left:25px;margin-top:15px" class="CToWUd">
    </div>
</div>
<div id="orderDetail" class="row-fluid" style="font-size:15px; padding-top: 23px;">

<div class="col-md-7 orderInfo no_horizontal_padding" >

Estimado cliente. <br><br>

Hemos observado que recientemente has añadido ítems a tu carrito. Si requieres modificar su cantidad o eliminarlo, simplemente visita tu <a href="http://telotengo.com/'.$entorno.'site/carrito">Carrito</a>  para que completes y generes la intención de compra. 
</div>

    <div class="col-md-12 cart no_horizontal_padding">
        <div class="orderContainer" style="margin-top: 4.68em!important; margin-bottom: 2.18em!important;">
                <div style="border: solid 1px #666; font-size: 21px; padding: 10px 5%">
                   <div style="width:100%; height:30px; line-height:30px; vertical-align:middle">
                      <div style="width:100%; float:left; text-align:right">'.$empresaVendedora['razon_social'].'</div>
                   </div>
                </div>
                <div style="border-left: solid 1px #666; border-right: solid 1px #666; padding: 10px 5%;">
                    <table width="100%" style="font-size: 14px; color: #222; max-width:100%">
                        <colgroup>
                        <col width="10%">
                        <col width="30%">
                        <col width="10%">
                        <col width="10%">
                        <col width="10%">
                        <col width="10%">
                        <col width="10%">
                        <col width="10%">
                        </colgroup>
                       <thead>
                            <tr>
                                <th colspan="2" style="background-color: #000; color: #FFF; padding-top: 12px; padding-bottom: 12px;">Producto</th>
                                <th style="background-color: #000; color: #FFF; padding-top: 12px; padding-bottom: 12px; text-align:center">Codigo TLT</th>
                                <th style="background-color: #000; color: #FFF; padding-top: 12px; padding-bottom: 12px; text-align:center" class="text-center">Cantidad</th>
                                <th style="background-color: #000; color: #FFF; padding-top: 12px; padding-bottom: 12px; text-align:center" class="text-center">Precio Unt.</th>
                                <th style="background-color: #000; color: #FFF; padding-top: 12px; padding-bottom: 12px; text-align:center" class="text-center">Sub Total</th>
                                 <th style="background-color: #000; color: #FFF; padding-top: 12px; padding-bottom: 12px; text-align:center" class="text-center">I. V. A.</th>
                                  <th style="background-color: #000; color: #FFF; padding-top: 12px; padding-bottom: 12px; text-align:center" class="text-center">Precio Total</th>
                               
                            </tr>
                        </thead>
                        
                        <tbody>
                        	';

                        $sql="select * from  tbl_bolsa_has_tbl_inventario where almacen_id='".$resultado['almacen_id']."'
	 and bolsa_id='".$resultado['bolsa_id']."'";
	 					$each = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
	 					$foreach='';
	 					$sumas=0;
	 					$acumulado=0;
	 					foreach($each as $cadaUno):

	 					////////////////////////Busco el inventario////////////////////////////////////////////
	 					$sql="select * from  tbl_inventario where id='".$cadaUno['inventario_id']."'";
	 					$result2 = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
		 				$inventario = $result2->fetch_assoc();
		 				////////////////////////Busco el producto////////////////////////////////////////////
	 					$sql="select * from  tbl_producto where id='".$inventario['producto_id']."'";
	 					$result2 = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
		 				$producto = $result2->fetch_assoc();
		 				////////////////////////Busco la imagen////////////////////////////////////////////
	 					$sql="select * from  tbl_imagenes where orden=1 and producto_id='".$inventario['producto_id']."'";
	 					$result2 = mysqli_query($link,$sql) or die('Consulta fallida: ' . mysql_error());
		 				$imagenes = $result2->fetch_assoc();
		 				$ruta="http://telotengo.com/".$entorno2.$imagenes['url'];
                        	$foreach.='
                             <tr>
                             	<td style="text-align: center; font-weight: bolder; font-size: 12px; color: #222; padding-top: 12px; padding-bottom: 12px;"><img width="100%" src="'.$ruta.'"/></td> 

                                <td style="font-weight: 900; padding: 0 10px; padding-top: 12px; padding-bottom: 12px;">
                                '.$producto["nombre"].'</td>

                                <td style="text-align: center; font-weight: bolder; padding-top: 12px; padding-bottom: 12px;">'.$producto["tlt_codigo"].'</td>
                                <td style="text-align: center; font-weight: bolder; padding-top: 12px; padding-bottom: 12px;">'.$cadaUno["cantidad"].'</td>
                                <td style="text-align: center; font-weight: bolder; padding-top: 12px; padding-bottom: 12px;">Bs '.number_format($inventario["precio"],0,",",".").'</td>
                                <td style="text-align: center; font-weight: bolder; padding-top: 12px; padding-bottom: 12px; color: #ec1f24;">Bs '.number_format($inventario["precio"]*$cadaUno["cantidad"],0,",",".").'</td>
                                <td style="text-align: center; font-weight: bolder; padding-top: 12px; padding-bottom: 12px; color: #ec1f24;">Bs '.number_format($inventario["precio"]*$cadaUno["cantidad"]*$iva,0,",",".").'</td>
                                <td style="text-align: center; font-weight: bolder; padding-top: 12px; padding-bottom: 12px; color: #ec1f24;">Bs '.number_format($sumas=$inventario["precio"]*$cadaUno["cantidad"]*$sumIva,0,",",".").'</td>
                                
                                
                            </tr>
                            ';
                            $acumulado+=$sumas;
                         endforeach;

                            $down='
                         </tbody>
                    </table>
                </div>
               

                <div class="summary text-right" style="text-align: right; border: solid 1px #666; height:30px; line-height:30px; vertical-align:middle; padding: 10px 5%">
                    
                    <span id="total" style="font-size: 20px; font-weight: bolder;">Total: Bs '.number_format($acumulado,0,",",".").'</span>
                   
                </div>
            </div>
    </div>
</div>
<div style="text-align: center; margin-top: 15px; font-size:15px;">¡Gracias por participar en Telotengo!</div>
';

		$body=$up.$foreach.$down;

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
		 echo "There was an error:\n";
		 print_r($failures);
		}
	 }

	

}
// Cerrar la conexión
mysqli_close($link);
?>