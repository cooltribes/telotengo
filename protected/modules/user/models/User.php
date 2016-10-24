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
	
	public static $statuses = array(self::STATUS_ACTIVE => 'Activo', 
        self::STATUS_NOACTIVE => 'Inactivo');

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
        $relations['invited_by']=array(self::BELONGS_TO, 'User', 'quien_invita');
        $relations['empresaRel']=array(self::MANY_MANY, 'Empresas', 'tbl_empresas_has_tbl_users(users_id,empresas_id,)');
      

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
            	'select' => 'id, username, password, email, activkey, create_at, lastvisit_at, superuser, status, facebook_id, avatar_url, quien_invita, pendiente',
            ),
        );
    }
	
	public function defaultScope()
    {
        return CMap::mergeArray(Yii::app()->getModule('user')->defaultScope,array(
            'alias'=>'user',
            'select' => 'user.id, user.username, user.email, user.create_at, user.lastvisit_at, user.superuser, user.status, user.type, user.avatar_url, user.facebook_id, user.activkey, user.quien_invita, user.registro_password, user.ingresos',
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
				self::TYPE_INVITADO_EMPRESA => "Invitar como miembro de empresa",
				self::TYPE_INVITADO_CLIENTE => "Invitar como nueva empresa",
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
        //$criteria->compare('username',$this->username,true);
        $criteria->addCondition("username LIKE '%".$this->username."%'",'OR');
        $criteria->addCondition("email LIKE '%".$this->email."%'",'OR');
		//$criteria->addCondition("status = '1'",'AND');
        $criteria->compare('password',$this->password);
        //$criteria->compare('email',$this->email,true);
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
		$criteria->addCondition('(type=4 and pendiente=0) or (type=3 and pendiente=0 and registro_password=1) or (type=2 and  id not in (select user_id from tbl_profiles where first_name="Usuario" and last_name="Invitado" and cedula="10111222"))');

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        	'pagination'=>array(
				'pageSize'=>Yii::app()->getModule('user')->user_page_size,
			),
        ));
    }

	   public function buscarDesactivo($query=NULL)
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
        
       /* $criteria->compare('id',$this->id);
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
		$criteria->compare ('pendiente',1, true);
		#$criteria->compare ('registro_password',0, true);
		$criteria->compare ('superuser',0, true);
		#$criteria->addCondition('type <> 3');
		$criteria->order = "id DESC";
		//$criteria->addInCondition('type', array ('1','2', '4'));*/

		$criteria->addCondition("pendiente = '1'",'AND');
		$criteria->addCondition("superuser = '0'",'AND');
		$condicion=
		$var="";
		if(isset($query))
		{	
			$var=explode(" ", $query);
			if(isset($var[1]))
			{
				$sql="id in (select user_id from tbl_profiles 
				where first_name like '%".$var[0]."%' and last_name like '%".$var[1]."%'
				)";
				/*$criteria->addCondition("id in (select user_id from tbl_profiles 
				where first_name like '%".$var[0]."%' and last_name like '%".$var[1]."%'
				)",'AND');	*/
			}
			else
			{
				$sql="id in (select user_id from tbl_profiles 
				where first_name like '%".$query."%' or last_name like '%".$query."%'
				)";
				/*$criteria->addCondition("id in (select user_id from tbl_profiles 
				where first_name like '%".$query."%' or last_name like '%".$query."%'
				)",'AND');	*/
			}
		}
		else
		{
			$sql="id in (select user_id from tbl_profiles 
				where first_name like '%".$query."%' or last_name like '%".$query."%'
				)";
			/*$criteria->addCondition("id in (select user_id from tbl_profiles 
			where first_name like '%".$query."%' or last_name like '%".$query."%'
			)",'AND');	*/
		}

		$sql2="id in (select users_id from tbl_empresas_has_tbl_users where empresas_id in 
			(select id from tbl_empresas where razon_social like '%".$query."%'))";
		
		$sql=$sql." or ".$sql2;
		$criteria->addCondition($sql,'AND');	

		$criteria->order = "id DESC";

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
		$message->activarPlantillaMandrill();
		Yii::app()->session['email']=$user->email;
							 
							
		$body=Yii::app()->controller->renderPartial($this->setMsg($rol), array( 'activation_url'=>$activation_url ),true);
		
		$message->subject= $this->setSubject($rol);
		$message->setBody($body,'text/html');
		
		
		$message->addTo($user->email);
		Yii::app()->mail->send($message);

		//Yii::app()->user->setFlash('success','Las instrucciones para la recuperación de la contraseña se han enviado a tu correo electrónico');
	}


	public function emailEmpresaInvitado($empresa_id, $cargo, $id, $quien_invita)
	{
		$user = User::model()->notsafe()->findbyPk($id);
					
		$message = new YiiMailMessage;
		$message->activarPlantillaMandrill();
		
		Yii::app()->session['email']=$user->email;
		$quien_invita = User::model()->notsafe()->findbyPk($quien_invita);
		Yii::app()->session['quienInvita']=$quien_invita->username;
		
		$activation_url = 'http://' . $_SERVER['HTTP_HOST'].Yii::app()->controller->createUrl('/user/user/datos/',array("id"=>$id,
		"u"=>$quien_invita->username,"activkey" => $user->activkey, "email" => $user->email, 
		'solicitud'=>'nueva', 'tipo'=>'empresa'));
		
		Yii::app()->session['rol']=$this->buscarRol($id);
		Yii::app()->session['cargo']=$cargo;
		Yii::app()->session['invitadoempresa']=$id;
		
		$body=Yii::app()->controller->renderPartial('//mail/registroEmpresaInvitado', array( 'activation_url'=>$activation_url, 'empresa_id'=>$empresa_id ),true);
		
		$message->subject="Invitado como miembro de empresa";
		$message->setBody($body,'text/html');
		
		
		$message->addTo($user->email);
		Yii::app()->mail->send($message);

		//Yii::app()->user->setFlash('success','Las instrucciones para la recuperación de la contraseña se han enviado a tu correo electrónico');
	}

	public function emailClienteInvitado($id, $quien_invita)
	{
		$user = User::model()->notsafe()->findbyPk($id);
					
		$message = new YiiMailMessage;
		$message->activarPlantillaMandrill();
		
		$quien_invita = User::model()->notsafe()->findbyPk($quien_invita);
		Yii::app()->session['quienInvita']=$quien_invita->username;
		
		$activation_url = 'http://' . $_SERVER['HTTP_HOST'].Yii::app()->controller->createUrl('/user/user/datos/',array("id"=>$id,
		"u"=>$quien_invita->username,"activkey" => $user->activkey, "email" => $user->email, 
		'solicitud'=>'nueva', 'tipo'=>'cliente'));
		
		$body=Yii::app()->controller->renderPartial('//mail/registroClienteInvitado', array( 'activation_url'=>$activation_url ),true);
		
		$message->subject="Invitado como empresa";
		$message->setBody($body,'text/html');
		
		$message->addTo($user->email);
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
				return "Aprobado como vendedor";
			if($rol=="comprador")
				return "Aprobado como comprador";
			if($rol=="compraVenta")
				return "Aprobado como compra/venta";

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
            $ehu=EmpresasHasUsers::model()->findByAttributes(array('users_id'=>$this->id));
            if($ehu)
                return Empresas::model()->findByPk($ehu->empresas_id);
            else
                return new Empresas;
        }
        public function getBolsa(){
            return $this->empresa->bolsa;
        }
        public function getCargo($empresa = false){
            $ehu=EmpresasHasUsers::model()->findByAttributes(array('users_id'=>Yii::app()->user->id));
            if($ehu){
                if($empresa)
                    return $ehu->rol." en ".$this->getEmpresa()->razon_social;
                else
                    return $ehu->rol;
            }
                
            else
                return "N/D";
        }
		
		public function getPuesto($identificador)
		{
			$ehu=EmpresasHasUsers::model()->findByAttributes(array('users_id'=>$identificador));
            if($ehu){
                    return $ehu->rol." en ".$this->getEmpresa2($identificador)->razon_social;
            }
                
            else
                return "N/D";
		}
		
		   public function getEmpresa2($identificador){
            $ehu=EmpresasHasUsers::model()->findByAttributes(array('users_id'=>$identificador));
            return Empresas::model()->findByPk($ehu->empresas_id);
        }
           
           public function getInvitedUsers(){
               
            $criteria=new CDbCriteria;            
            
            $criteria->addCondition('type IN (1,2,3)');
            $criteria->order='id desc';
    
            return new CActiveDataProvider(get_class($this), array(
                'criteria'=>$criteria,
                'pagination'=>array(
                    'pageSize'=>Yii::app()->getModule('user')->user_page_size,
                ),
            ));
               
           }
           
           public function searchInvited($query){
               if(str_replace(' ', '', $query)!=''){
                   $ids=Yii::app()->db->createCommand("select u.id from tbl_profiles p JOIN tbl_users u ON p.user_id=u.id where ".Funciones::long_query($query,"p.last_name")." OR ".Funciones::long_query($query,"p.first_name")." OR ".Funciones::long_query($query,"u.email"). " AND u.type IN (1,2,3)")->queryColumn();
                   $invs=Yii::app()->db->createCommand("select quien_invita from tbl_users where type IN (1,2,3) ")->queryColumn();
                   if(count($invs)>0)
                        $inviters=Yii::app()->db->createCommand("select u.id from tbl_profiles p JOIN tbl_users u ON p.user_id=u.id where ".Funciones::long_query($query,"p.last_name")." OR ".Funciones::long_query($query,"p.first_name")." OR ".Funciones::long_query($query,"u.email"). " AND id IN(".implode(',',$invs).")")->queryColumn();
                   $criteria=new CDbCriteria;
                    if(count(array_merge($ids,$inviters))>0)
                        $criteria->addCondition(" id IN (".implode(',',array_merge($ids,$inviters)).")");
                    else
                            $criteria->addCondition(" id = 0");
                    return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                    ));
               }
               else
                return $this->invitedUsers;
        
           }
           
           public function countInvited($type = null){
               if(is_null($type))
                    return Yii::app()->db->createCommand("SELECT COUNT(id) from tbl_users where type IN (2,3,4)")->queryScalar();               
               return Yii::app()->db->createCommand("SELECT COUNT(id) from tbl_users where type =".$type)->queryScalar();
           }
           
           public function getPartners($objects=true){
              
               $ids=Yii::app()->db->createCommand("SELECT users_id from tbl_empresa_has_tbl_users where empresas_id = ".$this->empresaRel->id)->queryColumn();   
               if($objects){
                   return $this->findAll("id IN (".count($ids)>0?implode(",",$ids):"0".")");
               }
               else
                   return $ids;
           }
           
           public function countByAssignment($rol=""){
               $condition="";    
               if($rol!="all")
                $condition="itemname = '".$rol."' and ";                    
               return Yii::app()->db->createCommand("SELECT count(itemname) from tbl_authAssignment WHERE ".$condition." userid IN( select id from tbl_users where (type=4 and pendiente=0) or (type=3 and pendiente=0 and registro_password=1) or (type=2 and  id not in (select user_id from tbl_profiles where first_name='Usuario' and last_name='Invitado' and cedula='10111222')))")->queryScalar();   
           }

          	public static function getStatus($key = null) 
          	{
        		if ($key !== null)
            		return self::$statuses[$key];
        		return self::$statuses;
    		}
    		    public function buscarPorFiltros($filters) 
    		    {

        $criteria = new CDbCriteria;

        $criteria->with = array();
        $criteria->select = array();
         
        /*Ver si hay un filtro para PS*/
        $paraPS = false;
        foreach ($filters['fields'] as $key => $campo) {
            if(strpos($campo, "_2")){
                $paraPS = true;                          
                $filters['fields'][$key] = strtr($campo, array("_2"=>"")); 
            }
        }
        //buscar solo dentro de los PS
        if($paraPS) $criteria->compare("personal_shopper", 1);

        //recorrer los filtros para armar el criteria
        for ($i = 0; $i < count($filters['fields']); $i++) {

            $column = $filters['fields'][$i];
            $value = $filters['vals'][$i];
            $comparator = $filters['ops'][$i];
            
            if ($i == 0) 
            {
                $logicOp = 'AND';
            } 
            else
            {
                $logicOp = $filters['rels'][$i - 1];
            }

            $criteria->addCondition('(type=4 and pendiente=0) or (type=3 and pendiente=0 and registro_password=1) or (type=2 and  id not in (select user_id from tbl_profiles where first_name="Usuario" and last_name="Invitado" and cedula="10111222"))');
            /* Usuarios */
            if ($column == 'email' || $column == 'ciudad' || $column == 'first_name' || $column == 'last_name')
            {
                
                $value = ($comparator == '=') ? "=" . $value . "" : $value;

                $criteria->compare($column, $value, true, $logicOp);

                continue;
            }

            if ($column == 'zoho_id')
            {
                $criteria->addCondition('(zoho_id = "" OR zoho_id IS NULL'.')', $logicOp);

                continue;
            }
            
            if ($column == 'telefono')
            {                
                
                $value = ($comparator == '=') ? "= '".$value."'" : "LIKE '%".$value."%'";

                $criteria->addCondition('telefono '.$value, $logicOp);

                continue;
            }
            
            if($column === 'ordenAprobada') 
            {
            	
            	$criteria->addCondition('id in (select id_vendedor from tbl_orden where estado=1 group by id_vendedor having count(id_vendedor)'.$comparator.$value.')', $logicOp);   
                continue;
                
            }
            if($column === 'ordenCancelada') 
            {
            	
            	$criteria->addCondition('id in (select id_vendedor from tbl_orden where estado=2 group by id_vendedor having count(id_vendedor)'.$comparator.$value.')', $logicOp);   
                continue;
                
            }
            if($column === 'ordenGeneradaPendiente') 
            {
            	
            	$criteria->addCondition('id in (select users_id from tbl_orden where estado=0 group by users_id having count(users_id)'.$comparator.$value.')', $logicOp);   
                continue;
                
            }
            if($column === 'ordenGeneradaAprobada') 
            {
            	
            	$criteria->addCondition('id in (select users_id from tbl_orden where estado=1 group by users_id having count(users_id)'.$comparator.$value.')', $logicOp);   
                continue;
                
            }
            if($column === 'ordenGeneradaCancelada') 
            {
            	
            	$criteria->addCondition('id in (select users_id from tbl_orden where estado=2 group by users_id having count(users_id)'.$comparator.$value.')', $logicOp);   
                continue;
                
            }

            if($column === 'ordenMontoAprobada') 
            {
            	
            	$criteria->addCondition('id in (select id_vendedor from tbl_orden where estado=1 and monto'.$comparator.$value.')', $logicOp);   
                continue;
                
            }
            if($column === 'ordenMontoCancelada') 
            {
            	
            	$criteria->addCondition('id in (select id_vendedor from tbl_orden where estado=2 and monto'.$comparator.$value.')', $logicOp);   
                continue;
                
            }
             if($column === 'ordenMontoGeneradaPendiente') 
            {
            	
            	$criteria->addCondition('id in (select users_id from tbl_orden where estado=0 and monto'.$comparator.$value.')', $logicOp);   
                continue;
                
            }
            if($column === 'ordenMontoGeneradaAprobada') 
            {
            	
            	$criteria->addCondition('id in (select users_id from tbl_orden where estado=1 and monto'.$comparator.$value.')', $logicOp);   
                continue;
                
            }
            if($column === 'ordenMontoGeneradaCancelada') 
            {
            	
            	$criteria->addCondition('id in (select users_id from tbl_orden where estado=2 and monto'.$comparator.$value.')', $logicOp);   
                continue;
                
            }
             if($column === 'cantItemComprado') 
            {
            	
            	$criteria->addCondition('id in (select users_id from tbl_orden where id in (select orden_id from tbl_orden_has_inventario group by orden_id having sum(cantidad)'.$comparator.$value.'))', $logicOp);   
                continue;
                
            }
            
     
            

            /*if($column === 'status')
            {
                if($value === '1')
                {
                    $criteria->compare("status", $comparator.'1', false, $logicOp);

                }else if($value === 'comprador') 
                {
                    $criteria->compare("status", $comparator.'0', false, $logicOp);
   
                }
                
                continue;
                
            }*/



             if($column === 'tipoUsuario')
            {
                if($value === 'admin')
                {
                    $criteria->compare("superuser", $comparator.'1', false, $logicOp);

                }else if($value === 'comprador') //WHERE (personal_shopper=:ycp1)
                {
                    $criteria->addCondition('id in (select userid from tbl_authAssignment  where itemname'.$comparator.'"comprador")', $logicOp);
   
                }else if($value === 'vendedor')
                {
                    $criteria->addCondition('id in (select userid from tbl_authAssignment  where itemname'.$comparator.'"vendedor")', $logicOp);

                    
                }else if($value === 'compraVenta')
                {
                    $criteria->addCondition('id in (select userid from tbl_authAssignment  where itemname'.$comparator.'"compraVenta")', $logicOp);

                    
                }
                
                continue;
                
            }
			if($column === 'rol')
            {
                if($value === 'administrador')
                    $criteria->addCondition('id in (select users_id from tbl_empresas_has_tbl_users where admin=1)', $logicOp);
                else 
                    $criteria->addCondition('id in (select users_id from tbl_empresas_has_tbl_users where admin=0)', $logicOp);
                
                continue;
                
            }
            

            if($column === 'interno'){
                $criteria->compare("interno", $comparator.$value, false, $logicOp);
                continue;
            }

         
            
            if ($column == 'lastvisit_at' || $column == 'create_at' || $column == 'birthday')
            {
               
                $value = strtotime($value);
                $value = date('Y-m-d H:i:s', $value);
                $criteria->addCondition('date('.$column.')'.$comparator.'"'.$value.'"', $logicOp);

                continue;
            }

             if ($column == 'fechaOrdenAprobada' || $column == 'fechaOrdenCancelada')
            {
                if($column == 'fechaOrdenAprobada')
                	$estado=1;
                if($column == 'fechaOrdenCancelada')
                	$estado=2;
                echo $estado;
                $value = strtotime($value);
                $value = date('Y-m-d H:i:s', $value);

                $model=OrdenEstado::model()->findAllBySql('select * from tbl_orden_estado n where fecha= (select max(fecha) from tbl_orden_estado where estado='.$estado.' group by orden_id having orden_id=n.orden_id) and date(fecha)'.$comparator.'"'.$value.'"');
            	$vec=ARRAY();
				foreach($model as $modelado):
					$vec[]=$modelado->orden_id;
				endforeach;
				if(!empty($vec))
				{
					$model2=Orden::model()->findAllBySql('select * from tbl_orden where id in('.implode(',', $vec).')');
					$vec2=ARRAY();
					foreach($model2 as $modelado2):
						$vec2[]=$modelado2->id_vendedor;
					endforeach;
					if(!empty($vec2))
						$criteria->addCondition('id in('.implode(',', $vec2).')', $logicOp);
					else
						$criteria->addCondition('id in(0)', $logicOp);
	               
	                #$criteria->addCondition('id in (select id_vendedor from tbl_orden where estado=1 and date(fecha)'.$comparator.'"'.$value.'")', $logicOp);
				}
				else
					$criteria->addCondition('id in(0)', $logicOp);

                continue;
            }

            if ($column == 'fechaOrdenGeneradaPendiente')
            {
               
                $value = strtotime($value);
                $value = date('Y-m-d H:i:s', $value);
                $criteria->addCondition('id in (select users_id from tbl_orden where estado=0 and date(fecha)'.$comparator.'"'.$value.'")', $logicOp);

                continue;
            }
             if ($column == 'fechaOrdenGeneradaAprobada')
            {
               
                $value = strtotime($value);
                $value = date('Y-m-d H:i:s', $value);
                $criteria->addCondition('id in (select users_id from tbl_orden where estado=1 and date(fecha)'.$comparator.'"'.$value.'")', $logicOp);

                continue;
            }
            if ($column == 'fechaOrdenGeneradaCancelada')
            {
               
                $value = strtotime($value);
                $value = date('Y-m-d H:i:s', $value);
                $criteria->addCondition('id in (select users_id from tbl_orden where estado=2 and date(fecha)'.$comparator.'"'.$value.'")', $logicOp);

                continue;
            }
             if ($column == 'empresa')
            {
                $value = ($comparator == '=') ? "= '".$value."'" : "LIKE '%".$value."%'";
                $criteria->addCondition('id in(select users_id from tbl_empresas_has_tbl_users where empresas_id in (select id from tbl_empresas where razon_social '.$value.'))');
                continue;
            }

           /* if($column == 'first_name' || $column == 'last_name')
            {
            	$consulta=$this->buscarNombreApellido($value, $comparator, $column);
                $criteria->addCondition($consulta, $logicOp);
            	continue;
            }*/

            

            //Comparar normal
            $criteria->compare($column, $comparator . " " . $value, false, $logicOp);
        }
        
        $criteria->together = true;        

//        echo "<br>Criteria:<br>";
//        echo "<pre>";
//        print_r($criteria->toArray());
//        echo "</pre>";
//        Yii::app()->end();   


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function buscarNombreApellido($value, $comparator, $column) // es diferente  a la otra funcion existente en el modelo de orden
    {
        $consulta="";
    	$var=explode(" ", $value);
    	if(count($var)==2)
    	{
    		$dosResultados=$var[0]." ".$var[1];
    		$consulta=$column.$comparator."'".$var[0]."' or ".$column.$comparator."'".$dosResultados."'";
    	}
    	else
    	{
    		$consulta=$column.$comparator."'".$var[0]."'";
    	}
		return $consulta;
    }

    public function otroAdmin($id) { // para saber si el id que estamos buscando es admin
        
		$user = User::model()->findByPk($id);
		
		if($user->superuser==1)
			return true;
		else
			return false;
		
    }
     public function busqueda($empresas_id)
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
        
        $criteria->compare('id',$this->id);
        //$criteria->compare('username',$this->username,true);
        $criteria->addCondition("username LIKE '%".$this->username."%'",'OR');
        $criteria->addCondition("email LIKE '%".$this->email."%'",'OR');
		//$criteria->addCondition("status = '1'",'AND');
        $criteria->compare('password',$this->password);
        //$criteria->compare('email',$this->email,true);
        $criteria->compare('activkey',$this->activkey);
        $criteria->compare('create_at',$this->create_at);
        $criteria->compare('lastvisit_at',$this->lastvisit_at);
        $criteria->compare('superuser',$this->superuser);
        $criteria->compare('status',$this->status);
        $criteria->compare('type',$this->type);
        $criteria->compare('newsletter',$this->newsletter);
		$criteria->compare('facebook_id',$this->facebook_id);
		$criteria->compare('avatar_url',$this->avatar_url);
		$criteria->alias = 'u';
		$criteria->join="join tbl_empresas_has_tbl_users em on u.id=em.users_id join tbl_profiles p on p.user_id=u.id";
		$criteria->addCondition("p.first_name LIKE '%".$this->username."%'",'OR');
		$criteria->addCondition("p.last_name LIKE '%".$this->username."%'",'OR');
		$criteria->addCondition('em.empresas_id='.$empresas_id, 'AND');
		$criteria->addCondition('(u.type=4 and u.pendiente=0) or (u.type=3 and u.pendiente=0 and u.registro_password=1) or (u.type=2 and  u.id not in (select user_id from tbl_profiles where first_name="Usuario" and last_name="Invitado" and cedula="10111222"))');

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        	'pagination'=>array(
				'pageSize'=>Yii::app()->getModule('user')->user_page_size,
			),
        ));
    }
        
}