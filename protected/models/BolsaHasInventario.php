<?php

/**
 * This is the model class for table "tbl_bolsa_has_tbl_inventario".
 *
 * The followings are the available columns in table 'tbl_bolsa_has_tbl_inventario':
 * @property integer $id
 * @property integer $bolsa_id
 * @property integer $inventario_id
 * @property integer $cantidad
 *
 * The followings are the available model relations:
 * @property Bolsa $bolsa
 * @property Inventario $inventario
 */
class BolsaHasInventario extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BolsaHasInventario the static model class
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
		return 'tbl_bolsa_has_tbl_inventario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bolsa_id, inventario_id, cantidad', 'required'),
			array('bolsa_id, inventario_id, cantidad', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, bolsa_id, inventario_id, cantidad', 'safe', 'on'=>'search'),
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
			'bolsa' => array(self::BELONGS_TO, 'Bolsa', 'bolsa_id'),
			'inventario' => array(self::BELONGS_TO, 'Inventario', 'inventario_id'),
			'almacen' => array(self::BELONGS_TO, 'Almacen', 'almacen_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'bolsa_id' => 'Bolsa',
			'inventario_id' => 'Inventario',
			'cantidad' => 'Cantidad',
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
		$criteria->compare('bolsa_id',$this->bolsa_id);
		$criteria->compare('inventario_id',$this->inventario_id);
		$criteria->compare('cantidad',$this->cantidad);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
        protected function afterSave()
    {
        HistorialBolsa::model()->updateAll(array('ultimo'=>0),'bolsa_has_inventario_id=:uid',array(':uid'=>$this->id));  
        $historial= new HistorialBolsa;
        $historial->users_id= Yii::app()->user->id;
        $historial->bolsa_has_inventario_id=$this->id;
        $historial->fecha=date("Y-m-d H:i:s"); 
        if($this->isNewRecord ){
            $historial->tipo=1;
            $historial->descripcion="Adición de producto (".$this->cantidad." unds.)";
            $historial->save();
        }
        
        parent::afterSave();
    }
    
    
    public function beforeSave() 
    {
        #BeforeSave porque necesito la cantidad anterior
        HistorialBolsa::model()->updateAll(array('ultimo'=>0),'bolsa_has_inventario_id=:uid',array(':uid'=>$this->id));  
        $historial= new HistorialBolsa;
        $historial->users_id= Yii::app()->user->id;
        $historial->bolsa_has_inventario_id=$this->id;
        $historial->fecha=date("Y-m-d H:i:s"); 
        $diff=0;   
        if(!$this->isNewRecord)
        {           
            $diff=$this->cantidad-$this->findByPk($this->id)->cantidad;
            if($diff<0){
                $historial->descripcion="Disminución de cantidad en ".abs($diff)." unds.";
                $historial->tipo=2;                
            }
            else{
                $historial->descripcion="Aumento de cantidad en ".$diff." unds.";
                $historial->tipo=3;                
            }            
        }
        if($diff!=0)
            $historial->save();
        return parent::beforeSave();
    }
    
    public function beforeDelete()
    {
      HistorialBolsa::model()->updateAll(array('ultimo'=>0),'bolsa_has_inventario_id=:uid',array(':uid'=>$this->id));  
      $historial= new HistorialBolsa;
      $historial->users_id= Yii::app()->user->id;
      $historial->bolsa_has_inventario_id=$this->id;
      $historial->descripcion="Eliminación de producto";
      $historial->tipo=4;
      $historial->fecha=date("Y-m-d H:i:s"); 
      $historial->save();           
      return parent::beforeDelete();
    }
    
    
}