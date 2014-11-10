<?php

// Estados:
// 0 -> Default
// 1 -> Aprobado
// 2 -> Rechazado

/**
 * This is the model class for table "tbl_detalle_orden".
 *
 * The followings are the available columns in table 'tbl_detalle_orden':
 * @property integer $id
 * @property double $monto
 * @property string $fecha
 * @property integer $estado
 * @property string $confirmacion
 * @property string $nombre
 * @property string $cedula
 * @property integer $orden_id
 * @property integer $tipo_pago_id
 *
 * The followings are the available model relations:
 * @property Orden $orden
 * @property TipoPago $tipoPago
 */
class DetalleOrden extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DetalleOrden the static model class
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
		return 'tbl_detalle_orden';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('monto, fecha, estado, nombre, cedula, orden_id, tipo_pago_id', 'required'),
			array('estado, orden_id, tipo_pago_id', 'numerical', 'integerOnly'=>true),
			array('monto', 'numerical'),
			array('confirmacion, cedula', 'length', 'max'=>45),
			array('nombre', 'length', 'max'=>125),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, monto, fecha, estado, confirmacion, nombre, cedula, orden_id, tipo_pago_id', 'safe', 'on'=>'search'),
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
			'orden' => array(self::BELONGS_TO, 'Orden', 'orden_id'),
			'tipoPago' => array(self::BELONGS_TO, 'TipoPago', 'tipo_pago_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'monto' => 'Monto',
			'fecha' => 'Fecha',
			'estado' => 'Estado',
			'confirmacion' => 'Confirmacion',
			'nombre' => 'Nombre',
			'cedula' => 'Cedula',
			'orden_id' => 'Orden',
			'tipo_pago_id' => 'Tipo Pago',
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
		$criteria->compare('monto',$this->monto);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('confirmacion',$this->confirmacion,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('cedula',$this->cedula,true);
		$criteria->compare('orden_id',$this->orden_id);
		$criteria->compare('tipo_pago_id',$this->tipo_pago_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}