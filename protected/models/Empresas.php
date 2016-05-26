<?php

/**
 * This is the model class for table "tbl_empresas".
 *
 * The followings are the available columns in table 'tbl_empresas':
 * @property integer $id
 * @property string $telefono
 * @property string $razon_social
 * @property string $rif
 * @property integer $estado
 * @property integer $destacado
 *
 * The followings are the available model relations:
 * @property Almacen[] $almacens
 * @property CalificacionEmpresa[] $calificacionEmpresas
 * @property Documentos[] $documentoses
 * @property EmpresasHasTblUsers[] $empresasHasTblUsers
 */

class Empresas extends CActiveRecord
{

/*
 * Estados:
 * 
 * 1- Solicitado
 * 2- Aprobado
 * 3- Rechazado
 * 4- Suspendido
 * 5- Solicitud cancelada
 * 
 */ 

const STATUS_NOACTIVE=0;
const STATUS_ACTIVE=1;

/*
Tipos de empresa (tipo):
2 = empresa vendedora 
3 = Como cliente
4 = realizó la solicitud y hay que verificar
*/

/*
Tipos de contribuyente (tipo_contribuyente):
0 = Contribuyente Ordinario
1 = Contribuyente Especial
2 = Contribuyente Formal
*/

const TYPE_EMPRESA = 2;
const TYPE_CLIENTE = 3;
const TYPE_USUARIO_SOLICITA = 4;

/*
Forma Legal
1 - Cooperativa
2 - Sociedad de Responsabilidad Limitada
3 - Firma Personal
4 - Sociedad Anónima
5 - Compañía Anónima
*/

const FORMA_COOPERATIVA =1;
const FORMA_SRL = 2;
const FORMA_FIRMA = 3;
const FORMA_SA = 4;
const FORMA_CA = 5;

/*
Sector
1 - Alimentos y Bebidas
2 - Comercio al mayor
3 - Comercio al menor
4 - Industrial
*/

const SECTOR_ALIMENTOS =1;
const SECTOR_MAYOR = 2;
const SECTOR_MENOR = 3;
const SECTOR_INDUSTRIAL = 4;
const SECTOR_CONSTRUCCION = 5;
const SECTOR_ENTRETENIMIENTO = 6;
const SECTOR_HOTELERIA = 7;
const SECTOR_INFORMATICA = 8;
const SECTOR_SALUD = 9;
const SECTOR_SERVICIOS = 10;
const SECTOR_TRANSPORTE = 11;
const SECTOR_OTRO = 12;
const SECTOR_AGROPECUARIA = 13;
const SECTOR_BANCA = 14;
const SECTOR_ENERGIA = 15;
const SECTOR_EDUCACION = 16;

	public $prefijo="";
	public $numero="";
	
	public $tipoEmpresa, $provincia, $ciudad, $ciudad2;
	
	public $otraOpcion;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Empresas the static model class
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
		return 'tbl_empresas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('razon_social, rif, direccion,  ciudad,  sector, cargo,  ciudad, provincia, tipo_contribuyente', 'required'),
			array('estado, destacado, tipo', 'numerical', 'integerOnly'=>true),
			array('telefono', 'numerical', 'integerOnly'=>true, 'message'=>'Debe escribir el código seguido por el número sin espacios ni guiones'),
			array('url', 'length', 'max'=>255),
			array('direccion, mail, web' ,'length', 'max'=>255),
			array('razon_social', 'length', 'max'=>205),
			array('ciudad', 'length', 'max'=>150),
			array('rif', 'length', 'max'=>45),
			/*array('rif', 'match',
				'pattern' => '/^[JGVE][-][0-9]{7,10}$/', // ^[JGVE]{1}[-][0-9]{7,10}$ Vieja: ^[JGVE]{1}[-][0-9]\d{8}$
            	'message' => 'Formato no valido para el rif.',
            	'allowEmpty'=>false,
       	 	), */
       	 	array('numero', 'match',
				'pattern' => '/^[0-9]{7,10}$/',
            	'message' => 'Formato no valido -> introduzca solo números (Mínimo 7, Máximo 10).',
       	 	),
       	 	array('prefijo','compare','compareValue'=>'0','operator'=>'!=','allowEmpty'=>false, 'message'=>'Seleccione una opción'),
       	 	#array('numero','required','message'=>'Introduzca los numeros del RIF.'), 
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, telefono, razon_social, rif, estado, destacado, tipo, url, direccion, mail, web, numero, prefijo, ciudad, comentario, forma_legal, sector, num_empleados, cargo, tipo_contribuyente', 'safe', 'on'=>'search'),
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
			'almacens' => array(self::HAS_MANY, 'Almacen', 'empresas_id'),
			'calificacionEmpresas' => array(self::HAS_MANY, 'CalificacionEmpresa', 'empresas_id'),
			'documentoses' => array(self::HAS_MANY, 'Documentos', 'empresas_id'),
			'empresasHasTblUsers' => array(self::HAS_MANY, 'EmpresasHasTblUsers', 'empresas_id'),
			'bolsa' => array(self::HAS_ONE, 'Bolsa', 'empresas_id'),
			'city' => array(self::BELONGS_TO, 'Ciudad', 'ciudad'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'telefono' => 'Teléfono',
			'razon_social' => 'Nombre o Razón Social',
			'rif' => 'RIF',
			'estado' => 'Estado',
			'destacado' => 'Destacado',
			'tipo' => 'Tipo',
			'url' => 'Url amigable',
			'direccion' => 'Dirección principal',
			'mail' => 'Email de la empresa',
			'web' => 'Pagina Web',
			'ciudad' => "Ciudad",
			'comentario' => 'Comentario (Opcional)', 
			'forma_legal' => 'Forma Legal', 
			'sector' => 'Sector',
			'num_empleados' => 'Número de empleados',
			'cargo' => 'Cargo',
			'provincia'=>'Estado',
			'ciudad'=>'Ciudad',
			'tipo_contribuyente'=>'Tipo de contribuyente',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($query=NULL){

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('telefono',$this->telefono);
		$criteria->compare('razon_social',$this->razon_social,true);
		$criteria->compare('rif',$this->rif,true);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('destacado',$this->destacado);
		$criteria->compare('tipo',$this->tipo);
		$criteria->compare('direccion',$this->direccion);
		$criteria->compare('mail',$this->mail);
		$criteria->compare('web',$this->web);
		$criteria->compare('ciudad',$this->ciudad);
		$criteria->compare('comentario',$this->comentario);
		$criteria->compare('forma_legal',$this->forma_legal);
		$criteria->compare('sector',$this->sector);
		$criteria->compare('num_empleados',$this->num_empleados);
		$criteria->compare('tipo_contribuyente',$this->forma_legal);
		$criteria->addCondition(" id in (select empresas_id from tbl_bolsa) and razon_social like '%".$query."%'");


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/*public function beforeValidate(){
		$this->rif = $this->prefijo."-".$this->numero;
		
		return parent::beforeValidate();
  	}*/

	public function beforeSafe() {
		$this->rif = $this->prefijo."-".$this->numero;

		return parent::beforeSafe();
  	}
	
	public function empresasUser()
	{
	
		$user_id = Yii::app()->user->id;
	
		$sql='select a.* from tbl_empresas a, tbl_empresas_has_tbl_users b, tbl_users c where a.id = b.empresas_id and c.id='.$user_id.'
			and c.id = b.users_id';
		
		$dataProvider=new CSqlDataProvider($sql, array(
		    'sort'=>array(
		        'attributes'=>array( 
		             'id',
		        ),
		    ),
		));

		return $dataProvider;
	}

	public static function itemAlias($type,$code=NULL) {
		$_items = array(
			'EmpresaType' => array(
				self::TYPE_EMPRESA => 'Empresa Vendedora',
				self::TYPE_CLIENTE => 'Empresa Cliente',
				self::TYPE_USUARIO_SOLICITA => 'Empresa de usuario que realizó solicitud',
			),
			'FormaLegal' => array(
				self::FORMA_COOPERATIVA => 'Cooperativa',
				self::FORMA_SRL => 'Sociedad de Responsabilidad Limitada',
				self::FORMA_FIRMA => 'Firma Personal',
				self::FORMA_SA => 'Sociedad Anónima',
				self::FORMA_CA => 'Compañía Anónima',
			),
			'Sector' => array(
				self::SECTOR_ALIMENTOS => 'Alimentos y Bebidas',
				self::SECTOR_MAYOR => 'Comercio al Mayor',
				self::SECTOR_MENOR => 'Comercio al Menor',
				self::SECTOR_INDUSTRIAL => 'Industrial',
				self::SECTOR_CONSTRUCCION => 'Construcción y Bienes Raíces',
				self::SECTOR_ENTRETENIMIENTO => 'Entretenimiento',
				self::SECTOR_HOTELERIA => 'Hoteleria y Turismo',
				self::SECTOR_INFORMATICA => 'Informática y Telecomunicaciones',
				self::SECTOR_SALUD => 'Salud y Belleza',
				self::SECTOR_SERVICIOS => 'Servicios Profesionales',
				self::SECTOR_TRANSPORTE => 'Automotríz y Transporte',
				self::SECTOR_AGROPECUARIA => 'Agropecuaria',
				self::SECTOR_BANCA => 'Banca y Finanzas',
				self::SECTOR_EDUCACION=> 'Educación',	
				self::SECTOR_ENERGIA => 'Energía y Minería',
				self::SECTOR_OTRO => 'Otro',
			),
			'Cargo' => array(
				'Dueño o Socio' => 'Dueño o Socio',
				'Junta Directiva' => 'Junta Directiva',
				'Gerente' => 'Gerente',
				'Empleado' => 'Empleado',
				'Otro'=>'Otro', 
			),
			'NumEmpleados' => array(
				'1 a 20' => '1 a 20',
				'21 a 50' => '21 a 50',
				'51 a 100' => '51 a 100',
				'Más de 100' => 'Más de 100', 
			),
			'TipoContribuyente' => array(
				'0' => 'Contribuyente Ordinario',
				'1' => 'Contribuyente Especial',
				'2' => 'Contribuyente Formal',
			),
		);
		if (isset($code))
			return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
		else
			return isset($_items[$type]) ? $_items[$type] : false;
	}
    
    public function getContadoresVentas($empresas_id = null){
        if(is_null($empresas_id)){
            $empresas_id=$this->id; 
        }    
        $sql = "select count(*) as contador from tbl_orden where almacen_id in (select id from tbl_almacen where empresas_id=".$empresas_id.")";
        $contador = Yii::app()->db->createCommand($sql)->queryRow();
        
        $sql = "select count(*) as contador  from tbl_orden where  estado=0 and almacen_id in (select id from tbl_almacen where empresas_id=".$empresas_id.")";
        $pendiente = Yii::app()->db->createCommand($sql)->queryRow();
        
        $sql = "select count(*) as contador  from tbl_orden where  estado=2 and almacen_id in (select id from tbl_almacen where empresas_id=".$empresas_id.")";
        $rechazado = Yii::app()->db->createCommand($sql)->queryRow();
                
        $sql = "select count(*) as contador  from tbl_orden where  estado=1 and almacen_id in (select id from tbl_almacen where empresas_id=".$empresas_id.")";
        $aprobado = Yii::app()->db->createCommand($sql)->queryRow();
        
        return array('total'=>$contador['contador'],'pendiente'=>$pendiente['contador'],'rechazado'=>$rechazado['contador'],'aprobado'=>$aprobado['contador']);
    }
    
    public function getEditoresCarrito($idProveedor=0,$all=false){
        $array=array();
        $sql="select h.users_id, h.id from tbl_historial_bolsa h JOIN tbl_bolsa_has_tbl_inventario bhi ON h.bolsa_has_inventario_id=bhi.id JOIN tbl_bolsa b ON b.id=bhi.bolsa_id JOIN tbl_almacen a ON a.id=bhi.almacen_id JOIN tbl_empresas e ON e.id=a.empresas_id WHERE a.empresas_id =".$idProveedor." AND b.empresas_id =".$this->id." order by h.fecha desc";
        $pairs=Yii::app()->db->createCommand($sql)->queryAll();
        if($all){
            foreach($pairs as $key=>$pair){
                $array[$key]['user']=User::model()->findByPk($pair['users_id']);
                $array[$key]['accion']=HistorialBolsa::model()->findByPk($pair['id']);
            }
        }else{
            if(count($pairs)>=2)
            {
                 $array[0]['user']=User::model()->findByPk($pairs[count($pairs)-1]['users_id']);
                 $array[0]['accion']=HistorialBolsa::model()->findByPk($pairs[count($pairs)-1]['id']);
                $array[1]['user']=User::model()->findByPk($pairs[0]['users_id']);
                 $array[1]['accion']=HistorialBolsa::model()->findByPk($pairs[0]['id']);
                 
            }
            if(count($pairs)==1)
            {
                 
                 $array[0]['user']=User::model()->findByPk($pairs[count($pairs)-1]['users_id']);
                 $array[0]['accion']=HistorialBolsa::model()->findByPk($pairs[count($pairs)-1]['id']);
            }
        }
        return $array;        
    }
    
     public function getStaff($id = 0,$objects=true){
               if($id==0) 
                    $empresa=$this;
               else
                   $empresa=$this->findByPk($id);
               $ids=Yii::app()->db->createCommand("SELECT users_id from tbl_empresas_has_tbl_users where empresas_id = ".$empresa->id)->queryColumn();   
               if($objects){
                   return User::model()->findAll("id IN (".count($ids)>0?implode(",",$ids):"0".")");
               }
               else
                   return $ids;
           }
    
}
