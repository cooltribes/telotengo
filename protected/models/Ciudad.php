<?php

/**
 * This is the model class for table "tbl_ciudad".
 *
 * The followings are the available columns in table 'tbl_ciudad':
 * @property integer $id
 * @property string $nombre
 * @property integer $provincia_id
 *
 * The followings are the available model relations:
 * @property Provincia $provincia
 * @property DireccionEnvio[] $direccionEnvios
 * @property DireccionFacturacion[] $direccionFacturacions
 */
class Ciudad extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Ciudad the static model class
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
		return 'tbl_ciudad';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, provincia_id, ruta_id', 'required'),
			array('provincia_id', 'numerical, ruta_id, cod_zoom', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>120),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, provincia_id, ruta_id, cod_zoom', 'safe', 'on'=>'search'),
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
			'provincia' => array(self::BELONGS_TO, 'Provincia', 'provincia_id'),
			'direccionEnvios' => array(self::HAS_MANY, 'DireccionEnvio', 'ciudad_id'),
			'direccionFacturacions' => array(self::HAS_MANY, 'DireccionFacturacion', 'ciudad_id'),
			'ruta' => array(self::BELONGS_TO, 'Ruta', 'ruta_id'),
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
			'provincia_id' => 'Provincia',
			'ruta_id' => 'Ruta',
			'cod_zoom' => 'Código Zoom',
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
		$criteria->compare('provincia_id',$this->provincia_id);
		$criteria->compare('ruta_id',$this->ruta_id);
		$criteria->compare('cod_zoom',$this->cod_zoom);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}