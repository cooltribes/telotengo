<?php

/**
 * This is the model class for table "tbl_categoria_has_tbl_producto".
 *
 * The followings are the available columns in table 'tbl_categoria_has_tbl_producto':
 * @property integer id
 * @property integer $categoria_id
 * @property integer $producto_id
 *
 * The followings are the available model relations:
 * @property Categoria $categoria
 * @property Producto $producto
 */
class CategoriaHasProducto extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CategoriaHasProducto the static model class
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
		return 'tbl_categoria_has_tbl_producto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('categoria_id, producto_id', 'required'),
			array('categoria_id, producto_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, categoria_id, producto_id', 'safe', 'on'=>'search'),
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
			'categoria' => array(self::BELONGS_TO, 'Categoria', 'categoria_id'),
			'producto' => array(self::BELONGS_TO, 'Producto', 'producto_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'categoria_id' => 'Categoria',
			'producto_id' => 'Producto',
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
		$criteria->compare('categoria_id',$this->categoria_id);
		$criteria->compare('producto_id',$this->producto_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}