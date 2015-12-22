<?php

/**
 * This is the model class for table "tbl_categoria".
 *
 * The followings are the available columns in table 'tbl_categoria': 
 * @property integer $id
 * @property string $nombre
 * @property integer $id_seo
 * @property string $imagen_url
 * @property string $destacado
 * @property string $descripcion
 *
 * The followings are the available model relations:
 * @property CategoriaHasTblProducto[] $categoriaHasTblProductos
 */
class Categoria extends CActiveRecord
{
	/** 
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Categoria the static model class
	 */
	public $oculta;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_categoria';
	}

	/**
	 * @return array validation rules for model attributes.
	 */ 
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, id_padre, nomenclatura', 'required'),
			array('nombre', 'length', 'max'=>80),
			array('nomenclatura', 'unique', 'message' =>'la nomenclatura esta siendo utilizada'),
			array('url_amigable', 'length', 'max'=>150),
			array('imagen_url', 'length', 'max'=>250),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, url_amigable, id_padre, imagen_url, destacado, descripcion, id_seo, nomenclatura', 'safe', 'on'=>'search'),
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
			'categoriaHasTblProductos' => array(self::HAS_MANY, 'CategoriaHasTblProducto', 'categoria_id'),
			'seo' => array(self::BELONGS_TO, 'Seo', 'id_seo'),
            'padre' => array(self::BELONGS_TO, 'Categoria', 'id_padre'),
            'hijos' => array(self::HAS_MANY, 'Categoria', 'id_padre'),
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
			'url_amigable' => 'Url Amigable',
			'imagen_url' => 'Imagen Url',
			'id_padre' => 'Id Padre',
			'destacado' => 'Destacado',
			'descripcion' => 'Descripción',
			'id_seo'=> 'SEO'
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
		$criteria->compare('id_padre',$this->id_padre,true);
		$criteria->compare('url_amigable',$this->url_amigable,true);
		$criteria->compare('imagen_url',$this->imagen_url,true);
		$criteria->compare('destacado',$this->destacado,true);
		$criteria->compare('descripcion',$this->descripcion,true);
        $criteria->compare('id_seo',$this->id_seo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria, 
		));
	}
	
	public function hasChildren(){
		if (Categoria::model()->findByAttributes(array('id_padre'=>$this->id))){
			return true; 
		}	else {
			return false;
		}
	}
	
	public function getChildren(){
		return Categoria::model()->findAllByAttributes(array('id_padre'=>$this->id),array('order'=>'nombre ASC'));
	}
	
	
	
	public function recursividad($lista, &$todos=Array(), $nivel=0)
	{
		#$todos = Array();
			
			$sublista=Categoria::model()->findAllByAttributes(array('id_padre'=>$lista));
			if(isset($sublista))
			{  $nivel++;
				foreach($sublista as $sub)
				{		
					#array_push($todos,array($sub->id=>$sub->nombre));
					array_push($todos,str_repeat(html_entity_decode('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'),$nivel-1).$sub->nombre."+".$sub->id);		
					$this->recursividad($sub->id, $todos, $nivel);
				}
			}
	return $todos;		
	}
	
	public function combinar(&$cat=Array())
	{
		$valor=array();
		$nom=array();
		foreach($cat as $cate)
		  { 
		  	 $cats=explode("+", $cate);
			 array_push($valor,$cats[0]);
			 array_push($nom,$cats[1]);
		  }
		$combinar=array_combine($nom,$valor);
		return $combinar;
	}
	
	public function verificar($idGeneralP, $idCadaUno)
	{
		//return $idCadaUno;
		$categoria=Categoria::model()->findByPk($idGeneralP);
		if($categoria->categorias_relacionadas!="")
		{
			$cat_id=explode(",", $categoria->categorias_relacionadas);
			foreach($cat_id as $each)
			{
				if($idCadaUno==$each)
				{	
					return $idCadaUno;
				}	
			}
			return 0;
		}
		else {
			return 0;
		}
	}
    
    public function getImgUrl($thumbnail = false){
        if(!$thumbnail){
            return Yii::app()->request->baseUrl."/images/categoria/".$this->id."/".$this->imagen_url;
        }else{
            return Yii::app()->request->baseUrl."/images/categoria/".$this->id."/".str_replace('.','_thumb.',$this->imagen_url);
        }
    }
    
    public function setSeo(){ 
        if(!$this->seo){
            $seo=new Seo;
            $seo->amigable=Funciones::cleanUrlSeo($this->nombre); 
            $seo->save();            
            $this->id_seo =$seo->id;
            return $this->save(); 
        }
        return true;
    }
    
    public function getCategoriasEnExistencia(){
        $sql="select distinct(pad.id_categoria) from tbl_producto_padre pad where pad.id IN (
        select distinct(p.padre_id) from tbl_producto p where p.id IN (
        select distinct(i.producto_id) from tbl_inventario i where i.cantidad >0))";
        $categorias=Yii::app()->db->createCommand($sql)->queryColumn();
        $array=array();
        
        foreach($categorias as $key=>$item){
            $padre=$this->getCategoriaOrigen($item);
            if(!isset($array[$padre])) 
                $array[$padre]=array();
           array_push($array[$padre],$this->getPrimerSubcategoria($item));
            $array[$padre]=array_unique($array[$padre]);
        }
        $return=array();
        foreach($array as $padre=>$hijos){            
            $a['objeto']=$this->findByPk($padre);
            $a['hijos']=array();
            foreach ($hijos as $hijo){
                array_push($a['hijos'],$this->findByPk($hijo));
            }
            array_push($return,$a);
        }
        return $return; 
    }
    public function getCategoriaOrigen($id){
        $categoria=Categoria::model()->findByPk($id);
        if(!is_null($categoria)){
            if($categoria->id_padre!=0) 
                $ret=$categoria->getCategoriaOrigen($categoria->id_padre);
            else
                return $categoria->id; 
        }    
        else {
            $ret=NULL;
        }
        return $ret;
    }
    public function getPrimerSubcategoria($id){
        if(is_null($id))
            $categoria=$this;
         else   
            $categoria=Categoria::model()->findByPk($id);
        if(!is_null($categoria)){
            if($categoria->padre->id_padre!=0)
                $ret=$categoria->getPrimerSubcategoria($categoria->id_padre);
            else
                return $categoria->id; 
        }    
        else {
            $ret=NULL;
        }       
        return $ret;
    }

     public function getDosPrimeras($id = null){
         if(is_null($id))
            $categoria=$this;
         else   
            $categoria=Categoria::model()->findByPk($id);
        if(!is_null($categoria)){
            if($categoria->padre->id_padre!=0)
                $ret=$categoria->getDosPrimeras($categoria->id_padre);
            else
                return array('padre'=>$categoria->id_padre, 'sub'=>$categoria->id); 
        }    
        else {
            $ret=NULL;
        }       
        return $ret;
    }
    
    public function getMyParent($id){
        return $this->padre;
    }
	
	public function buscarCategoria($nombre)
	{
		$model=Categoria::model()->findByAttributes(array('nombre'=>$nombre));
		if(isset($model))
			return $model->nombre;	
		else 
			return "";
		
	}
	
	public function buscarPadres($id, &$vector=Array())
	{
		$model=Categoria::model()->findByPk($id);
		if($model->id_padre==0)
		{
			array_push($vector, '0');
			
		}
		else
		{
			array_push($vector, $model->id);
			$this->buscarPadres($model->id_padre, $vector);
		}	
		return $vector;
	}
	
	public function buscarHijos($id, &$vector=Array())
	{
		if(Categoria::model()->findAllByAttributes(array('id_padre'=>$id)))
		{
			$model=Categoria::model()->findAllByAttributes(array('id_padre'=>$id));
			foreach($model as $modelado)
			{
				if($modelado->ultimo==1)
				{
					array_push($vector, $modelado->id);
				}
				else 
				{
					$this->buscarHijos($modelado->id, $vector);
				}
			}
		}
		return $vector;		
		
		
	}
	
	public function incluir(&$vector)
	{
		$word="";
		$num=count($vector);
		$i=1;
		if($num==1)
		{
			$word=$vector[0];
		}
		else 
		{
			foreach($vector as $vec)
			{
				if($i==1)
				{
					$word=$vec.",";
				}
				else 
				{
					if($i>=$num)	
						$word=$word.$vec;
					else 
						$word=$word.$vec.",";
				}	
	
				
				$i++;
			}
		}		

		return $word;
	}
    
    public function getStorefrontImgs($from = 1, $to = 6){
        return ConfImage::model()->findAll(array('condition'=>'t.index >='.$from.' AND t.index<='.$to.' AND categoria_id='.$this->id));
    }
	
}