<?php

/**
 * This is the model class for table "{{devolucion}}".
 *
 * The followings are the available columns in table '{{devolucion}}':
 * @property integer $id
 * @property integer $user_id
 * @property integer $orden_has_inventario_id
 * @property string $motivo
 * @property double $monto_devuelto
 * @property double $monto_envio
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property OrdenHasInventario $ordenHasInventario
 */
class Devolucion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{devolucion}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, orden_has_inventario_id, motivo, monto_devuelto, monto_envio', 'required'),
			array('user_id, orden_has_inventario_id', 'numerical', 'integerOnly'=>true),
			array('monto_devuelto, monto_envio', 'numerical'),
			array('motivo', 'length', 'max'=>300),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, orden_has_inventario_id, motivo, monto_devuelto, monto_envio', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'ordenHasInventario' => array(self::BELONGS_TO, 'OrdenHasInventario', 'orden_has_inventario_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'orden_has_inventario_id' => 'Orden Has Inventario',
			'motivo' => 'Motivo',
			'monto_devuelto' => 'Monto Devuelto',
			'monto_envio' => 'Monto Envio',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('orden_has_inventario_id',$this->orden_has_inventario_id);
		$criteria->compare('motivo',$this->motivo,true);
		$criteria->compare('monto_devuelto',$this->monto_devuelto);
		$criteria->compare('monto_envio',$this->monto_envio);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Devolucion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
