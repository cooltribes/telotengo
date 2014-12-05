<?php

/**
 * This is the model class for table "tbl_tipo_pago".
 *
 * The followings are the available columns in table 'tbl_tipo_pago':
 * @property integer $id
 * @property string $nombre
 * @property string $imagen_url
 *
 * The followings are the available model relations:
 * @property DetalleOrden[] $detalleOrdens
 */
class TipoPago extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TipoPago the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_tipo_pago';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre', 'required'),
			array('nombre', 'length', 'max'=>45),
			array('imagen_url', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, imagen_url', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'detalleOrdens' => array(self::HAS_MANY, 'DetalleOrden', 'tipo_pago_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Nombre',
			'imagen_url' => 'Url de la imagen',
		);
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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('imagen_url',$this->imagen_url,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function datosDeposito(){

		return "
			Debes hacer el deposito o transferencia electrónica en un máximo de 3 días a cualquiera de las siguientes <strong>cuentas corrientes</strong>:
			<br/>
			<ul style='list-style-type:square'>
				<li><strong>Banesco</strong> - 0134 0261 2026 1101 8222</li>
				<li><strong>Venezuela</strong> - 0102 0129 2500 0008 9665</li>
				<li><strong>Mercantil</strong> - 0105 0735 9417 3503 3014</li>
				<li><strong>Banfoandes</strong> - 0007 0147 5600 0000 3292</li>
				<li><strong>Sofitasa</strong> - 0137 0020 6200 0900 7231</li>
				<li><strong>100% Banco</strong> - 0156 0015 2804 0019 1722</li>
				<li><strong>BFC c.a</strong> - 0151 0135 1530 0004 2301</li>
				<li><strong>Banco Activo</strong> - 0171 0018 1660 0037 0854</li>
				<li><strong>Bancaribe</strong> - 0114 0430 8443 0005 2865</li>
				<li><strong>Provincial</strong> - 0108 0098 6001 0005 7276</li>
				<li><strong>Venezolano De Crédito </strong> - 0104 0033 3903 3008 3417</li>
				<li><strong>Corpbanca / Bod </strong>- 0121 0312 3700 1338 1504</li>
				<li><strong>Banco Exterior</strong> - 0115 0114 1410 02398498</li>
			</ul>
			<h4> Datos para la transferencia:</h4>
			<ul style='list-style-type:square'>
  				<li><strong>Beneficiario/Razón Social</strong>: Sigmasys C.A.</li>
  				<li><strong>Correo electrónico:</strong> ventas@sigmatiendas.com</li>
	    		<li><strong>RIF</strong>: J-29468637-0</li>
				<li><strong>Dirección</strong>: Avenida libertador  C.C Las Lomas local 30,  San Cristóbal,  Edo. Táchira.</li>
				<li><strong>Teléfono</strong>: 02763442626</li>
			</ul>
			<div class='alert alert-danger'>
				<strong>Importante</strong>: 
					Una vez realizado el pago debes notificarlo indicando el monto, número de compra y número de depósito al correo electrónico: 
						ventas@sigmatiendas.com
			</div>
		";
	}
}