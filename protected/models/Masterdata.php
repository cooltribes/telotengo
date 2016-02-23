<?php

/**
 * This is the model class for table "{{masterdata}}".
 *
 * The followings are the available columns in table '{{masterdata}}':
 * @property integer $id
 * @property integer $filas
 * @property string $uploaded_at
 * @property integer $uploaded_by
 * @property string $path
 */
class Masterdata extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{masterdata}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('filas, uploaded_by', 'numerical', 'integerOnly'=>true),
			array('path', 'length', 'max'=>200),
			array('uploaded_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, filas, uploaded_at, uploaded_by, path', 'safe', 'on'=>'search'),
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
		  'user' => array(self::BELONGS_TO, 'User', 'uploaded_by'),
		  'productos' => array(self::HAS_MANY, 'Producto', 'masterdata_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'filas' => 'Filas',
			'uploaded_at' => 'Uploaded At',
			'uploaded_by' => 'Uploaded By',
			'path' => 'Path',
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
		$criteria->compare('filas',$this->filas);
		$criteria->compare('uploaded_at',$this->uploaded_at,true);
		$criteria->compare('uploaded_by',$this->uploaded_by);
		$criteria->compare('path',$this->path,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Masterdata the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public function getAll($query = null)
    {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $criteria=new CDbCriteria;
        $criteria->order="uploaded_at desc";
        if(!is_null($query)){
            if(is_numeric($query)){
                $criteria->addCondition("id = ".$query);
                
            }else{
                $users=$user_empresa=array();    
                $users=Yii::app()->db->createCommand("select user_id from tbl_profiles where ".Funciones::long_query($query, "first_name")." AND ".Funciones::long_query($query, "first_name"))->queryColumn();
                $empresas=Yii::app()->db->createCommand("select id from tbl_empresas where ".Funciones::long_query($query, "razon_social"))->queryColumn();
                if(count($empresas)>0){
                    $user_empresa=Yii::app()->db->createCommand("select users_id from tbl_empresas_has_tbl_users where empresas_id IN (".implode(",",$empresas).")")->queryColumn();                    
                }
                $users=array_merge($users,$user_empresa);               
                if(count($users)>0)
                    $criteria->addCondition("uploaded_by IN (".implode(',',$users).")");
                
            }
        }
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array('pageSize'=>15)
        ));
    }

    public function getByEmpresa($staff,$query = "")
    {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $criteria=new CDbCriteria;
        $criteria->order="uploaded_at desc";
        if(!is_null($query)){
            if(is_numeric($query)){
                $criteria->addCondition("id = ".$query);
                
            }else{                
                $users=Yii::app()->db->createCommand("select user_id from tbl_profiles where ".Funciones::long_query($query, "first_name")." AND ".Funciones::long_query($query, "first_name"))->queryColumn();               
                $users=array_intersect($users, $staff);
                if(count($users)>0)
                    $criteria->addCondition("uploaded_by IN (".implode(',',$users).")");
                
            }
        }
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array('pageSize'=>15)
        ));
    }


}
