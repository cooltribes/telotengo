<?php

/**
 * This is the model class for table "tbl_inventario".
 *
 * The followings are the available columns in table 'tbl_inventario':
 * @property integer $id
 * @property double $precio
 * @property double $precio_tienda
 * @property integer $cantidad
 * @property integer $almacen_id
 * @property integer $producto_id
 * @property string $sku
 * 
 * The followings are the available model relations:
 * @property BolsaHasTblInventario[] $bolsaHasTblInventarios
 * @property Almacen $almacen
 * @property Producto $producto
 * @property OrdenHasInventario[] $ordenHasInventarios
 * @property WishlistHasTblInventario[] $wishlistHasTblInventarios
 */

/*
ESTADOS:
1 - Activo
2 - Agotado (ya se vendieron todas las unidades)
3 - Eliminado (eliminado por un administrador o la empresa)

*/

class Inventario extends CActiveRecord 
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Inventario the static model class
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
		return 'tbl_inventario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('precio, precio_tienda, cantidad, almacen_id, producto_id, estado', 'required'),
			array('cantidad, almacen_id, producto_id, estado', 'numerical', 'integerOnly'=>true),
			array('precio, precio_tienda', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, precio, precio_tienda, cantidad, almacen_id, producto_id, estado, sku', 'safe', 'on'=>'search'),
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
			'bolsaHasTblInventarios' => array(self::HAS_MANY, 'BolsaHasTblInventario', 'inventario_id'),
			'almacen' => array(self::BELONGS_TO, 'Almacen', 'almacen_id'),
			'producto' => array(self::BELONGS_TO, 'Producto', 'producto_id'),
			'ordenHasInventarios' => array(self::HAS_MANY, 'OrdenHasInventario', 'inventario_id'),
			'wishlistHasTblInventarios' => array(self::HAS_MANY, 'WishlistHasTblInventario', 'inventario_id'),
			'ventasflash' => array(self::HAS_MANY, 'Flashsale', 'inventario_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'precio' => 'Precio',
			'cantidad' => 'Cantidad',
			'almacen_id' => 'Almacen',
			'producto_id' => 'Producto',
			'estado' => 'Estado',
			'precio_tienda' => 'Precio en tienda',
			'sku' => 'SKU',
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
		$criteria->compare('precio',$this->precio);
		$criteria->compare('precio_tienda',$this->precio_tienda);
		$criteria->compare('cantidad',$this->cantidad);
		$criteria->compare('almacen_id',$this->almacen_id);
		$criteria->compare('producto_id',$this->producto_id);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('sku',$this->sku);
		$criteria->order = 'almacen_id';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getInventariosEmpresa($id)
	{
		$sql='select i.* from tbl_inventario i, tbl_almacen a, tbl_empresas e where e.id = '.$id.' and i.almacen_id = a.id and a.empresas_id = '.$id;
		$count=Yii::app()->db->createCommand('select COUNT(*) from tbl_inventario i, tbl_almacen a, tbl_empresas e where e.id = '.$id.' and i.almacen_id = a.id and a.empresas_id = '.$id)->queryScalar();
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
	}

	public function getInventariosAlmacen($producto_id, $almacen_id)
	{
		$sql = 'select i.* from tbl_inventario i, tbl_almacen a where i.producto_id = '.$producto_id.' AND i.estado = 1 AND i.almacen_id = a.id AND a.id = '.$almacen_id;
		$count=Yii::app()->db->createCommand('select COUNT(*) from tbl_inventario i, tbl_almacen a where i.producto_id = '.$producto_id.' AND i.estado = 1 AND i.almacen_id = a.id AND a.id = '.$almacen_id)->queryScalar();
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
	}

	public function buscar_activos()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('estado', 1);
		$criteria->compare('producto_id', $this->producto_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getMenor($id){
		$inventarios = Inventario::model()->findByAttributes(array('producto_id'=>$id),array('order'=>'precio'));
		
		return $inventarios;
	}

	public function getOpcionesCompra($not_this, $producto_id){
		$criteria = new CDbCriteria();
		$criteria->condition = 'producto_id = '.$producto_id;
		if($not_this != ''){
			$criteria->addCondition('id != '.$not_this);
		}
		$criteria->order = 'precio ASC';

		$inventarios = Inventario::model()->findAll($criteria);
		
		return $inventarios;
	}
	
	public function countxRango($min, $max){
		$sql="SELECT count(DISTINCT p.producto_id) from tbl_inventario p JOIN tbl_producto pr ON pr.id=p.producto_id where p.precio >".$min." AND p.precio <".$max." AND pr.estado=1";
		return Yii::app()->db->createCommand($sql)->queryScalar();
	}
	
	
	public function getLimites(){
			
		$sql = "SELECT MAX(p.precio) as maximo, MIN(p.precio) as minimo from tbl_inventario p JOIN tbl_producto pr ON pr.id=p.producto_id";
		
		$lims = Yii::app()->db->createCommand($sql)->queryRow();

		$dif = $lims['maximo']-$lims['minimo'];
		
		$rangos[0]['min'] = 0;
		$rangos[0]['max'] = ($dif*.25)+$lims['minimo'];
		$rangos[0]['max'] = round($rangos[0]['max']/100, 0)*100;
		$rangos[1]['min'] = $rangos[0]['max']+0.01;
		$rangos[1]['max'] = ($dif*.50)+$lims['minimo'];
		$rangos[1]['max'] = round($rangos[1]['max']/100, 0)*100;
		$rangos[2]['min'] = $rangos[1]['max']+0.01;
		$rangos[2]['max'] = ($dif*.75)+$lims['minimo'];
		$rangos[2]['max'] = round($rangos[2]['max']/100, 0)*100;
		$rangos[3]['min'] = $rangos[2]['max']+0.01;
		$rangos[3]['max'] = $lims['maximo']+0.01;
		
		for($i=0;$i<4;$i++){
			$rangos[$i]['count']= Inventario::model()->countxRango($rangos[$i]['min'],$rangos[$i]['max']);
		}
		
		return $rangos;
	}
	
	public function countxRangoMarca($min, $max, $id){
		$sql="SELECT count(DISTINCT p.producto_id) from tbl_inventario p JOIN tbl_producto pr ON pr.id=p.producto_id where p.precio >".$min." AND p.precio <".$max." AND pr.estado=1 AND pr.marca_id=".$id;
		return Yii::app()->db->createCommand($sql)->queryScalar();
	}
	
	public function getLimitesMarca($marca_id){
			
		$sql = "SELECT MAX(p.precio) as maximo, MIN(p.precio) as minimo from tbl_inventario p JOIN tbl_producto pr ON pr.id=p.producto_id WHERE pr.marca_id=".$marca_id;
		$lims = Yii::app()->db->createCommand($sql)->queryRow();

		$dif = $lims['maximo']-$lims['minimo'];
		
		$rangos[0]['min'] = 0;
		$rangos[0]['max'] = ($dif*.25)+$lims['minimo'];
		$rangos[0]['max'] = round($rangos[0]['max']/100, 0)*100;
		$rangos[1]['min'] = $rangos[0]['max']+0.01;
		$rangos[1]['max'] = ($dif*.50)+$lims['minimo'];
		$rangos[1]['max'] = round($rangos[1]['max']/100, 0)*100;
		$rangos[2]['min'] = $rangos[1]['max']+0.01;
		$rangos[2]['max'] = ($dif*.75)+$lims['minimo'];
		$rangos[2]['max'] = round($rangos[2]['max']/100, 0)*100;
		$rangos[3]['min'] = $rangos[2]['max']+0.01;
		$rangos[3]['max'] = $lims['maximo']+0.01;
		
		for($i=0;$i<4;$i++){
			$rangos[$i]['count']= Inventario::model()->countxRangoMarca($rangos[$i]['min'],$rangos[$i]['max'], $marca_id);
		}
		
		return $rangos;
	}

	public function hasFlashSale(){
		$tiene = Flashsale::model()->findByAttributes(array('inventario_id'=>$this->id));
		if(isset($tiene->descuento)){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function flashSalePrice(){
		$sale = Flashsale::model()->findByAttributes(array('inventario_id'=>$this->id));
		$price = $this->precio - $sale->descuento;
		return $price;
	}

}