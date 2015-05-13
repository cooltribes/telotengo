<?php
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
1 = empresa vendedora 
2 = Como cliente
3 = realizó la solicitud y hay que verificar
*/

const TYPE_EMPRESA = 2;
const TYPE_CLIENTE = 3;
const TYPE_USUARIO_SOLICITA = 4;

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
	public $prefijo="";
	public $numero="";
	
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
			array('razon_social, rif, direccion, mail, ciudad', 'required'),
			array('estado, destacado, tipo', 'numerical', 'integerOnly'=>true),
			array('url', 'length', 'max'=>255),
			array('direccion, mail, web' ,'length', 'max'=>255),
			array('razon_social', 'length', 'max'=>205),
			array('ciudad', 'length', 'max'=>150),
			array('rif', 'length', 'max'=>45),
			array('rif', 'match',
				'pattern' => '/^[JGVE][-][0-9]{7,10}$/', // ^[JGVE]{1}[-][0-9]{7,10}$ Vieja: ^[JGVE]{1}[-][0-9]\d{8}$
            	'message' => 'Formato no valido para el rif.',
            	'allowEmpty'=>false,
       	 	), 
       	 	array('numero', 'match',
				'pattern' => '/^[0-9]{7,10}$/',
            	'message' => 'Formato no valido -> introduzca solo números (Mínimo 7, Máximo 10).',
       	 	), 
       	 	array('prefijo','compare','compareValue'=>'0','operator'=>'!=','allowEmpty'=>false, 'message'=>'Seleccione una opción'),
       	 	array('numero','required','message'=>'Introduzca los numeros del RIF.'),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, telefono, razon_social, rif, estado, destacado, tipo, url, direccion, mail, web, numero, prefijo, ciudad', 'safe', 'on'=>'search'),
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
			'mail' => 'Email',
			'web' => 'Pagina Web',
			'ciudad' => "Ciudad",
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function beforeValidate(){
		$this->rif = $this->prefijo."-".$this->numero;
		
		return parent::beforeValidate();
  	}

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

}