<?php

/**
 * This is the model class for table "tbl_documentos".
 *
 * The followings are the available columns in table 'tbl_documentos':
 * @property integer $id
 * @property string $nombre
 * @property string $ruta
 * @property integer $empresas_id
 *
 * The followings are the available model relations:
 * @property Empresas $empresas
 */


/**
* Tipo:
* 1 - RIF
* 2 - Registro de comercio
* 3 - Última declaración ISLR
* 4 - Referencia bancaria
* 9 - Otro
*/

class Documentos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Documentos the static model class
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
		return 'tbl_documentos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruta, empresas_id, tipo', 'required'),
			array('empresas_id, tipo', 'numerical', 'integerOnly'=>true),
			array('nombre, ruta', 'length', 'max'=>200),
			//array('ruta', 'file', 'types'=>'jpg, gif, png, pdf, doc, docx'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, ruta, empresas_id, tipo', 'safe', 'on'=>'search'),
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
			'empresas' => array(self::BELONGS_TO, 'Empresas', 'empresas_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Nombre',
			'ruta' => 'Ruta',
			'empresas_id' => 'Empresas',
			'tipo' => 'Tipo',
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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('ruta',$this->ruta,true);
		$criteria->compare('empresas_id',$this->empresas_id);
		$criteria->compare('tipo',$this->tipo);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}