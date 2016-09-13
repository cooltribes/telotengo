<?php

/**
 * This is the model class for table "tbl_almacen".
 *
 * The followings are the available columns in table 'tbl_almacen':
 * @property integer $id
 * @property string $ubicacion
 * @property integer $empresas_id
 *
 * The followings are the available model relations:
 * @property Empresas $empresas
 * @property Inventario[] $inventarios
 */
class Almacen extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Almacen the static model class
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
		return 'tbl_almacen';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ubicacion , ciudad_id, provincia_id', 'required'),
			array('alias', 'required','message'=>'Sucursal no puede ser nulo.'),
			array('nombre', 'required','message'=>'Nombre comercial no puede ser nulo.'),
			array('empresas_id, ciudad_id, provincia_id', 'numerical', 'integerOnly'=>true),
			array('ubicacion', 'length', 'max'=>245),
			array('alias', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ubicacion, empresas_id, alias, ciudad_id, provincia_id', 'safe', 'on'=>'search'),
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
			'inventarios' => array(self::HAS_MANY, 'Inventario', 'almacen_id'),
			'ciudad' => array(self::BELONGS_TO, 'Ciudad', 'ciudad_id'),
			'provincia' => array(self::BELONGS_TO, 'Provincia', 'provincia_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ubicacion' => 'Ubicación',
			'empresas_id' => 'Empresas',
			'alias' => 'Alias',
			'ciudad_id' => 'Ciudad',
			'provincia_id' => 'Estado',
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
		$criteria->compare('ubicacion',$this->ubicacion,true);
		$criteria->compare('empresas_id',$this->empresas_id);
		$criteria->compare('alias',$this->alias);
		$criteria->compare('ciudad_id',$this->ciudad_id);
		$criteria->compare('provincia_id',$this->provincia_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function searchPropio($empresa_id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('empresas_id',$empresa_id);
		$criteria->compare('alias',$this->alias);
		$criteria->compare('ciudad_id',$this->ciudad_id);
		$criteria->compare('provincia_id',$this->provincia_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	    public function buscarPorFiltros($filters) {

            $criteria = new CDbCriteria;

            for ($i = 0; $i < count($filters['fields']); $i++) {
                
                $column = $filters['fields'][$i];
                $value = $filters['vals'][$i];
                $comparator = $filters['ops'][$i];
                
                if($i == 0){
                   $logicOp = 'AND'; 
                }else{                
                    $logicOp = $filters['rels'][$i-1];                
                }                

                if($column=="razon_social")
                {
                	$value = ($comparator == '=') ? "= '".$value."'" : "LIKE '%".$value."%'";
                	$criteria->addCondition('empresas_id in (select id from tbl_empresas where razon_social '.$value.')', $logicOp);
                   	continue;
                }
                if($column == 'nombre_comercial' || $column == 'sucursal' || $column == 'ubicacion') 
                {
                  	if($column=="nombre_comercial")
                  		$column="nombre";
                  	if($column=="sucursal")
                  		$column="alias";

                    $value = ($comparator == '=') ? "= '".$value."'" : "LIKE '%".$value."%'";
                    $criteria->addCondition($column.' '.$value, $logicOp);
                    continue;
                }                                
                //Para las finalizadas


                 if($column == 'provincia')
                {
                	$value = ($comparator == '=') ? "= '".$value."'" : "LIKE '%".$value."%'";
                	$model=Provincia::model()->findAllBySql('select id from tbl_provincia where nombre '.$value);
                	$vec=ARRAY();
					foreach($model as $modelado):
						$vec[]=$modelado->id;
					endforeach;

					if(empty($vec))
						$criteria->addCondition('ciudad_id in (select id from tbl_ciudad where provincia_id in(0))', $logicOp);
					else
                    	$criteria->addCondition('ciudad_id in (select id from tbl_ciudad where provincia_id in('.implode(',', $vec).'))', $logicOp);
                    continue;

                }
                if($column == 'ciudad')
                {
                	$value = ($comparator == '=') ? "= '".$value."'" : "LIKE '%".$value."%'";
                	$criteria->addCondition('ciudad_id in (select id from tbl_ciudad where nombre '.$value.')', $logicOp);
                   	continue;
                }
                #echo 't.'.$column, $comparator." ".$value;
                $criteria->compare('t.'.$column, $comparator." ".$value,
                        false, $logicOp);  
            }
                                   
            
            $criteria->select = 't.*';
                        
        

            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
            ));
       }
}