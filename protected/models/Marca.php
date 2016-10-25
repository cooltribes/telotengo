<?php

/**
 * This is the model class for table "tbl_marca".
 *
 * The followings are the available columns in table 'tbl_marca':
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 * @property string $destacado
 * @property string $Urlimagen
 *
 * The followings are the available model relations:
 * @property Producto[] $productos
 */
class Marca extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Marca the static model class
	 */
	public $marcaNueva;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_marca';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, descripcion', 'required','on'=>'superUser'),
			array('nombre', 'required','on'=>'normalUser'),
			array('nombre, destacado', 'length', 'max'=>45),
			array('descripcion, url_imagen', 'length', 'max'=>250),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, destacado, descripcion, url_imagen', 'safe', 'on'=>'search'),
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
			'productos' => array(self::HAS_MANY, 'Producto', 'marca_id'),
			'tieneActivos' => array(self::STAT, 'Producto', 'marca_id', 'condition' => 'estado=1'),
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
			'destacado' => 'Destacado',
			'descripcion' => 'Descripción',
			'url_imagen' => 'Url Imagen',
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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('destacado',$this->destacado,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('url_imagen',$this->url_imagen,true);
		//$criteria->compare('activo',1,true);
		$criteria->order = 'nombre ASC';
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function buscarPorFiltros($filters) 
    {
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

                if($column == 'nombre' || $column=='descripcion') 
                {
                    $value = ($comparator == '=') ? "= '".$value."'" : "LIKE '%".$value."%'";
                    $criteria->addCondition($column.' '.$value, $logicOp);
                    continue;
                } 
                 if($column == 'status') 
                {
                    $criteria->compare("activo", $comparator.$value, false, $logicOp);
                    continue;
                }
				if($column == 'destacado') 
                {
                    $criteria->compare("destacado", $comparator.$value, false, $logicOp);
                    continue;
                }                    
                
                //Para las finalizadas

                
                $criteria->compare('t.'.$column, $comparator." ".$value,
                        false, $logicOp);
                
            }
                                   
            
            $criteria->select = 't.*';
                        
        

            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
            ));
       }
}