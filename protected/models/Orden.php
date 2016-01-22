<?php
include("class.zoom.json.services.php");

/**
 * This is the model class for table "{{orden}}".
 *
 * The followings are the available columns in table '{{orden}}':
 * @property integer $id
 * @property double $descuento
 * @property double $envio
 * @property double $iva
 * @property double $total
 * @property string $fecha
 * @property integer $estado
 * @property integer $users_id
 * @property integer $tipo_pago_id
 * @property integer $balance 
 *
 * The followings are the available model relations:
 * @property DetalleOrden[] $detalleOrdens
 * @property TipoPago $tipoPago
 * @property Users $users
 * @property OrdenHasInventario[] $ordenHasInventarios
 */


/*
 * Definicion de los estados de la orden

	0	Pendiente
	1	Aprobada
	2	Rechazada

 * 
 * -------------- 
 * Tipo de Guia
 * --------------
 * 0 - Envio Estandar
 * 1 - Entre 0.5 kg y 5 kg
 * 2 - Mayor a 5 kg
 * */



class Orden extends CActiveRecord
{	

	const ESTADO_ESPERA = 1;
	const ESTADO_ESPERA_CONF = 2;
	const ESTADO_CONFIRMADO = 3;
        
	const ESTADO_ENVIADO = 4;
	const ESTADO_CANCELADO = 5;
	const ESTADO_RECHAZADO = 6;
	
    const ESTADO_INSUFICIENTE = 7;	
	const ESTADO_ENTREGADA = 8;
	const ESTADO_DEVUELTA = 9;
        
	const ESTADO_PARC_DEV = 10;  
	const ESTADO_FINALIZADA = 11;  
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_orden';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('envio, iva, total, fecha, estado, users_id, tipo_pago_id, tipo_guia', 'required'),
			array('empresa_id, almacen_id, users_id, fecha, estado,  tipo_pago_id', 'required'),
			array('estado, users_id, tipo_pago_id', 'numerical', 'integerOnly'=>true),
			//array('descuento, envio, iva, total', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, descuento, envio, iva, total, fecha, estado, users_id, tipo_pago_id, tipo_guia, tracking, balance, direccionEnvio_id', 'safe', 'on'=>'search'),
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
			'detalleOrdens' => array(self::HAS_MANY, 'DetalleOrden', 'orden_id'),
			'empresa'=> array(self::BELONGS_TO, 'Empresas', 'empresa_id'),
			'almacen'=> array(self::BELONGS_TO, 'Almacen', 'almacen_id'),
			'tipoPago' => array(self::BELONGS_TO, 'TipoPago', 'tipo_pago_id'),
			'users' => array(self::BELONGS_TO, 'User', 'users_id'),
			'direccionEnvio' => array(self::BELONGS_TO, 'DireccionEnvio','direccionEnvio_id'),
			'ordenHasInventarios' => array(self::HAS_MANY, 'OrdenHasInventario', 'orden_id'),
			'totalpagado' => array(self::STAT, 'DetalleOrden', 'orden_id',
            	'select' => 'SUM(monto)',
            	'condition' => 'estado = 1'
        	),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'descuento' => 'Descuento',
			'envio' => 'Envio',
			'iva' => 'Iva',
			'total' => 'Total',
			'fecha' => 'Fecha',
			'estado' => 'Estado',
			'users_id' => 'Users',
			'tipo_pago_id' => 'Tipo Pago',
			'tipo_guia' => 'Tipo Guía',
			'tracking' => 'Tracking',
			'balance' => 'Balance',
			'direccionEnvio_id' => 'ID Direccion Envio',
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
		//$criteria->compare('descuento',$this->descuento);
		$criteria->compare('envio',$this->envio);
		$criteria->compare('iva',$this->iva);
		$criteria->compare('total',$this->total);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('users_id',$this->users_id);
		$criteria->compare('tipo_pago_id',$this->tipo_pago_id);
		//$criteria->compare('tipo_guia',$this->tipo_guia);
		//$criteria->compare('tracking',$this->tracking);
		//$criteria->compare('balance',$this->balance);
		$criteria->compare('direccionEnvio_id',$this->direccionEnvio_id);
		$criteria->order = "id DESC";
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchCompra($empresas_id)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		//$criteria->compare('descuento',$this->descuento);
		$criteria->compare('envio',$this->envio);
		$criteria->compare('iva',$this->iva);
		$criteria->compare('total',$this->total);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('estado',$this->estado);
		//$criteria->compare('users_id',Yii::app()->user->id);
		$criteria->compare('tipo_pago_id',$this->tipo_pago_id);
		//$criteria->compare('tipo_guia',$this->tipo_guia);
		//$criteria->compare('tracking',$this->tracking);
		//$criteria->compare('balance',$this->balance);
		$criteria->compare('direccionEnvio_id',$this->direccionEnvio_id);
		#$criteria->condition = 'users_id=:users_id';
		#$criteria->params=(array(':users_id'=>Yii::app()->user->id));
		$criteria->condition='empresa_id="'.$empresas_id.'"';
		$criteria->order = "id DESC";
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchCompraIndividual($variable,$empresas_id)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		//$criteria->compare('descuento',$this->descuento);
		$criteria->compare('envio',$this->envio);
		$criteria->compare('iva',$this->iva);
		$criteria->compare('total',$this->total);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('estado',$this->estado);
		//$criteria->compare('users_id',Yii::app()->user->id);
		$criteria->compare('tipo_pago_id',$this->tipo_pago_id);
		//$criteria->compare('tipo_guia',$this->tipo_guia);
		//$criteria->compare('tracking',$this->tracking);
		//$criteria->compare('balance',$this->balance);
		$criteria->compare('direccionEnvio_id',$this->direccionEnvio_id);
		#$criteria->condition = 'users_id=:users_id';
		#$criteria->params=(array(':users_id'=>Yii::app()->user->id));
		$criteria->condition='(almacen_id in (select id from tbl_almacen where empresas_id in (select id from tbl_empresas where razon_social like "%'.$variable.'%")) or id="'.$variable.'") and empresa_id="'.$empresas_id.'"';
		$criteria->order = "id DESC";
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchVentas($empresas_id)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		//$criteria->compare('descuento',$this->descuento);
		$criteria->compare('envio',$this->envio);
		$criteria->compare('iva',$this->iva);
		$criteria->compare('total',$this->total);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('users_id',$this->users_id);
		$criteria->compare('tipo_pago_id',$this->tipo_pago_id);
		//$criteria->compare('tipo_guia',$this->tipo_guia);
		//$criteria->compare('tracking',$this->tracking);
		//$criteria->compare('balance',$this->balance);
		$criteria->compare('direccionEnvio_id',$this->direccionEnvio_id);
		//$criteria->condition = 'users_id=:users_id';
		//$criteria->params=(array(':users_id'=>Yii::app()->user->id));
		$criteria->condition= 'almacen_id in (select id from tbl_almacen where empresas_id='.$empresas_id.')';
		$criteria->order = "id DESC";
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchVentasIndividual($variable, $empresas_id)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		//$criteria->compare('descuento',$this->descuento);
		$criteria->compare('envio',$this->envio);
		$criteria->compare('iva',$this->iva);
		$criteria->compare('total',$this->total);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('users_id',$this->users_id);
		$criteria->compare('tipo_pago_id',$this->tipo_pago_id);
		//$criteria->compare('tipo_guia',$this->tipo_guia);
		//$criteria->compare('tracking',$this->tracking);
		//$criteria->compare('balance',$this->balance);
		$criteria->compare('direccionEnvio_id',$this->direccionEnvio_id);
		//$criteria->condition = 'users_id=:users_id';
		//$criteria->params=(array(':users_id'=>Yii::app()->user->id));
		$criteria->condition= '(empresa_id in(select id from tbl_empresas where razon_social like "%'.$variable.'%") or id="'.$variable.'") and almacen_id in (select id from tbl_almacen where empresas_id='.$empresas_id.')';
		$criteria->order = "id DESC";
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getCiudades(){
			
		$cliente = new ZoomJsonService("http://www.grupozoom.com/servicios/webservices/");
	 	//return array($ciudad,$nproductos,$peso,round($total,2));
		
	 	//return $cliente;
	 	return $cliente->call("CalcularTarifa", array("tipo_tarifa"=>"2","modalidad_tarifa"=>"2","ciudad_remitente"=>"250","ciudad_destinatario"=>"17",NULL,"cantidad_piezas"=>"2","peso"=>"1.6",NULL,"valor_declarado"=>"248"));
	 
		
	}

	public function calcularTarifa($ciudad,$nproductos,$peso,$total){
			
		$cliente = new ZoomJsonService("http://www.grupozoom.com/servicios/webservices/");
	 	//return array($ciudad,$nproductos,$peso,round($total,2));
		
	 	return $cliente->call("CalcularTarifa", array("tipo_tarifa"=>"2","modalidad_tarifa"=>"2","ciudad_remitente"=>"15","ciudad_destinatario"=>$ciudad,NULL,"cantidad_piezas"=>$nproductos, "peso"=>$peso,NULL,"valor_declarado"=>$total));
	 
		//Devuelve array de tracking si lo consigue o null si no
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Orden the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getxPagar($id=null){
			
		if(is_null($id))
			$porpagar=$this->total-$this->totalpagado;
		else
		{
			$orden=$this->findByPk($id);
			$porpagar=$orden->total-$orden->totalpagado;
		}
		if($porpagar<0)
			$porpagar=0;
		
		return $porpagar;
		
	} 

	public function getEmpresaOrders($empresa_id){
		$sql='select o.*, a.empresas_id from tbl_orden o, tbl_orden_has_inventario oi, tbl_inventario i, tbl_almacen a WHERE o.id = oi.orden_id AND oi.inventario_id = i.id AND i.almacen_id = a.id AND a.empresas_id = '.$empresa_id;
		$count=Yii::app()->db->createCommand('select COUNT(*) from tbl_orden o, tbl_orden_has_inventario oi, tbl_inventario i, tbl_almacen a WHERE o.id = oi.orden_id AND oi.inventario_id = i.id AND i.almacen_id = a.id AND a.empresas_id = '.$empresa_id)->queryScalar();
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
	
	public function CuatroComprados($id)
	{
		$orden = Orden::model()->findAllByAttributes(array('users_id'=>$id));
		
		if(count($orden)>0){
			
		$sql = '
		select e.* from tbl_orden a, tbl_orden_has_inventario b, tbl_inventario c, tbl_users d, tbl_producto e where d.id = '.$id.'
		and a.id = b.orden_id and a.users_id='.$id.' and c.producto_id = e.id and b.inventario_id = c.id group by e.id ORDER BY RAND()
		'; 
			$dataProvider=new CSqlDataProvider($sql, array( 
				'sort'=>array(
			        'attributes'=>array(
			             'id',
			        ),
			    ),
				'pagination'=>array(
			        'pageSize'=>4,
			    ),
			));
	
			return $dataProvider;
			
		}
		else
			return false; 

		
	}

	/* Funcion para conseguir las ultimas ventas */
	public function getLast(){
	    return $this->findAll(array('limit'=>4,'offset'=>0,'order'=>'id DESC'));
	}

	public function getStatus($status){

		switch ($status) {
	    case 1:
	        return "<td>En espera de pago</td>";
	    case 2:
	        return "<td>En espera de confirmación</td>";
	    case 3:
	        return "<td>Pago Confirmado</td>";
		case 4: 
			return "<td>Orden Enviada</td>";
		case 5:	
			return "<td>Orden Cancelada</td>";
		case 6:
			return "<td>Pago Rechazado</td>";
		case 7:
			return "<td>Pago Insuficiente</td>";
		case 8:
			return "<td>Entregado</td>";
		case 9:
			return "<td>Orden Devuelta</td>";
		case 10:
			return "<td>Parcialmente Devuelto</td>";
		}

	} // get
	
	// Devuelve la cantidad de pedidos activos (estados 1 a 4)
	public function totalActivos(){
		$user = User::model()->findByPk(Yii::app()->user->id);
		$pedidos = Orden::model()->findAllByAttributes(array('users_id'=>$user->id));
		$activo=0;

		foreach($pedidos as $pedido){
			if($pedido->estado < 5)
				$activo++;
		}

		return $activo;
	}

	// Devuelve la cantidad de pedidos por pagar
	public function pagosRequeridos(){
		$user = User::model()->findByPk(Yii::app()->user->id);
		$pedidos = Orden::model()->findAllByAttributes(array('users_id'=>$user->id));
		$requeridos=0;

		foreach($pedidos as $pedido){
			if($pedido->estado == 1)
				$requeridos++;
		}

		return $requeridos;
	}

	public function totalDeuda($id){
		$user = User::model()->findByPk(Yii::app()->user->id);
		$pedido = Orden::model()->findByPk($id);
		$total = 0;
		$pagos = DetalleOrden::model()->findAllByAttributes(array('orden_id'=>$id,'estado'=>1));

		foreach($pagos as $pago){
			$total += $pago->monto;
		}

		return $pedido->total - $total;
	}

	public function cuantosPagos($id){
		$user = User::model()->findByPk(Yii::app()->user->id);
		$pedido = Orden::model()->findByPk($id);
		$total = 0;
		$pagos = DetalleOrden::model()->findAllByAttributes(array('orden_id'=>$id,'estado'=>1));

		if(count($pagos)>0){
			return count($pagos);
		}
		else{
			return 0;
		}
	}
	
	public function estados($estado,$class=null)
	{
		if(!is_null($class)){
		    if($estado==0)
                return "yellow-text";
            if($estado==1)
                return "green-text";
            if($estado==2)
                return "red-text";
		    
		}    
		if($estado==0)
			return "Pendiente";
		if($estado==1)
			return "Aprobada";
		if($estado==2)
			return "Rechazada";
		
	}
    
    public function getTotal(){
        return $this->monto*1.12;
    }
    public function ultima_fecha($format ="Y-m-d h:i:s"){
        $sql="select fecha from tbl_orden_estado where orden_id=".$this->id." order by fecha desc  limit 1";
        $obj=Yii::app()->db->createCommand($sql)->queryScalar();
        
        if($obj)
            return date($format,strtotime($obj));
        else
            return '-';
    }
    public function searchByEmpresa($query){
        if(str_replace(' ', '', $query)!=''){
            $ids=implode(',',Yii::app()->db->createCommand("select id from tbl_empresas where razon_social LIKE '%".$query."%'")->queryColumn());
            $ids=strlen($ids)>0?$ids:0;
            $alms=implode(',',Yii::app()->db->createCommand("select id from tbl_almacen where empresas_id IN(".$ids.")")->queryColumn());
            $alms=strlen($alms)>0?$alms:0;
           
            $criteria=new CDbCriteria;
            $criteria->addCondition(" t.almacen_id IN (".$alms.") OR t.empresa_id IN(".$ids.")");
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
        }else
            return $this->search();
        
    }
    
    
    
    

}
