<?php

/**
 * This is the model class for table "{{atributo}}".
 *
 * The followings are the available columns in table '{{atributo}}':
 * @property integer $id
 * @property string $nombre
 * @property integer $tipo_unidad
 * @property integer $tipo
 * @property integer $multiple
 * @property string $rango
 * @property integer $obligatorio
 *
 * The followings are the available model relations:
 * @property Unidad $tipoUnidad
 * @property CategoriaAtributo[] $categoriaAtributos
 */
class Atributo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	
	
	//public static $atributos;
	
	public function tableName()
	{
		return '{{atributo}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */


	/*public function __construct() 
	{
   		self::$atributos = array('1'=>'INT', '2'=>'FLOAT','3'=>'Range', '4'=>'Varchar', '5'=>'Date');
  	}*/
	
	public function rules() 
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, tipo', 'required'),
			array('tipo_unidad, tipo, multiple, obligatorio', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>100),
			array('rango', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre, tipo_unidad, tipo, multiple, rango, obligatorio, descripcion', 'safe', 'on'=>'search'),
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
			'tipoUnidad' => array(self::BELONGS_TO, 'Unidad', 'tipo_unidad'),
			'categoriaAtributos' => array(self::HAS_MANY, 'CategoriaAtributo', 'atributo_id'),
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
			'tipo_unidad' => 'Tipo de Unidad',
			'tipo' => 'Tipo',
			'multiple' => 'Multiple',
			'rango' => 'Rango',
			'obligatorio' => 'Obligatorio',
			'descripcion' => 'Descripcion',
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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('tipo_unidad',$this->tipo_unidad);
		$criteria->compare('tipo',$this->tipo);
		$criteria->compare('multiple',$this->multiple);
		$criteria->compare('rango',$this->rango,true);
		$criteria->compare('obligatorio',$this->obligatorio);
		$criteria->compare('descripcion',$this->descripcion);
		$criteria->order = 'nombre ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Atributo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getTiposAtributos() 
	{
   		return array('1'=>'int', '2'=>'float','3'=>'range', '4'=>'varchar', '5'=>'date', '6'=>'boolean', '7'=>'text');
  	}
	
	public function buscarTipo($id)
	{
		$array=array('1'=>'int', '2'=>'float','3'=>'range', '4'=>'varchar', '5'=>'date', '6'=>'boolean', '7'=>'text');
		return $array[$id];
	}
	public function buscarObligatorio()
	{
		if ($this->obligatorio==1)
		 return "required";
		else
		 return "";
	}
	
	public function buscarPatron()
	{
		if($this->tipo==1) //entero
		{
			$int='pattern="\d*"';	
			return $int;
		}
		if($this->tipo==2) //float
		{
			$float='pattern="\d*.\d*"';	
			return $float;
		}
		return "";
	}
	
	public function buscarMensaje()
	{
		if($this->tipo==1) //entero
			return 'title="Este no es un numero entero"';
		if($this->tipo==2) //float
			return 'title="Este no es un numero flotante"';
		return "";
	}
}
