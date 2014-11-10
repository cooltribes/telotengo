<?php

/**
 * This is the model class for table "{{mensajes}}".
 *
 * The followings are the available columns in table '{{mensajes}}':
 * @property integer $id
 * @property integer $from_id
 * @property integer $to_id
 * @property integer $asunto
 * @property string $mensaje
 * @property string $respuesta
 * @property string $fecha
 * @property string $estado
 * 
 */
 
 /*
  * Estados
  * 0: No leido
  * 1: Leido
  */ 
class Mensajes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mensajes}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('from_id, to_id, asunto, mensaje, fecha', 'required'),
			array('from_id, to_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, from_id, to_id, asunto, mensaje, respuesta, fecha, estado', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'from_id' => 'De',
			'to_id' => 'Para',
			'asunto' => 'Asunto',
			'mensaje' => 'Mensaje',
			'respuesta' => 'Respuesta',
			'fecha' => 'Fecha',
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
		$criteria->compare('from_id',$this->from_id);
		$criteria->compare('to_id',$this->to_id);
		$criteria->compare('asunto',$this->asunto,true);
		$criteria->compare('mensaje',$this->mensaje,true);
		$criteria->compare('respuesta',$this->respuesta,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('estado',$this->estado,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Mensajes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getMensajesEmpresas()
	{
		//$mensajes = Mensajes::model()->findAllBySql("select d.*,c.razon_social as razon_social from tbl_empresas_has_tbl_users a, tbl_users b, tbl_empresas c, tbl_mensajes d where a.users_id = :keyword and a.users_id = b.id and c.tipo=2 and c.id = a.empresas_id and d.to_id = a.empresas_id and d.estado =0", array(':keyword'=>Yii::app()->user->id)); 
		
		$sql="select d.*,c.razon_social from tbl_empresas_has_tbl_users a, tbl_users b, tbl_empresas c, tbl_mensajes d
				where a.users_id = ".Yii::app()->user->id." and a.users_id = b.id and c.tipo=2 and c.id = a.empresas_id and d.to_id = a.empresas_id and d.estado =0";
		$count=Yii::app()->db->createCommand("select count(*) from tbl_empresas_has_tbl_users a, tbl_users b, tbl_empresas c, tbl_mensajes d
				where a.users_id = ".Yii::app()->user->id." and a.users_id = b.id and c.tipo=2 and c.id = a.empresas_id and d.to_id = a.empresas_id and d.estado =0")->queryScalar();
		
		$dataProvider=new CSqlDataProvider($sql, array(
		    'totalItemCount'=>$count,
		    'sort'=>array(
		        'attributes'=>array(
		             'id',
		        ),
		    ),
		    'pagination'=>array(
		        'pageSize'=>10,
		    ),
		));

		return $dataProvider;
		
		/*
		$mensajes = Mensajes::model()->findAllBySql("select d.*,c.razon_social from tbl_empresas_has_tbl_users a, tbl_users b, tbl_empresas c, tbl_mensajes d
			where a.users_id = ".Yii::app()->user->id." and a.users_id = b.id and c.tipo=2 and c.id = a.empresas_id and d.to_id = a.empresas_id and d.estado =0"); 
				
		//select d.*,c.razon_social from tbl_empresas_has_tbl_users a, tbl_users b, tbl_empresas c, tbl_mensajes d where a.users_id=8 and a.users_id = b.id and c.tipo=2 and c.id = a.empresas_id and d.to_id = a.empresas_id and d.estado =0
		return $mensajes;*/
	}
}
