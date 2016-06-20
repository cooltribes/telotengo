<?php

/**
 * This is the model class for table "{{banner}}".
 *
 * The followings are the available columns in table '{{banner}}':
 * @property integer $id
 * @property string $ruta
 * @property string $ruta_imagen
 * @property integer $tipo_banner
 * @property string $fecha
 * @property integer $activo
 */
class Banner extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{banner}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruta, ruta_imagen, tipo_banner, fecha, activo', 'required'),
			array('tipo_banner, activo', 'numerical', 'integerOnly'=>true),
			array('ruta, ruta_imagen', 'length', 'max'=>250),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ruta, ruta_imagen, tipo_banner, fecha, activo', 'safe', 'on'=>'search'),
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
			'ruta' => 'Ruta',
			'ruta_imagen' => 'Ruta Imagen',
			'tipo_banner' => 'Tipo Banner',
			'fecha' => 'Fecha',
			'activo' => 'Activo',
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
		$criteria->compare('ruta',$this->ruta,true);
		$criteria->compare('ruta_imagen',$this->ruta_imagen,true);
		$criteria->compare('tipo_banner',$this->tipo_banner);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('activo',$this->activo);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Banner the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}