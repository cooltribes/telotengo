
<?php

/**
 * This is the model class for table "{{bolsa}}".
 *
 * The followings are the available columns in table '{{bolsa}}':
 * @property integer $id
 * @property integer $empresas_id
 *
 * The followings are the available model relations:
 * @property Empresas $empresas
 * @property BolsaHasTblInventario[] $bolsaHasTblInventarios
 */
class Bolsa extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{bolsa}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('empresas_id', 'required'),
            array('empresas_id', 'numerical', 'integerOnly'=>true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, empresas_id', 'safe', 'on'=>'search'),
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
            'empresas' => array(self::BELONGS_TO, 'Empresas', 'empresas_id'),
            'bolsaHasTblInventarios' => array(self::HAS_MANY, 'BolsaHasTblInventario', 'bolsa_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'empresas_id' => 'Empresas',
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
        $criteria->compare('empresas_id',$this->empresas_id);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Bolsa the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }


	/*
	Función para revisar si un inventario existe ya en la bolsa del usuario
	*/
	/*public function isProductAlready($inventario){

		$productosBolsa = BolsaHasInventario::model()->findAllByAttributes(array('bolsa_id'=>$this->id));

		foreach($productosBolsa as $producto){
			if($producto->inventario_id == $inventario){
				return true;
			}
		}
		return false; 
	}*/
    
    public function getLastItems($limit = 3)
    {   if(count(Yii::app()->db->createCommand("select inventario_id from tbl_bolsa_has_tbl_inventario where bolsa_id =".$this->id." and cantidad<>0 order by id desc")->queryColumn())>0)
        {   
           /* $sql="select i.producto_id from tbl_inventario i join tbl_bolsa_has_tbl_inventario b on b.inventario_id=i.id where b.cantidad<>0 and b.bolsa_id=".$this->id." order by b.fecha desc limit 0,".$limit;*/
            $sql="select p.id, p.nombre from tbl_producto p join tbl_inventario i on i.producto_id=p.id join tbl_bolsa_has_tbl_inventario b on b.inventario_id=i.id where b.cantidad<>0 and b.bolsa_id=".$this->id." order by b.fecha desc limit 0,".$limit;
            # $productos=Yii::app()->db->createCommand($sql)->queryColumn();
            $productos=Producto::model()->findAllBySql($sql);
            if(count($productos>0))
            {
                #return Producto::model()->findAllByAttributes(array(),array('condition'=>'id IN ('.implode(',',$productos).')'));
                return $productos;
            }
        }
         return NULL;
    }
}