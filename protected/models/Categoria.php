<?php

/**
 * This is the model class for table "tbl_categoria".
 *
 * The followings are the available columns in table 'tbl_categoria':
 * @property integer $id
 * @property string $nombre
 * @property string $url_amigable
 * @property string $imagen_url
 * @property string $destacado
 * @property string $descripcion
 *
 * The followings are the available model relations:
 * @property CategoriaHasTblProducto[] $categoriaHasTblProductos
 */
class Categoria extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Categoria the static model class
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
		return 'tbl_categoria';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, id_padre', 'required'),
			array('nombre', 'length', 'max'=>80),
			array('url_amigable', 'length', 'max'=>150),
			array('imagen_url', 'length', 'max'=>250),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, url_amigable, id_padre, imagen_url, destacado, descripcion', 'safe', 'on'=>'search'),
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
			'categoriaHasTblProductos' => array(self::HAS_MANY, 'CategoriaHasTblProducto', 'categoria_id'),
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
			'url_amigable' => 'Url Amigable',
			'imagen_url' => 'Imagen Url',
			'id_padre' => 'Id Padre',
			'destacado' => 'Destacado',
			'descripcion' => 'Descripción',
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
		$criteria->compare('id_padre',$this->id_padre,true);
		$criteria->compare('url_amigable',$this->url_amigable,true);
		$criteria->compare('imagen_url',$this->imagen_url,true);
		$criteria->compare('destacado',$this->destacado,true);
		$criteria->compare('descripcion',$this->descripcion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function hasChildren(){
		if (Categoria::model()->findByAttributes(array('id_padre'=>$this->id))){
			return true; 
		}	else {
			return false;
		}
	}
	
	public function getChildren(){
		return Categoria::model()->findAllByAttributes(array('id_padre'=>$this->id),array('order'=>'nombre ASC'));
	}

}