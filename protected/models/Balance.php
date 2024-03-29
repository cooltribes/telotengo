<?php

/**
 * This is the model class for table "{{balance}}".
 *
 * The followings are the available columns in table '{{balance}}':
 * @property integer $id
 * @property double $total
 * @property integer $orden_id
 * @property integer $user_id
 * @property integer $tipo
 *
 * The followings are the available model relations:
 * @property Users $user
 */


 //UN BALANCE CON ORDER_ID = 0; REPRESENTA UNA CARGA DE SALDO DESDE ADMIN
 
 /* TIPO:
  * 
  * 0: Balance Positivo
  * 1: Balance Negativo
  * 2: Tarjeta de Regalo
  * 3: Carga desde Admin
  * 4: Saldo por devolución
  * 5: Perfil Completo
  */


class Balance extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{balance}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('total, user_id', 'required'),
			array('orden_id, user_id, tipo', 'numerical', 'integerOnly'=>true),
			array('total', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, total, orden_id, user_id, tipo', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'total' => 'Total',
			'orden_id' => 'Orden',
			'user_id' => 'User',
			'tipo' => 'Tipo',
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
		$criteria->compare('total',$this->total);
		$criteria->compare('orden_id',$this->orden_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('tipo',$this->tipo);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getTotal(){
		$todas = Balance::model()->findAllByAttributes(array('user_id'=>Yii::app()->user->id));
		$total = 0;

		foreach($todas as $bal)
			$total += $bal->total;

		return $total;
	}
    public function getSaldo($user_id){
        $todas = Balance::model()->findAllByAttributes(array('user_id'=>$user_id));
        $total = 0;

        foreach($todas as $bal)
            $total += $bal->total;

        return $total;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Balance the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
