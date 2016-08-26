<?php
/**
 * UserChangePassword class.
 * UserChangePassword is the data structure for keeping
 * user change password form data. It is used by the 'changepassword' action of 'UserController'.
 */
class UserChangePassword extends CFormModel {
	public $oldPassword;
	public $password;
	public $verifyPassword;
	
	public function rules() {
		return Yii::app()->controller->id == 'recovery' ? array(
			array('password, verifyPassword', 'required'),
			array('verifyPassword', 'length', 'max'=>128, 'min' => 6,'message' => 'La contraseña debe tener al menos 6 caracteres'),
			array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => 'Las contraseñas no coinciden'),
		) : array(
			array('oldPassword, password, verifyPassword', 'required'),
			array('oldPassword, password, verifyPassword', 'length', 'max'=>128, 'min' => 6,'message' => 'La contraseña debe tener al menos 6 caracteres'),
			array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => 'Las contraseñas no coinciden'),
			array('oldPassword', 'verifyOldPassword'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'oldPassword'=>'Contraseña anterior',
			'password'=>'Contraseña',
			'verifyPassword'=>'Vuelva a escribir la contraseña',
		);
	}
	
	/**
	 * Verify Old Password
	 */
	 public function verifyOldPassword($attribute, $params)
	 {
		 if (User::model()->notsafe()->findByPk(Yii::app()->user->id)->password != Yii::app()->getModule('user')->encrypting($this->$attribute))
			 $this->addError($attribute, 'Contraseña anterior incorrecta');
	 }
}