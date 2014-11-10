<?php

/**
 * This is the model class for table "tbl_calificacion_producto".
 *
 * The followings are the available columns in table 'tbl_calificacion_producto':
 * @property integer $id
 * @property integer $puntuacion
 * @property string $comentario
 * @property string $fecha
 * @property integer $likes
 * @property integer $no_likes
 * @property integer $producto_id
 *
 * The followings are the available model relations:
 * @property Producto $producto
 */
class CalificacionProducto extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CalificacionProducto the static model class
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
		return 'tbl_calificacion_producto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('puntuacion, fecha, producto_id, user_id', 'required'),
			array('puntuacion, likes, no_likes, producto_id, user_id', 'numerical', 'integerOnly'=>true),
			array('comentario', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, puntuacion, comentario, fecha, likes, no_likes, producto_id, user_id', 'safe', 'on'=>'search'),
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
			'producto' => array(self::BELONGS_TO, 'Producto', 'producto_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'puntuacion' => 'Puntuacion',
			'comentario' => 'Comentario',
			'fecha' => 'Fecha',
			'likes' => 'Likes',
			'no_likes' => 'No Likes',
			'producto_id' => 'Producto',
			'user_id' => 'User',
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
		$criteria->compare('puntuacion',$this->puntuacion);
		$criteria->compare('comentario',$this->comentario,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('likes',$this->likes);
		$criteria->compare('no_likes',$this->no_likes);
		$criteria->compare('producto_id',$this->producto_id);
		$criteria->compare('user_id',$this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}