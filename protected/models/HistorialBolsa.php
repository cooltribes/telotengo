<?php

/**
 * This is the model class for table "{{historial_bolsa}}".
 *
 * The followings are the available columns in table '{{historial_bolsa}}':
 * @property integer $id
 * @property integer $bolsa_has_inventario_id
 * @property integer $users_id
 * @property integer $tipo
 * @property string $descripcion
 */
class HistorialBolsa extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{historial_bolsa}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bolsa_has_inventario_id, users_id, tipo', 'numerical', 'integerOnly'=>true),
			array('descripcion', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, bolsa_has_inventario_id, users_id, tipo, descripcion', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'bolsa_has_inventario_id' => 'Bolsa Has Inventario',
			'users_id' => 'Users',
			'tipo' => 'Tipo',
			'descripcion' => 'Descripcion',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('bolsa_has_inventario_id',$this->bolsa_has_inventario_id);
		$criteria->compare('users_id',$this->users_id);
		$criteria->compare('tipo',$this->tipo);
		$criteria->compare('descripcion',$this->descripcion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return HistorialBolsa the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
       
   
}
