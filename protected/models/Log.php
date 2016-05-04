<?php

/**
 * This is the model class for table "{{log}}".
 *
 * The followings are the available columns in table '{{log}}':
 * @property integer $id
 * @property integer $id_user
 * @property integer $id_orden
 * @property integer $id_empresa
 * @property integer $id_producto
 * @property integer $id_email_invitacion
 * @property integer $id_masterData
 * @property integer $id_inbound
 * @property integer $id_almacen
 * @property string $fecha
 * @property integer $accion
 */
class Log extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{log}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_user, id_orden, id_empresa, id_producto, id_email_invitacion, id_masterData, id_inbound, id_almacen, accion', 'numerical', 'integerOnly'=>true),
            array('fecha', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, id_user, id_orden, id_empresa, id_producto, id_email_invitacion, id_masterData, id_inbound, id_almacen, fecha, accion', 'safe', 'on'=>'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'id_user' => 'Id User',
            'id_orden' => 'Id Orden',
            'id_empresa' => 'Id Empresa',
            'id_producto' => 'Id Producto',
            'id_email_invitacion' => 'Id Email Invitacion',
            'id_masterData' => 'Id Master Data',
            'id_inbound' => 'Id Inbound',
            'id_almacen' => 'Id Almacen',
            'fecha' => 'Fecha',
            'accion' => 'Accion',
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
        $criteria->compare('id_user',$this->id_user);
        $criteria->compare('id_orden',$this->id_orden);
        $criteria->compare('id_empresa',$this->id_empresa);
        $criteria->compare('id_producto',$this->id_producto);
        $criteria->compare('id_email_invitacion',$this->id_email_invitacion);
        $criteria->compare('id_masterData',$this->id_masterData);
        $criteria->compare('id_inbound',$this->id_inbound);
        $criteria->compare('id_almacen',$this->id_almacen);
        $criteria->compare('fecha',$this->fecha,true);
        $criteria->compare('accion',$this->accion);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Log the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function retornarAcciones($id_user=NULL, $id_orden=NULL, $id_empresa=NULL, $id_producto=NULL, $id_email_invitacion=NULL,
     $id_masterData=NULL, $id_inbound=NULL, $id_almacen=NULL, $fecha=NULL, $accion=NULL)
    {
        switch ($accion)
        {
        case 1:
            $mensaje="Has añadido el producto <b>".Producto::model()->findByPk($id_producto)->nombre."</b> a tu carrito";
            break;
        case 2:
            $mensaje="Has eliminado el producto <b>".Producto::model()->findByPk($id_producto)->nombre."</b>  de tu carrito";
            break;
        case 3:
            $mensaje="Has modificado el producto <b>".Producto::model()->findByPk($id_producto)->nombre."</b> en tu carrito";
            break;
        case 4:
            $mensaje="Has generado la intención de compra <b>#".$id_orden."</b>";
            break;
        case 5:
            $mensaje="Te han aprobado la intención de compra <b>#".$id_orden."</b>";
            break;
        case 6:
            $mensaje="Te han rechazado la intención de compra <b>#".$id_orden."</b>";
            break;
        case 8:
            $mensaje="Has aprobado la intención de compra <b>#".$id_orden."</b>";
            break;
        case 9:
            $mensaje="Has rechazado la intención de compra <b>#".$id_orden."</b>";
            break;
        case 10:
            $mensaje="Has solicitado la creación del producto <b>".Producto::model()->findByPk($id_producto)->nombre."</b>";
            break;
        case 11:
            $mensaje="Le has cargado inventario al producto <b>".Producto::model()->findByPk($id_producto)->nombre.
            "</b> en el almacen <b>".Almacen::model()->findByPk($id_almacen)->alias."</b>";
            break;
        case 12:
            $mensaje="Has subido el inbound #<b>".$id_inbound."</b>";
            break;
        case 13:
            $mensaje="Has subido el masterdata  #<b>".$id_masterData."</b>";
            break;
        case 14:
            $mensaje="Has creado el almacen <b>".Almacen::model()->findByPk($id_almacen)->alias."</b>";
            break;
        case 15:
            $mensaje="Has modificado el almacen <b>".Almacen::model()->findByPk($id_almacen)->alias."</b>";
            break;
        }
        return $mensaje;   
    }
}