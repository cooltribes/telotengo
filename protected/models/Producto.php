<?php


/*
 * Estados:
 * 0- Pendiente de aprobacion 
 * 1- Aprobado
 * 2- rechazado
 * 
 * =======================
 * 
 * Notificado:
 * 0- El admin no ha revisado el producto
 * 1- El admin ya reviso el producto y decidio
 */
 
/**
 * This is the model class for table "tbl_producto".
 *
 * The followings are the available columns in table 'tbl_producto':
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 * @property integer $destacado
 * @property integer $marca_id
 * @property integer $modelo
 * @property integer $estado
 * @property integer $users_id
 * @property integer $notificado
 * @property integer $codigo
 * @property integer $interno
 * @property integer $isbn
 * 
 * The followings are the available model relations:
 * @property CalificacionProducto[] $calificacionProductos
 * @property CategoriaHasTblProducto[] $categoriaHasTblProductos
 * @property Inventario[] $inventarios
 * @property Pregunta[] $preguntas
 * @property Marca $marca
 */
class Producto extends CActiveRecord
{
	public $categoria_id="";
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Producto the static model class
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
		return 'tbl_producto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, descripcion, marca_id, codigo, interno, peso', 'required'),
			array('destacado, marca_id', 'numerical', 'integerOnly'=>true),
			array('peso', 'numerical'),
			array('nombre', 'length', 'max'=>60), 
			//array('descripcion', 'length', 'max'=>1000),
			array('modelo', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, descripcion, destacado, marca_id, modelo, estado, users_id, notificado, codigo, interno, isbn, peso', 'safe', 'on'=>'search'),
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
			'calificacionProductos' => array(self::HAS_MANY, 'CalificacionProducto', 'producto_id'),
			'categorias' => array(self::MANY_MANY, 'Categoria', 'tbl_categoria_has_tbl_producto(categoria_id, producto_id)'),
			'categoriaHasTblProductos' => array(self::HAS_MANY, 'CategoriaHasTblProducto', 'producto_id'),
			'inventarios' => array(self::HAS_MANY, 'Inventario', 'producto_id'),
			'preguntas' => array(self::HAS_MANY, 'Pregunta', 'producto_id'),
			'marca' => array(self::BELONGS_TO, 'Marca', 'marca_id'),
			'imagenes' => array(self::HAS_MANY, 'Imagenes', 'producto_id','order' => 'k.orden ASC', 'alias' => 'k'),
			'mainimage' => array(self::HAS_ONE, 'Imagenes', 'producto_id','on' => 'orden=1'),
			'caracteristicasProducto' => array(self::HAS_MANY, 'CaracteristicasProducto', 'producto_id'),
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
			'descripcion' => 'Descripcion',
			'destacado' => 'Destacado',
			'marca_id' => 'Marca',
			'modelo' => 'Modelo',
			'estado' => 'Estado',
			'users_id' => 'Ususario',
			'notificado' => 'Notificado',
			'codigo' => 'Código',
			'interno' => 'Código interno',
			'isbn' => 'ISBN',
			'peso' => 'Peso',
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
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('destacado',$this->destacado);
		$criteria->compare('marca_id',$this->marca_id);
		$criteria->compare('modelo',$this->modelo);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('users_id',$this->users_id);
		$criteria->compare('notificado',$this->notificado); 
		$criteria->compare('codigo',$this->codigo); 
		$criteria->compare('interno',$this->interno); 
		$criteria->compare('isbn',$this->isbn);
		$criteria->compare('peso',$this->peso);
		$criteria->join ='JOIN tbl_imagenes ON tbl_imagenes.producto_id = t.id AND tbl_imagenes.orden=1';
	//	$criteria->join .='JOIN tbl_inventario ON tbl_inventario.producto_id = t.id AND tbl_inventario.cantidad > 0';
		$criteria->with = array('inventarios');
		$criteria->condition = "inventarios.cantidad > '0'";
		$criteria->group="t.id";
		
		$criteria->together = true;
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>9,),
		));
	}
	
	public function searchTwo()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('destacado',$this->destacado);
		$criteria->compare('marca_id',$this->marca_id);
		$criteria->compare('modelo',$this->modelo);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('users_id',$this->users_id);
		$criteria->compare('notificado',$this->notificado); 
		$criteria->compare('codigo',$this->codigo); 
		$criteria->compare('interno',$this->interno); 
		$criteria->compare('isbn',$this->isbn);
		$criteria->compare('peso',$this->peso);
		$criteria->join ='JOIN tbl_imagenes ON tbl_imagenes.producto_id = t.id AND tbl_imagenes.orden=1';
		
		$criteria->together = true;
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>12,),
		));
	}
	
	
	public function busqueda($todos)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.descripcion',$this->descripcion,true);
		$criteria->compare('t.destacado',$this->destacado);
		$criteria->compare('t.marca_id',$this->marca_id);
		$criteria->compare('t.modelo',$this->modelo);
		$criteria->compare('t.nombre',$this->nombre,true);
		$criteria->compare('t.estado',$this->estado,true);
		$criteria->compare('t.users_id',$this->users_id,true);
		$criteria->compare('categorias.nombre',$this->nombre,true,'OR');
		
		$criteria->with = array('categorias','inventarios');
		$criteria->compare('categoria_id',$this->categoria_id);
		
		$criteria->order = "t.id ASC";
		$criteria->group="t.id";
		
		if(isset(Yii::app()->session['p_index'])){
			$criteria->addCondition('precio > '.Yii::app()->session['min']);
			$criteria->addCondition('precio < '.Yii::app()->session['max']);
			$criteria->order = "precio ASC";
		}
		
		$criteria->together = true;
		
		return new CActiveDataProvider($this, array(
       		'pagination'=>array('pageSize'=>12,),
       		'criteria'=>$criteria,
		));
		
	}

	public function hijos($id){  
		 
			$categ = Categoria::model()->findAllByAttributes(array('id_padre'=>$id), array('order'=>'nombre ASC'));
			//$ciudades = Ciudad::model()->findAllByAttributes(array('provincia_id'=>$_POST['provincia_id']), array('order'=>'nombre ASC'));
			
			if(sizeof($categ) > 0){
				$return = CHtml::listData($categ,'id','nombre');
				
				return $return;
			}
			
	}
	
	public function listar()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('destacado',$this->destacado,true);
		$criteria->compare('marca_id',$this->marca_id,true);
		$criteria->compare('modelo',$this->modelo,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('users_id',$this->users_id,true);
		$criteria->compare('notificado',$this->notificado,true);
		
		return new CActiveDataProvider($this, array(
       		'pagination'=>array('pageSize'=>10,),
       		'criteria'=>$criteria,
		));
		
	}

	public function front(){
		$sql ="SELECT pro.id as id FROM tbl_producto pro, tbl_inventario inv where inv.producto_id = pro.id and pro.destacado=1 and inv.cantidad > 0
				GROUP BY pro.id ORDER BY RAND() LIMIT 4";
		$num = Yii::app()->db->createCommand($sql)->query();
		
		return $num;
	}
	
	public function hasFlashsale()
	{
		$sql = "SELECT c.* FROM tbl_flashsale a,tbl_inventario b, tbl_producto c where c.id =".$this->id." and a.inventario_id=b.id and c.id=b.producto_id and a.estado=1";
		$producto = Yii::app()->db->createCommand($sql)->queryRow();

		if($producto['id']!="")
			return true;
		else
			return false;
		
	}
	
	public function productosEmpresa($id)
	{
		
		$sql = 'select c.* from tbl_empresas a, tbl_inventario b, tbl_producto c, tbl_almacen d where a.tipo=2 and b.almacen_id = d.id and d.empresas_id = a.id
				and b.producto_id=c.id and a.id ='.$id.' and b.cantidad > 0 and c.estado=1 GROUP BY c.id';
		
		// $count=Yii::app()->db->createCommand('select COUNT(*) from tbl_inventario i, tbl_almacen a, tbl_empresas e where e.id = '.$id.' and i.almacen_id = a.id and a.empresas_id = '.$id)->queryScalar();
		
		$dataProvider=new CSqlDataProvider($sql, array( 
		    'sort'=>array(
		        'attributes'=>array(
		             'id',
		        ), 
		    ),
		));

		return $dataProvider;
	}
	
	public function getSuggestions($user_id,$quantity){
	    
	    return $this->findAll(array('limit'=>$quantity,'offset'=>0,'order'=>'id DESC'));
	}
	
}