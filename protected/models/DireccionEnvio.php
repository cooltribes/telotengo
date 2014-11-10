<?php

/**
 * This is the model class for table "tbl_direccion_envio".
 *
 * The followings are the available columns in table 'tbl_direccion_envio':
 * @property integer $id
 * @property string $telefono
 * @property string $direccion_1
 * @property string $direccion_2
 * @property integer $ciudad_id
 * @property integer $provincia_id
 * @property integer $users_id
 *
 * The followings are the available model relations:
 * @property Ciudad $ciudad
 * @property Provincia $provincia
 * @property Users $users
 */
class DireccionEnvio extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DireccionEnvio the static model class
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
		return 'tbl_direccion_envio';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, telefono, direccion_1, ciudad_id, provincia_id', 'required'),
			array('ciudad_id, provincia_id, users_id', 'numerical', 'integerOnly'=>true),
			array('telefono, nombre', 'length', 'max'=>50),
			array('direccion_1, direccion_2', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, telefono, direccion_1, direccion_2, ciudad_id, provincia_id, users_id, nombre', 'safe', 'on'=>'search'),
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
			'ciudad' => array(self::BELONGS_TO, 'Ciudad', 'ciudad_id'),
			'provincia' => array(self::BELONGS_TO, 'Provincia', 'provincia_id'),
			'users' => array(self::BELONGS_TO, 'Users', 'users_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'telefono' => 'Telefono',
			'direccion_1' => 'Direccion 1',
			'direccion_2' => 'Direccion 2',
			'ciudad_id' => 'Ciudad',
			'provincia_id' => 'Estado',
			'users_id' => 'Users',
			'nombre' => 'Nombre',
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
		$criteria->compare('telefono',$this->telefono,true);
		$criteria->compare('direccion_1',$this->direccion_1,true);
		$criteria->compare('direccion_2',$this->direccion_2,true);
		$criteria->compare('ciudad_id',$this->ciudad_id);
		$criteria->compare('provincia_id',$this->provincia_id);
		$criteria->compare('users_id',$this->users_id);
		$criteria->compare('nombre',$this->nombre);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}