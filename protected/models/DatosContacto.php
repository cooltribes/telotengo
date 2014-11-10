<?php

// Empresa = 0 -> El dato corresponde a un dato de un usuario 

/**
 * This is the model class for table "{{datos_contacto}}".
 *
 * The followings are the available columns in table '{{datos_contacto}}':
 * @property integer $id
 * @property integer $empresa_id
 * @property integer $tipo_id
 * @property string $valor
 * @property integer $estado
 * 
 * The followings are the available model relations:
 * @property Empresas $empresa
 * @property TiposDatosContacto $tipo
 */
class DatosContacto extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{datos_contacto}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('empresa_id, tipo_id, valor', 'required'),
			array('empresa_id, tipo_id, estado', 'numerical', 'integerOnly'=>true),
			array('valor', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, empresa_id, tipo_id, valor, estado', 'safe', 'on'=>'search'),
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
			'tipo' => array(self::BELONGS_TO, 'TiposDatosContacto', 'tipo_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'empresa_id' => 'Empresa',
			'tipo_id' => 'Tipo',
			'valor' => 'Valor',
			'estado' => 'Estado',
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
		$criteria->compare('empresa_id',$this->empresa_id);
		$criteria->compare('tipo_id',$this->tipo_id);
		$criteria->compare('valor',$this->valor,true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DatosContacto the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
