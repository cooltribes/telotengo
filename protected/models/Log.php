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
     $id_masterData=NULL, $id_inbound=NULL, $id_almacen=NULL, $fecha=NULL, $accion=NULL, $id_admin=NULL, $id_producto_padre=NULL,
     $id_marca=NULL, $id_color=NULL, $id_unidad=NULL, $id_atributo=NULL, $id_categoria=NULL)
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
        case 16:
            $mensaje="Has modificado la informacion de la empresa <b>".Empresas::model()->findByPk($id_empresa)->razon_social."</b>";
            break;
        case 18:
            $mensaje="Has modificado la informacion del usuario <b>".Profile::model()->retornarNombreCompleto($id_user)."</b>";
            break;
        case 21:
            $mensaje="Has modificado el almacen <b>".Almacen::model()->findByPk($id_almacen)->alias."</b> de la Empresa <b>".Almacen::model()->findByPk($id_almacen)->empresas->razon_social."</b>";
            break;
        case 22:
            $mensaje="Has creado un nuevo producto padre con el nombre <b>".ProductoPadre::model()->findByPk($id_producto_padre)->nombre."</b>";
            break;
        case 23:
            $mensaje="Has creado una nueva variación con el nombre <b>".Producto::model()->findByPk($id_producto)->nombre."</b>";
            break;
        case 24:
            $mensaje="Has modificado la información vital de la variación <b>".Producto::model()->findByPk($id_producto)->nombre."</b>";
            break;
        case 25:
            $mensaje="Has aprobado la creación de la variación <b>".Producto::model()->findByPk($id_producto)->nombre."</b>";
            break;
        case 26:
            $mensaje="Has rechazado la creacion de la variación <b>".Producto::model()->findByPk($id_producto)->nombre."</b>";
            break;
        case 27:
            $mensaje="Has modificado el producto padre <b>".ProductoPadre::model()->findByPk($id_producto_padre)->nombre."</b>";
            break;
        case 28:
            $mensaje="Has creado la marca <b>".Marca::model()->findByPk($id_marca)->nombre."</b>";
            break;
        case 29:
            $mensaje="Has modificado la marca <b>".Marca::model()->findByPk($id_marca)->nombre."</b>";
            break;
        case 30:
            $mensaje="Has desactivado la marca <b>".Marca::model()->findByPk($id_marca)->nombre."</b>";
            break;
        case 31:
            $mensaje="Has activado la marca <b>".Marca::model()->findByPk($id_marca)->nombre."</b>";
            break;
        case 32:
            $mensaje="Has creado el color <b>".Color::model()->findByPk($id_color)->nombre."</b>";
            break;
        case 33:
            $mensaje="Has modificado el color <b>".Color::model()->findByPk($id_color)->nombre."</b>";
            break; 
        case 34:
            $mensaje="Has desactivado el color <b>".Color::model()->findByPk($id_color)->nombre."</b>";
            break;
        case 35:
            $mensaje="Has activado el color <b>".Color::model()->findByPk($id_color)->nombre."</b>";
            break;
        case 36:
            $mensaje="Has creado la unidad <b>".Unidad::model()->findByPk($id_unidad)->nombre."</b>";
            break;
        case 37:
            $mensaje="Has modificado la unidad <b>".Unidad::model()->findByPk($id_unidad)->nombre."</b>";
            break;
        case 38:
            $mensaje="Has desactivado la unidad <b>".Unidad::model()->findByPk($id_unidad)->nombre."</b>";
            break;
        case 39:
            $mensaje="Has activado la unidad <b>".Unidad::model()->findByPk($id_unidad)->nombre."</b>";
            break;
        case 40:
            $mensaje="Has creado el atributo <b>".Atributo::model()->findByPk($id_atributo)->nombre."</b>";
            break;
        case 41:
            $mensaje="Has modificado el atributo <b>".Atributo::model()->findByPk($id_atributo)->nombre."</b>";
            break;
        case 42:
            $mensaje="Has desactivado el atributo <b>".Atributo::model()->findByPk($id_atributo)->nombre."</b>";
            break;
        case 43:
            $mensaje="Has activado el atributo <b>".Atributo::model()->findByPk($id_atributo)->nombre."</b>";
            break;
        case 44:
            $mensaje="Has cambiado una imagen del storefront de la categoria <b>".Categoria::model()->findByPk($id_categoria)->nombre."</b>";
            break;
        case 45:
            $mensaje="Has creado la categoria <b>".Categoria::model()->findByPk($id_categoria)->nombre."</b>";
            break;
        case 46:
            $mensaje="Has modificado la información general de la categoria <b>".Categoria::model()->findByPk($id_categoria)->nombre."</b>";
            break;
        case 47:
            $mensaje="Has destacado la categoria <b>".Categoria::model()->findByPk($id_categoria)->nombre."</b>";
            break;
        case 48:
            $mensaje="Le has quitado el destacado a la categoria <b>".Categoria::model()->findByPk($id_categoria)->nombre."</b>";
            break;
        case 49:
            $mensaje="Has desactivado la categoria <b>".Categoria::model()->findByPk($id_categoria)->nombre."</b>";
            break;
        case 50:
            $mensaje="Has activado la categoria <b>".Categoria::model()->findByPk($id_categoria)->nombre."</b>";
            break;
        case 51:
            $mensaje="Has cambiado tu nombre a <b>".Profile::model()->retornarNombreCompleto($id_user)."</b>";
            break;
        case 52:
            $mensaje="Has modificado tu cargo a <b>".EmpresasHasUsers::model()->findByAttributes(array('users_id'=>$id_user))->rol."</b>";
            break;
        case 53:
            $mensaje="Has modificado tu número de teléfono a <b>".Profile::model()->findByPk($id_user)->telefono."</b>";
            break;
        case 54:
            $mensaje="<b>Has cambiado tu contraseña</b>";
            break;
        case 55:
            $mensaje="<b>Has cambiado tu foto de perfil</b>";
            break;
        case 56:
            $mensaje="Has desactivado la variación <b>".Producto::model()->findByPk($id_producto)->nombre."</b>";
            break;
        case 57:
            $mensaje="Has activado la variación <b>".Producto::model()->findByPk($id_producto)->nombre."</b>";
            break;
        case 58:
            $mensaje="Has destacado la variación <b>".Producto::model()->findByPk($id_producto)->nombre."</b>";
            break;
        case 59:
            $mensaje="Le has quitado el destacado a la variación <b>".Producto::model()->findByPk($id_producto)->nombre."</b>";
            break;
        case 60:
            $mensaje="Has modificado las imágenes de la variación <b>".Producto::model()->findByPk($id_producto)->nombre."</b>";
            break;
        case 61:
            $mensaje="Has modificado el SEO de la variación <b>".Producto::model()->findByPk($id_producto)->nombre."</b>";
            break;
        case 62:
            $mensaje="Has modificado las características de la variación <b>".Producto::model()->findByPk($id_producto)->nombre."</b>";
            break;
        case 63:
            $mensaje="Has modificado los detalles de la variación <b>".Producto::model()->findByPk($id_producto)->nombre."</b>";
            break;
        case 64:
            $mensaje="Has modificado las categorías relacionadas a la categoría <b>".Categoria::model()->findByPk($id_categoria)->nombre."</b>";
            break;
        case 65:
            $mensaje="Has modificado los atributos de la categoría <b>".Categoria::model()->findByPk($id_categoria)->nombre."</b>";
            break;
        case 66:
            $mensaje="Has modificado el SEO de la categoría <b>".Categoria::model()->findByPk($id_categoria)->nombre."</b>";
            break;
        }
        return $mensaje;   
    }
}