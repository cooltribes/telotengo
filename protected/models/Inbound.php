<?php

/**
 * This is the model class for table "{{inbound}}". 
 *
 * The followings are the available columns in table '{{inbound}}':
 * @property integer $id
 * @property integer $user_id
 * @property string $fecha_carga
 * @property integer $total_productos
 * @property integer $total_cantidad
 *
 * The followings are the available model relations:
 * @property Users $user
 */
class Inbound extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{inbound}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, fecha_carga, total_productos, total_cantidad', 'required'),
			array('user_id, total_productos, total_cantidad', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, fecha_carga, total_productos, total_cantidad', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'fecha_carga' => 'Fecha Carga',
			'total_productos' => 'Total Productos',
			'total_cantidad' => 'Total Cantidad',
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
	public function search($busqueda="")
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		//$criteria->compare('id',$busqueda);
		if($busqueda!="")
		{
				$condicion1="id='".$busqueda."'";
				$condicion2="or user_id in (select user_id from tbl_profiles where first_name like '%".$busqueda."%' or last_name like '%".$busqueda."%' )";	
				$condicion3="or user_id in (select users_id from tbl_empresas_has_tbl_users where empresas_id in (select id from tbl_empresas where razon_social like '%".$busqueda."%'))";
				$criteria->condition=$condicion1.$condicion2.$condicion3;
		}		
		//$criteria->compare('user_id',$busqueda);
		/*$criteria->compare('user_id',$this->user_id);
		$criteria->compare('fecha_carga',$this->fecha_carga,true);
		$criteria->compare('total_productos',$this->total_productos);
		$criteria->compare('total_cantidad',$this->total_cantidad);*/

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchPropio($busqueda="")
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$empresa=Empresas::model()->findByPk((EmpresasHasUsers::model()->findByAttributes(array('users_id'=>Yii::app()->user->id))->empresas_id));
		$condicion3="user_id in (select users_id from tbl_empresas_has_tbl_users where empresas_id='".$empresa->id."')";
		
		if($busqueda!="")
		{
			$condicion1="id='".$busqueda."'";	
			$condicion2="or user_id in (select user_id from tbl_profiles where first_name like '%".$busqueda."%' or last_name like '%".$busqueda."%' )";
			
			$criteria->condition=$condicion1.$condicion2."and ".$condicion3;
		}
		else 
		{
			$criteria->condition=$condicion3;
		}
			
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Inbound the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
