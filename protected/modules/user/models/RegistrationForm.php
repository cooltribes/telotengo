<?php
/**
 * RegistrationForm class.
 * RegistrationForm is the data structure for keeping
 * user registration form data. It is used by the 'registration' action of 'UserController'.
 */
class RegistrationForm extends User {
	public $verifyPassword;
	public $verifyCode;
	
	public function rules() {
		$rules = array(
			array('password, email', 'required', 'message'=>'No puede estar vacío'),
			array('username', 'length', 'max'=>40, 'min' => 3,'message' => 'Nombre de usuario debe tener entre 3 y 40 caracteres'),
			array('password', 'length', 'max'=>128, 'min' => 4,'tooShort' => 'Debe tener al menos 4 caracteres'),
			array('email', 'email', 'message'=>'No es un correo electrónico válido'),
			array('username', 'unique', 'message' => 'El nombre de usuario ya existe'),
			array('email', 'unique', 'message' => 'El correo electrónico ya está siendo utilizado'),
			//array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => UserModule::t("Retype Password is incorrect.")),
			//array('username', 'match', 'pattern' => '/^[A-Za-z0-9_@-.]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9).")),
			array('type, newsletter', 'numerical', 'integerOnly'=>true),
		);
		if (!(isset($_POST['ajax']) && $_POST['ajax']==='registration-form')) {
			array_push($rules,array('verifyCode', 'captcha', 'allowEmpty'=>!UserModule::doCaptcha('registration')));
		}
		
		//array_push($rules,array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => UserModule::t("Retype Password is incorrect.")));
		return $rules;
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'email'=>'Correo electrónico',
			'password'=>'Contraseña',
			'newsletter'=>'Recibir información por correo electrónico',
		);
	}
	
	public function passGenerator($length = 8) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $n = strlen($chars);

        for ($i = 0, $result = ''; $i < $length; $i++) {
            $index = rand(0, $n - 1);
            $result .= substr($chars, $index, 1);
        }

        return $result;
    } 
	
}