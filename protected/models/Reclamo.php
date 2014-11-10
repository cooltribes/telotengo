<?php

/**
 * This is the model class for table "{{reclamo}}".
 *
 * The followings are the available columns in table '{{reclamo}}':
 * @property integer $id
 * @property string $comentario
 * @property string $fecha
 * @property integer $estado
 * @property integer $empresa_id
 * @property integer $user_id
 * @property integer $orden_inventario_id
 * @property integer $orden_id
 *
 * The followings are the available model relations:
 * @property Empresas $empresa
 * @property Users $user
 * @property Orden $orden
 */
class Reclamo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{reclamo}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('comentario, fecha, empresa_id, user_id, orden_inventario_id, orden_id', 'required'),
			array('estado, empresa_id, user_id, orden_inventario_id, orden_id', 'numerical', 'integerOnly'=>true),
			array('comentario', 'length', 'max'=>300),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, comentario, fecha, estado, empresa_id, user_id, orden_inventario_id, orden_id', 'safe', 'on'=>'search'),
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
			'empresa' => array(self::BELONGS_TO, 'Empresas', 'empresa_id'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'orden_inventario' => array(self::BELONGS_TO, 'OrdenHasInventario', 'orden_inventario_id'),
			'orden' => array(self::BELONGS_TO, 'Orden', 'orden_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'comentario' => 'Comentario',
			'fecha' => 'Fecha',
			'estado' => 'Estado',
			'empresa_id' => 'Empresa',
			'user_id' => 'User',
			'orden_inventario_id' => 'Orden Inventario',
			'orden_id' => 'Orden',
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
		$criteria->compare('comentario',$this->comentario,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('empresa_id',$this->empresa_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('orden_inventario_id',$this->orden_inventario_id);
		$criteria->compare('orden_id',$this->orden_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Reclamo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
