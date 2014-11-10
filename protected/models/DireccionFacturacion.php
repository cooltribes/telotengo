<?php

/**
 * This is the model class for table "tbl_direccion_facturacion".
 *
 * The followings are the available columns in table 'tbl_direccion_facturacion':
 * @property integer $id
 * @property string $telefono
 * @property string $direccion_1
 * @property string $direccion_2
 * @property integer $users_id
 * @property integer $provincia_id
 * @property integer $ciudad_id
 *
 * The followings are the available model relations:
 * @property Users $users
 * @property Provincia $provincia
 * @property Ciudad $ciudad
 */
class DireccionFacturacion extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DireccionFacturacion the static model class
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
		return 'tbl_direccion_facturacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('telefono, direccion_1, users_id, provincia_id, ciudad_id', 'required'),
			array('users_id, provincia_id, ciudad_id', 'numerical', 'integerOnly'=>true),
			array('telefono', 'length', 'max'=>50),
			array('direccion_1, direccion_2', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, telefono, direccion_1, direccion_2, users_id, provincia_id, ciudad_id', 'safe', 'on'=>'search'),
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
			'users' => array(self::BELONGS_TO, 'Users', 'users_id'),
			'provincia' => array(self::BELONGS_TO, 'Provincia', 'provincia_id'),
			'ciudad' => array(self::BELONGS_TO, 'Ciudad', 'ciudad_id'),
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
			'users_id' => 'Users',
			'provincia_id' => 'Estado',
			'ciudad_id' => 'Ciudad',
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
		$criteria->compare('users_id',$this->users_id);
		$criteria->compare('provincia_id',$this->provincia_id);
		$criteria->compare('ciudad_id',$this->ciudad_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}