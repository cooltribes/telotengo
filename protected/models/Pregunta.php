<?php

/**
 * This is the model class for table "tbl_pregunta".
 *
 * The followings are the available columns in table 'tbl_pregunta':
 * @property integer $id
 * @property string $pregunta
 * @property string $fecha
 * @property integer $producto_id
 * @property integer $users_id
 *
 * The followings are the available model relations:
 * @property Producto $producto
 * @property Users $users
 * @property Respuesta[] $respuestas
 */
class Pregunta extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Pregunta the static model class
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
		return 'tbl_pregunta';
	} 

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pregunta, fecha, producto_id, users_id', 'required'),
			array('producto_id, users_id', 'numerical', 'integerOnly'=>true),
			array('pregunta', 'length', 'max'=>350),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, pregunta, fecha, producto_id, users_id', 'safe', 'on'=>'search'),
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
			'producto' => array(self::BELONGS_TO, 'Producto', 'producto_id'),
			'users' => array(self::BELONGS_TO, 'Users', 'users_id'),
			'respuestas' => array(self::HAS_MANY, 'Respuesta', 'pregunta_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'pregunta' => 'Pregunta',
			'fecha' => 'Fecha',
			'producto_id' => 'Producto',
			'users_id' => 'Users',
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
		$criteria->compare('pregunta',$this->pregunta,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('producto_id',$this->producto_id);
		$criteria->compare('users_id',$this->users_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}