<?php
class EnvioGiftcard extends CFormModel
{
    public $email;
    public $nombre;
	public $mensaje;        

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('nombre', 'required', 'message' => "Indica el nombre de quien recibirá la Gift Card"),	
            //array('nombre, mensaje', 'safe', "on" => "masivo"),
            //array('nombre, email, mensaje', 'safe', "on" => "masivo"),
            array('email', 'required', 'message' => "Debes indicar un email para enviar la Gift Card"),                        
            array('email', 'email', 'message' => "No es un formato de email válido."),
            //array('mensaje', 'required', 'message' => "Escribe un mensaje para quien recibirá la Gift Card"),
            array('mensaje, email, nombre', 'safe'),
            array('mensaje', 'length', 'max' => 140),  
		);
	}	

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'email' => 'Correo electrónico',
			'nombre' => 'Para',
			'mensaje' => 'Mensaje',
		);
	}
}