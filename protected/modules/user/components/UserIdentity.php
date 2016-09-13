<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	const ERROR_EMAIL_INVALID=3;
	const ERROR_STATUS_NOTACTIV=4;
	const ERROR_STATUS_BAN=5;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		if (strpos($this->username,"@")) {
			$user=User::model()->notsafe()->findByAttributes(array('email'=>$this->username));
		} else {
			$user=User::model()->notsafe()->findByAttributes(array('username'=>$this->username));
		}
		if($user===null)
			if (strpos($this->username,"@")) {
				$this->errorCode=self::ERROR_EMAIL_INVALID;
			} else {
				$this->errorCode=self::ERROR_USERNAME_INVALID;
			}
		else if(Yii::app()->getModule('user')->encrypting($this->password)!==$user->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else if($user->status==0&&Yii::app()->getModule('user')->loginNotActiv==false)
			$this->errorCode=self::ERROR_STATUS_NOTACTIV;
		else if($user->status==-1)
			$this->errorCode=self::ERROR_STATUS_BAN;
		else {
			$this->_id=$user->id;
			$this->username=$user->username;
			$this->errorCode=self::ERROR_NONE;
			/// aqui va la funcion
			if($user->ingresos==0 && $user->type!=4 && $user->quien_invita!=1)/// TODO esto hay que mejorarlo, y colocar que no sea ningun administrador principal( solo hay un administrador)
			{
				if($user->type==2) /// invitacion como miembro de empresa,
				{  
					$miEmpresa=EmpresasHasUsers::model()->findByAttributes(array('users_id'=>$user->id));
					$emp=EmpresasHasUsers::model()->findAllByAttributes(array('empresas_id'=>$miEmpresa->empresas_id, 'admin'=>1));
					foreach($emp as $empresa)
					{
					    #echo "asda"; Yii::app()->end();
					    $message = new YiiMailMessage;
                        $message->activarPlantillaMandrill();                   
                        $body=Yii::app()->controller->renderPartial('//mail/mail_informacion_miembro_empresa', array( 'nombreCompleto'=>Profile::model()->retornarNombreCompleto($user->id), 'user'=>$user),true);             
                        $message->subject= 'Hay un nuevo miembro en tu empresa';
                        #$userSend=EmpresasHasUsers::model()->findByAttributes(array('users_id'=>$empresa->users_id));
                        $userSend=User::model()->findByPk($empresa->users_id);
                        $message->setBody($body,'text/html');                           
                        $message->addTo($userSend->email);
                        Yii::app()->mail->send($message);
					}
				}
			} 
			$user->ingresos+=1;
			$user->lastvisit_at=date("Y-m-d H:i:s");
			$user->save();
			$user->refresh();

			$historial= new HistorialVisitas;
			$historial->id_user=$user->id;
			$historial->fecha=date("Y-m-d H:i:s");
			$historial->save();

		}
		return !$this->errorCode;
	}
    
    /**
    * @return integer the ID of the user record
    */
	public function getId()
	{
		return $this->_id;
	}
}