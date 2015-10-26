<?php

/**
 * This is the model class for table "tbl_orden_has_inventario".
 *
 * The followings are the available columns in table 'tbl_orden_has_inventario':
 * @property integer $id
 * @property integer $cantidad
 * @property double $precio
 * @property integer $inventario_id
 * @property integer $orden_id
 *
 * The followings are the available model relations:
 * @property Inventario $inventario
 * @property Orden $orden
 */
class OrdenHasInventario extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrdenHasInventario the static model class
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
		return 'tbl_orden_has_inventario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('inventario_id, orden_id', 'required'),
			array('inventario_id, orden_id', 'numerical', 'integerOnly'=>true),
			//array('precio', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cantidad, precio, inventario_id, orden_id', 'safe', 'on'=>'search'),
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
			'inventario' => array(self::BELONGS_TO, 'Inventario', 'inventario_id'),
			'orden' => array(self::BELONGS_TO, 'Orden', 'orden_id'),
			'almacen' => array(self::BELONGS_TO, 'Almacen', 'almacen_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'cantidad' => 'Cantidad',
			'precio' => 'Precio',
			'inventario_id' => 'Inventario',
			'orden_id' => 'Orden',
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
		$criteria->compare('cantidad',$this->cantidad);
		$criteria->compare('precio',$this->precio);
		$criteria->compare('inventario_id',$this->inventario_id);
		$criteria->compare('orden_id',$this->orden_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}