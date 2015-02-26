<?php

class ActivationController extends Controller
{
	public $defaultAction = 'activation';

	
	/**
	 * Activation user account
	 */
	public function actionActivation () {
		$email = $_GET['email'];
		$activkey = $_GET['activkey'];
		if ($email&&$activkey) {
			$find = User::model()->notsafe()->findByAttributes(array('email'=>$email));
			if (isset($find)&&$find->status) {
			    $this->render('/user/message',array('title'=>UserModule::t("User activation"),'content'=>UserModule::t("You account is active.")));
			} elseif(isset($find->activkey) && ($find->activkey==$activkey)) {
				$user = User::model()->findByPk($email);
				$message = new YiiMailMessage;
                $subject = 'Bienvenido(a) '.$_GET['email'];                              
                $message->subject = $subject;
                $message->view = "mail_template";
                $body = 'Bienvenido(a) a SigmaTiendas.

                	<br/><br/>Tu correo electrónico registrado: '.$_GET['email'].'

                	Cuando accedas a tu cuenta, podrás:<br/>
                	<br/>– Proceder más rápido en el proceso de compra
                	<br/>– Verificar el estado de tus pedidos
                	<br/>– Ver Pedidos antiguos
                	<br/>– Hacer cambios en la información de tu cuenta
					<br/>– Cambiar tu Contraseña
					<br/>– Guardar direcciones alternativas (¡Para enviarle a diferentes miembros de la familia y amigos!)
					<br/><br/>Gracias por confiar en nosotros.
                	';
                $message->from = array(Yii::app()->params['adminEmail'] => "Sigma Tiendas");
                $message->setBody(array("body"=>$body, "undercomment"=>"Si tienes alguna pregunta acerca de tu cuenta, o cualquier otro asunto, por favor contáctanos en soporte@sigmatiendas.com"),'text/html');              
                $message->addTo($_GET['email']);

	            Yii::app()->mail->send($message);

				$find->activkey = UserModule::encrypting(microtime());
				$find->status = 1;
				$find->save();
			    $this->render('/user/message',array('title'=>UserModule::t("User activation"),'content'=>UserModule::t("You account is activated.")));
			} else {
			    $this->render('/user/message',array('title'=>UserModule::t("User activation"),'content'=>UserModule::t("Incorrect activation URL.")));
			}
		} else {
			$this->render('/user/message',array('title'=>UserModule::t("User activation"),'content'=>UserModule::t("Incorrect activation URL.")));
		}
	}

}