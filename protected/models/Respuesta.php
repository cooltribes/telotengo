<?php

/**
 * This is the model class for table "tbl_respuesta".
 *
 * The followings are the available columns in table 'tbl_respuesta':
 * @property integer $id
 * @property string $comentario
 * @property string $fecha
 * @property integer $pregunta_id
 * @property integer $users_id
 *
 * The followings are the available model relations:
 * @property Pregunta $pregunta
 * @property Users $users
 */
class Respuesta extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Respuesta the static model class
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
		return 'tbl_respuesta';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('comentario, fecha, pregunta_id, users_id', 'required'),
			array('pregunta_id, users_id', 'numerical', 'integerOnly'=>true),
			array('comentario', 'length', 'max'=>300),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, comentario, fecha, pregunta_id, users_id', 'safe', 'on'=>'search'),
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
			'pregunta' => array(self::BELONGS_TO, 'Pregunta', 'pregunta_id'),
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
			'comentario' => 'Respuesta',
			'fecha' => 'Fecha',
			'pregunta_id' => 'Pregunta',
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
		$criteria->compare('comentario',$this->comentario,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('pregunta_id',$this->pregunta_id);
		$criteria->compare('users_id',$this->users_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}