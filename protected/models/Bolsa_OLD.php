<?php

/**
 * This is the model class for table "tbl_bolsa".
 *
 * The followings are the available columns in table 'tbl_bolsa':
 * @property integer $id
 * @property integer $users_id
 *
 * The followings are the available model relations:
 * @property Users $users
 * @property BolsaHasTblInventario[] $bolsaHasTblInventarios
 */
class Bolsa extends CActiveRecord
{ 
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Bolsa the static model class
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
		return 'tbl_bolsa';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('users_id', 'required'),
			array('users_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, users_id', 'safe', 'on'=>'search'),
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
			'bolsaHasTblInventarios' => array(self::HAS_MANY, 'BolsaHasTblInventario', 'bolsa_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
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
		$criteria->compare('users_id',$this->users_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/*
	Función para revisar si un inventario existe ya en la bolsa del usuario
	*/
	public function isProductAlready($inventario){

		$productosBolsa = BolsaHasInventario::model()->findAllByAttributes(array('bolsa_id'=>$this->id));

		foreach($productosBolsa as $producto){
			if($producto->inventario_id == $inventario){
				return true;
			}
		}
		return false;
	}

}