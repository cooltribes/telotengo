<?php

/**
 * This is the model class for table "{{imagenes}}".
 *
 * The followings are the available columns in table '{{imagenes}}':
 * @property integer $id
 * @property string $url
 * @property integer $orden
 * @property integer $producto_id
 *
 * The followings are the available model relations:
 * @property Producto $producto
 */
class Imagenes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_imagenes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('orden, producto_id', 'required'),
			array('id, orden, producto_id', 'numerical', 'integerOnly'=>true),
			array('url', 'length', 'max'=>300),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, url, orden, producto_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'url' => 'Url',
			'orden' => 'Orden',
			'producto_id' => 'Producto',
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
		$criteria->compare('url',$this->url,true);
		$criteria->compare('orden',$this->orden);
		$criteria->compare('producto_id',$this->producto_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Imagenes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * Obtener el Url de la imagen
	 * ext = jpg / png
	 * type = thumb / orig / 
	 */	
	public function getUrl($opciones=array())
	{
		
		$opciones['ext'] = isset($opciones['ext'])?$opciones['ext']:'jpg'; // valor por defecto jpg
		$opciones['type'] = isset($opciones['type'])?'_'.$opciones['type'].'.':'.'; // valor por defecto .
		$opciones['baseUrl'] = isset($opciones['baseUrl'])?$opciones['baseUrl']:true; // valor por defecto true
		
		$baseUrl = '';
		if ($opciones['baseUrl'])
			$baseUrl = Yii::app()->baseUrl;
		$ext = pathinfo($this->url, PATHINFO_EXTENSION);
		//echo $ext; 
		if ($ext == $opciones['ext'] )
			return $baseUrl.str_replace(".",$opciones['type'],$this->url);
		
		//$info = pathinfo($this->url);
		//$new_file = $info['filename'] . '.' . $type;
		$new_file = preg_replace('/\..+$/', '.' . $opciones['ext'] , $this->url);
		$new_file_path = $baseUrl.'/..'.$new_file;
		//$new_file_path = $_SERVER['DOCUMENT_ROOT'].$new_file;
		
		//echo $new_file_path;
		//clearstatcache();
		if (file_exists ($new_file_path)){
			//echo 'sip';  
			return $baseUrl.str_replace(".",$opciones['type'],$new_file);
		}
		//echo 'nop';
		return $baseUrl.str_replace(".",$opciones['type'],$this->url);	
		
		
	}
	
	
}
