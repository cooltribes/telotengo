<?php

/**
 * This is the model class for table "{{telefono_almacen}}".
 *
 * The followings are the available columns in table '{{telefono_almacen}}':
 * @property integer $id
 * @property integer $tbl_almacen_id
 * @property string $valor
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property Almacen $tblAlmacen
 */
class TelefonoAlmacen extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{telefono_almacen}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tbl_almacen_id, valor, estado', 'required'),
			array('tbl_almacen_id, estado', 'numerical', 'integerOnly'=>true),
			array('valor', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, tbl_almacen_id, valor, estado', 'safe', 'on'=>'search'),
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
			'tblAlmacen' => array(self::BELONGS_TO, 'Almacen', 'tbl_almacen_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tbl_almacen_id' => 'Tbl Almacen',
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
		$criteria->compare('tbl_almacen_id',$this->tbl_almacen_id);
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
	 * @return TelefonoAlmacen the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
