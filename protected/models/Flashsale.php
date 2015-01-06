<?php

/**
 * This is the model class for table "{{flashsale}}".
 *
 * The followings are the available columns in table '{{flashsale}}':
 * @property integer $id 
 * @property integer $cantidad
 * @property double $descuento
 * @property string $fecha_inicio
 * @property string $fecha_fin
 * @property integer $estado
 * @property integer $inventario_id
 *
 * The followings are the available model relations:
 * @property Inventario $inventario
 */
class Flashsale extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{flashsale}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cantidad, descuento, fecha_inicio, fecha_fin, estado, inventario_id', 'required'),
			array('cantidad, estado, inventario_id', 'numerical', 'integerOnly'=>true),
			array('descuento', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cantidad, descuento, fecha_inicio, fecha_fin, estado, inventario_id', 'safe', 'on'=>'search'),
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
			'descuento' => 'Descuento sobre el precio',
			'fecha_inicio' => 'Fecha Inicio',
			'fecha_fin' => 'Fecha Fin',
			'estado' => 'Estado', 
			'inventario_id' => 'Inventario',
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
		$criteria->compare('cantidad',$this->cantidad);
		$criteria->compare('descuento',$this->descuento);
		$criteria->compare('fecha_inicio',$this->fecha_inicio,true);
		$criteria->compare('fecha_fin',$this->fecha_fin,true);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('inventario_id',$this->inventario_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Flashsale the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
