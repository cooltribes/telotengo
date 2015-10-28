<?php

class User extends CActiveRecord
{
	const STATUS_NOACTIVE=0;
	const STATUS_ACTIVE=1;
	const STATUS_BANNED=-1;
	
	const TYPE_ADMIN = 1;
	const TYPE_INVITADO_EMPRESA = 2;
	const TYPE_INVITADO_CLIENTE = 3;
	const TYPE_USUARIO_SOLICITA = 4;

	//TODO: Delete for next version (backward compatibility)
	const STATUS_BANED=-1;
	
	/**
	 * The followings are the available columns in table 'users':
	 * @var integer $id
	 * @var string $username
	 * @var string $password
	 * @var string $email
	 * @var string $activkey
	 * @var integer $createtime
	 * @var integer $lastvisit
	 * @var integer $superuser
	 * @var integer $status
     * @var timestamp $create_at
     * @var timestamp $lastvisit_at
	 * @var string $facebook_id
	 * @var string $avatar_url
	 */

	/*
	Tipos de usuario (type):
	1 = admin
	2 = Usuario invitado como empresa
	3 = Usuario invitado como cliente
	4 = Usuario que solicita participar enviando datos
		*/

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	
	public $fecha;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return Yii::app()->getModule('user')->tableUsers;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.CConsoleApplication
		return ((get_class(Yii::app())=='CConsoleApplication' || (get_class(Yii::app())!='CConsoleApplication' && Yii::app()->getModule('user')->isAdmin()))?array(
			array('username', 'length', 'max'=>40, 'min' => 3,'message' => UserModule::t("Incorrect username (length between 3 and 40 characters).")),
			array('password', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Incorrect password (minimal length 4 symbols).")),
			array('email', 'email'),
			array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
			array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
			//array('username', 'match', 'pattern' => '/^[A-Za-z0-9_@]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9bbb).")),
			array('status', 'in', 'range'=>array(self::STATUS_NOACTIVE,self::STATUS_ACTIVE,self::STATUS_BANNED)),
			array('superuser', 'in', 'range'=>array(0,1)),
            array('create_at', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
            array('lastvisit_at', 'default', 'value' => '0000-00-00 00:00:00', 'setOnEmpty' => true, 'on' => 'insert'),
			array('email, type', 'required'),
			array('superuser, status', 'numerical', 'integerOnly'=>true),
			array('id, username, password, email, activkey, create_at, lastvisit_at, superuser, status, type, newsletter, facebook_id, avatar_url', 'safe', 'on'=>'search'),
		):((Yii::app()->user->id==$this->id)?array(
			array('email', 'required'),
			array('username', 'length', 'max'=>40, 'min' => 3,'message' => UserModule::t("Incorrect username (length between 3 and 40 characters).")),
			array('email', 'email'),
			array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
			//array('username', 'match', 'pattern' => '/^[A-Za-z0-9_@]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9aaa).")),
			array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
			array('id, username, password, email, activkey, create_at, lastvisit_at, superuser, status, type, newsletter, facebook_id, avatar_url, perfil_completo, quien_invita', 'safe', 'on'=>'search'),
		):array()));
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
        $relations = Yii::app()->getModule('user')->relations;
        if (!isset($relations['profile']))
            $relations['profile'] = array(self::HAS_ONE, 'Profile', 'user_id');
      

        return $relations;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => UserModule::t("Id"),
			//'username'=>UserModule::t("username"),
			'username'=>'Nombre de usuario',
			//'password'=>UserModule::t("password"),
			'password'=>'Contraseña',
			'verifyPassword'=>UserModule::t("Retype Password"),
			'email'=>UserModule::t("Correo electrónico"),
			'verifyCode'=>UserModule::t("Verification Code"),
			'activkey' => UserModule::t("activation key"),
			'createtime' => UserModule::t("Registration date"),
			'create_at' => UserModule::t("Registration date"),
			
			'lastvisit_at' => UserModule::t("Last visit"),
			'superuser' => UserModule::t("Superuser"),
			'status' => UserModule::t("Status"),
			'type' => 'Tipo de invitación',
			'newsletter' => '¿Quieres recibir novedades por email?',
			'avatar_url'=>'Avatar',
			'quien_invita' => '¿Quien realizó la invitación?',
		);
	}
	
	public function scopes()
    {
        return array(
            'active'=>array(
                'condition'=>'status='.self::STATUS_ACTIVE,
            ),
            'notactive'=>array(
                'condition'=>'status='.self::STATUS_NOACTIVE,
            ),
            'banned'=>array(
                'condition'=>'status='.self::STATUS_BANNED,
            ),
            'superuser'=>array(
                'condition'=>'superuser=1',
            ),
            'notsafe'=>array(
            	'select' => 'id, username, password, email, activkey, create_at, lastvisit_at, superuser, status, facebook_id, avatar_url, quien_invita',
            ),
        );
    }
	
	public function defaultScope()
    {
        return CMap::mergeArray(Yii::app()->getModule('user')->defaultScope,array(
            'alias'=>'user',
            'select' => 'user.id, user.username, user.email, user.create_at, user.lastvisit_at, user.superuser, user.status, user.type, user.avatar_url, user.facebook_id, user.activkey, user.quien_invita, user.registro_password',
        ));
    }
	
	public static function itemAlias($type,$code=NULL) {
		$_items = array(
			'UserStatus' => array(
				self::STATUS_NOACTIVE => UserModule::t('Not active'),
				self::STATUS_ACTIVE => UserModule::t('Active'),
				self::STATUS_BANNED => UserModule::t('Banned'),
			),
			'AdminStatus' => array(
				'0' => UserModule::t('No'),
				'1' => UserModule::t('Yes'),
			),
			'UserType' => array (
				self::TYPE_INVITADO_EMPRESA => "Invitar como empresa",
				self::TYPE_INVITADO_CLIENTE => "Invitar como cliente",
			),
		);
		if (isset($code))
			return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
		else
			return isset($_items[$type]) ? $_items[$type] : false;
	}
	
/**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
        
        $criteria->compare('id',$this->id);
        $criteria->compare('username',$this->username,true);
        $criteria->compare('password',$this->password);
        $criteria->compare('email',$this->email,true);
        $criteria->compare('activkey',$this->activkey);
        $criteria->compare('create_at',$this->create_at);
        $criteria->compare('lastvisit_at',$this->lastvisit_at);
        $criteria->compare('superuser',$this->superuser);
        $criteria->compare('status',$this->status);
        $criteria->compare('type',$this->type);
        $criteria->compare('newsletter',$this->newsletter);
		$criteria->compare('facebook_id',$this->facebook_id);
		$criteria->compare('avatar_url',$this->avatar_url);
		#$criteria->addCondition('type <> 3');

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        	'pagination'=>array(
				'pageSize'=>Yii::app()->getModule('user')->user_page_size,
			),
        ));
    }

	   public function buscarDesactivo()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
        
        $criteria->compare('id',$this->id);
        $criteria->compare('username',$this->username,true);
        $criteria->compare('password',$this->password);
        $criteria->compare('email',$this->email,true);
        $criteria->compare('activkey',$this->activkey);
        $criteria->compare('create_at',$this->create_at);
        $criteria->compare('lastvisit_at',$this->lastvisit_at);
        $criteria->compare('superuser',$this->superuser);
        $criteria->compare('status',$this->status);
        $criteria->compare('type',$this->type);
        $criteria->compare('newsletter',$this->newsletter);
		$criteria->compare('facebook_id',$this->facebook_id);
		$criteria->compare('avatar_url',$this->avatar_url);
		$criteria->compare('avatar_url',$this->avatar_url);
		$criteria->compare ('registro_password',0, true);
		$criteria->compare ('superuser',0, true);
		$criteria->addCondition('type <> 3');
		//$criteria->addInCondition('type', array ('1','2', '4'));

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        	'pagination'=>array(
				'pageSize'=>Yii::app()->getModule('user')->user_page_size,
			),
        ));
    }

    public function getCreatetime() {
        return strtotime($this->create_at);
    }

    public function setCreatetime($value) {
        $this->create_at=date('Y-m-d H:i:s',$value);
    }

    public function getLastvisit() {
        return strtotime($this->lastvisit_at);
    }

    public function setLastvisit($value) {
        $this->lastvisit_at=date('Y-m-d H:i:s',$value);
    }

	public function isAdmin() {
        
		$user = User::model()->findByPk($this->id);
		
		if($user->superuser==1)
			return true;
		else
			return false;
		
    }

	/* Funcion para conseguir los ultimos registrados */
	public function getLast(){
	    return $this->findAll(array('limit'=>4,'offset'=>0,'order'=>'id DESC'));
	}

    public function hasEmpresasVendedoras() {
    	$empresas = EmpresasHasUsers::model()->countByAttributes(array('users_id'=>$this->id));
        if($empresas > 0){
        	return true;
        }else{
        	return false;
        }
    }

    /* 
	Action de enviar email al momento de completar el perfil
	*/
	public function mailCompletarPerfil(){
		$user = User::model()->findByPk(Yii::app()->user->id);

		$message = new YiiMailMessage;
        $subject = 'Haz completado tu perfil';                                
        $message->subject = $subject;
        $message->view = "mail_template";
        $body = '<h2>¡Felicitaciones, '.$user->profile->first_name.'!</h2>
				Nos complace informarte que te obsequiaremos un monto de Bs. 500 en tu saldo de cuenta, que podrás usar en tu próxima compra. <br/><br/>
				Para ver tu saldo de tu cuenta ingresa en la sección <b>Tu Perfil</b>.<br/>
				Recuerda que a tu saldo de cuenta puedes ir abonando también con Tarjetas de regalo.<br/>
				Para más información puedes visitar la sección Formas de Pago de nuestra página web.<br/><br/>
				¡Disfruta tus compras en SigmaTiendas!';
        $message->from = array(Yii::app()->params['adminEmail'] => "Sigma Tiendas");
        $message->setBody(array("body"=>$body, "undercomment"=>"Si tienes alguna pregunta acerca de tu cuenta, o cualquier otro asunto, por favor contáctanos en soporte@sigmatiendas.com"),'text/html');              
        $message->addTo($user->email);

        Yii::app()->mail->send($message);
	}

	public function cantidadListas(){
		$user = User::model()->findByPk(Yii::app()->user->id);
		$wishlists = Wishlist::model()->findAllByAttributes(array('users_id'=>$user->id));
		$total=0;

		foreach($wishlists as $wish){
			$productos = WishlistHasProducto::model()->findAllByAttributes(array('wishlist_id'=>$wish->id));
			$total+=count($productos);
		}
		return $total;
	}

	public function cantidadCarro(){
		$user = User::model()->findByPk(Yii::app()->user->id);
		$bolsa = Bolsa::model()->findByAttributes(array('users_id'=>$user->id));
		$productosBolsa = BolsaHasInventario::model()->findAllByAttributes(array('bolsa_id'=>$bolsa->id));		

		return count($productosBolsa);
	}

    static function generarPassword(){
        $cantNum = 4;
        $cantLet = 4;
        
        $l = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        
        $LETRAS = str_split($l);
        $NUMEROS = range(0, 9);

        $codigo = array();
        //Seleccionar cantLet letras
        for ($i = 0; $i < $cantLet; $i++) {
            $codigo[] = $LETRAS[array_rand($LETRAS)];
        }
        for ($i = 0; $i < $cantNum; $i++) {
            $codigo[] = array_rand($NUMEROS);
        }
        
        shuffle($codigo);
        $codigo = implode("", $codigo);
        
        return $codigo;
    }
	
	public function newPassword($id, $rol)
	{
		$user = User::model()->notsafe()->findbyPk($id);
		echo $user->id;
		$activation_url = 'http://' . $_SERVER['HTTP_HOST'].Yii::app()->controller->createUrl(implode(Yii::app()->controller->module->recoveryUrl),array("activkey" => $user->activkey, "email" => $user->email, 
		'solicitud'=>'nueva'));
							
		$message = new YiiMailMessage;
		$message->view = 'mail_template';
		Yii::app()->session['email']=$user->email;
							 
							//userModel is passed to the view
							
		$body=Yii::app()->controller->renderPartial($this->setMsg($rol), array( 'activation_url'=>$activation_url ),true);
		
		$message->setSubject($this->setSubject($rol));
		$message->setBody(array('body'=>$body,"undercomment"=>"¿Pediste registrarte en telotengo? Si no es así, es probable que otro usuario haya utilizado tu dirección de correo electrónico por error al registrarse pero no te preocupes no es necesario que tomes alguna medida, puedes ignorar este mensaje"), 'text/html');
		
		
		$message->addTo($user->email);
		$message->from = array(Yii::app()->params['adminEmail'] => "Sigma Tiendas");
		Yii::app()->mail->send($message);

		//Yii::app()->user->setFlash('success','Las instrucciones para la recuperación de la contraseña se han enviado a tu correo electrónico');
	}


	public function emailEmpresaInvitado($empresa_id, $cargo, $id, $quien_invita)
	{
		$user = User::model()->notsafe()->findbyPk($id);
					
		$message = new YiiMailMessage;
		$message->view = 'mail_template';
		
		Yii::app()->session['email']=$user->email;
		$quien_invita = User::model()->notsafe()->findbyPk($quien_invita);
		Yii::app()->session['quienInvita']=$quien_invita->username;
		
		/*$activation_url = 'http://' . $_SERVER['HTTP_HOST'].Yii::app()->controller->createUrl(implode(Yii::app()->controller->module->recoveryUrl),array("id"=>$id,
		"u"=>$quien_invita->username,"activkey" => $user->activkey, "email" => $user->email, 
		'solicitud'=>'nueva'));*/
		
		$activation_url = 'http://' . $_SERVER['HTTP_HOST'].Yii::app()->controller->createUrl('/user/user/datos/',array("id"=>$id,
		"u"=>$quien_invita->username,"activkey" => $user->activkey, "email" => $user->email, 
		'solicitud'=>'nueva', 'tipo'=>'empresa'));
		
		Yii::app()->session['rol']=$this->buscarRol($id);
		Yii::app()->session['cargo']=$cargo;
		Yii::app()->session['invitadoempresa']=$id;
		//Yii::app()->session['activacion_url']=$activation_url;
							 
							//userModel is passed to the view
							
		$body=Yii::app()->controller->renderPartial('//mail/registroEmpresaInvitado', array( 'activation_url'=>$activation_url ),true);
		
		$message->setSubject("INVITADO COMO MIEMBRO DE EMPRESA");
		$message->setBody(array('body'=>$body,"undercomment"=>"¿Pediste registrarte en telotengo? Si no es así, es probable que otro usuario haya utilizado tu dirección de correo electrónico por error al registrarse pero no te preocupes no es necesario que tomes alguna medida, puedes ignorar este mensaje"), 'text/html');
		
		
		$message->addTo($user->email);
		$message->from = array(Yii::app()->params['adminEmail'] => "Sigma Tiendas");
		Yii::app()->mail->send($message);

		//Yii::app()->user->setFlash('success','Las instrucciones para la recuperación de la contraseña se han enviado a tu correo electrónico');
	}

	public function emailClienteInvitado($id, $quien_invita)
	{
		$user = User::model()->notsafe()->findbyPk($id);
					
		$message = new YiiMailMessage;
		$message->view = 'mail_template';
		
		$quien_invita = User::model()->notsafe()->findbyPk($quien_invita);
		Yii::app()->session['quienInvita']=$quien_invita->username;
		
		$activation_url = 'http://' . $_SERVER['HTTP_HOST'].Yii::app()->controller->createUrl('/user/user/datos/',array("id"=>$id,
		"u"=>$quien_invita->username,"activkey" => $user->activkey, "email" => $user->email, 
		'solicitud'=>'nueva', 'tipo'=>'cliente'));
		
		$body=Yii::app()->controller->renderPartial('//mail/registroClienteInvitado', array( 'activation_url'=>$activation_url ),true);
		
		$message->setSubject("INVITADO COMO EMPRESA");
		$message->setBody(array('body'=>$body,"undercomment"=>"¿Te invitaron a telotengo? Si no es así, es probable que un usuario haya utilizado tu dirección de correo electrónico por error al enviar una invitación pero no te preocupes no es necesario que tomes alguna medida, puedes ignorar este mensaje."), 'text/html');
		
		
		$message->addTo($user->email);
		$message->from = array(Yii::app()->params['adminEmail'] => "Sigma Tiendas");
		Yii::app()->mail->send($message);
		
	}

  		public function buscarSexo($sexo)
		{
			if($sexo==2)
				return "M";
			else
				return "F";	
		} 
		
		public function buscarSector($sector)
		{
			switch ($sector) {
				case 1:
					echo 'Alimentos';
					break;
				case 2:
					echo 'Mayor';
					break;
				case 3:
					echo 'Menor';
					break;
				case 4:
					echo 'Industrial';
					break;
				case 5:
					echo 'Construccion';
					break;
				case 6:
					echo 'Entretenimiento';
					break;				
				case 7:
					echo 'Hoteleria';
					break;				
				case 8:
					echo 'Informatica';
					break;				
				case 9:
					echo 'Salud';
					break;				
				case 10:
					echo 'Servicio';
					break;
				case 11:
					echo 'Transporte';
					break;
				case 12:
					echo 'Otro';
					break;
				case 13:
					echo 'Agropecuaria';
					break;
				case 14:
					echo 'Banca';
					break;
				case 15:
					echo 'Energia';
					break;
				case 16:
					echo 'Educacion';
					break;																													
				}
		}
		
		public function buscarRol($id)
		{
			if(Yii::app()->authManager->checkAccess("vendedor", $id))
				return "vendedor";
			if(Yii::app()->authManager->checkAccess("comprador", $id))
				return "comprador";
			if(Yii::app()->authManager->checkAccess("compraVenta", $id))
				return "compraVenta";
		}
		
		public function setSubject($rol)
		{
			if($rol=="vendedor")
				return "APROBADO COMO VENDEDOR";
			if($rol=="comprador")
				return "APROBADO COMO COMPRADOR";
			if($rol=="compraVenta")
				return "APROBADO COMO COMPRADOR Y VENDEDOR";

		}
		
		public function setMsg($rol)
		{
			if($rol=="vendedor")
				return "//mail/registroVendedor";
			if($rol=="comprador")
				return "//mail/registroComprador";
			if($rol=="compraVenta")
				return "//mail/registroAmbos";
		}
        
        public function getEmpresa(){
            $ehu=EmpresasHasUsers::model()->findByAttributes(array('users_id'=>Yii::app()->user->id));
            return Empresas::model()->findByPk($ehu->empresas_id);
        }
        public function getBolsa(){
            return $this->empresa->bolsa;
        }
        
        
}