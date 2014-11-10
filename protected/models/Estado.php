<?php
/**
 * Cuando $user_id sea 0, indica que fue cambiada la orden automaticamente
 * a estado 11 (Finalizada) al pasar los 3 dias de haber sido recibida.
 * 
 */


/**
 * This is the model class for table "{{estado}}".
 *
 * The followings are the available columns in table '{{estado}}':
 * @property integer $id
 * @property integer $estado
 * @property integer $user_id
 * @property string $fecha
 * @property integer $orden_id
 *
 * The followings are the available model relations:
 * @property Orden $orden
 */
class Estado extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Estado the static model class
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
		return '{{estado}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('orden_id', 'required'),
			array('estado, user_id, orden_id', 'numerical', 'integerOnly'=>true),
			array('fecha', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, estado, user_id, fecha, orden_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'estado' => 'Estado',
			'user_id' => 'User',
			'fecha' => 'Fecha',
			'orden_id' => 'Orden',
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
		$criteria->compare('estado',$this->estado);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('orden_id',$this->orden_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getDate($orden,$estado){
		$here=$this->findByAttributes(array('estado'=>$estado,'orden_id'=>$orden));
		if(!is_null($here))
			return $here->fecha;
		else 
			return 0;
	}
}