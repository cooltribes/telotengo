<?php

/**
 * This is the model class for table "{{giftcard}}".
 *
 * The followings are the available columns in table '{{giftcard}}':
 * @property integer $id
 * @property string $codigo
 * @property double $monto
 * @property integer $estado
 * @property string $inicio_vigencia
 * @property string $fin_vigencia
 * @property string $fecha_uso
 * @property integer $comprador
 * @property integer $beneficiario
 *
 * The followings are the available model relations:
 * @property Users $beneficiario0
 * @property Users $comprador0
 */
class Giftcard extends CActiveRecord
{
/*
Estados
    1. Enviada
    2. Aplicada
    3. Inactiva
*/
    const MAX_MONTO = 5000; 

    //Montos para Venezuela
    public static $montos = array(
        200 => 200,
        500 => 500,
        1000 => 1000,
        1500 => 1500,
        2000 => 2000,
        3000 => 3000,
        4000 => 4000,
        5000 => 5000,
    );
    
    public static $montosCurr = array(
        200 => '200 Bs',
        500 => '500 Bs',
        1000 => '1000 Bs',
        1500 => '1500 Bs',
        2000 => '2000 Bs',
        3000 => '3000 Bs',
        4000 => '4000 Bs',
        5000 => '5000 Bs',
    );
    

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{giftcard}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('codigo, monto, estado, inicio_vigencia, fin_vigencia, comprador', 'required'),
            array('estado, comprador', 'numerical', 'integerOnly'=>true), 
            array('monto', 'numerical'),
            array('codigo', 'length', 'max'=>25),
            array('fecha_uso', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, codigo, monto, estado, inicio_vigencia, fin_vigencia, fecha_uso, comprador, beneficiario, orden_id', 'safe', 'on'=>'search'),
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
            'comprador0' => array(self::BELONGS_TO, 'Users', 'comprador'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'codigo' => 'Codigo',
            'monto' => 'Monto',
            'estado' => 'Estado',
            'inicio_vigencia' => 'Inicio Vigencia',
            'fin_vigencia' => 'Fin Vigencia',
            'fecha_uso' => 'Fecha Uso',
            'comprador' => 'Comprador',
            'beneficiario' => 'Beneficiario',
            'orden_id' => 'Orden ID',
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
        $criteria->compare('codigo',$this->codigo,true);
        $criteria->compare('monto',$this->monto);
        $criteria->compare('estado',$this->estado);
        $criteria->compare('inicio_vigencia',$this->inicio_vigencia,true);
        $criteria->compare('fin_vigencia',$this->fin_vigencia,true);
        $criteria->compare('fecha_uso',$this->fecha_uso,true);
        $criteria->compare('comprador',$this->comprador);
        $criteria->compare('beneficiario',$this->beneficiario);
        $criteria->compare('orden_id',$this->orden_id);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Giftcard the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }


   public static function getMontos($curr = NULL) {
        if(is_null($curr))    
            return self::$montos;
        else                      
            return self::$montosCurr;
   }

    /*Retorna los ultimos 4 digitos del codigo con formato*/
    public function getMascaraCodigo($codigo) {
        
        return 'XXXX-XXXX-XXXX-'.substr($codigo, 12,14);
    }

    /* Devuelve el estado */
    public function getEstado(){
        switch ($this->estado) {
            case 1:
                return "Enviada";            
            case 2:
                return "Aplicada";
            case 3:
                return "Inactiva";
        }
    }
    
    static function generarCodigo(){
        $cantNum = 8;
        $cantLet = 8;
        
        $l = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        
        $LETRAS = str_split($l);
        $NUMEROS = range(0, 9);

        $codigo = array();
        //Seleccionar cantLet letras
        for ($i = 0; $i < $cantLet; $i++) {
            $codigo[] = $LETRAS[array_rand($LETRAS)];
        }
        for ($i = 0; $i < $cantNum; $i++) {
            $codigo[] = array_rand($NUMEROS);
        }
        
        shuffle($codigo);
        $codigo = implode("", $codigo);
        
        return $codigo;
    }   

    public static function getMontoMaximo() {
        return self::MAX_MONTO;            
    }

}