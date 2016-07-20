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
            $enlace=Yii::app()->createUrl('tienda/index?producto='.Producto::model()->findByPk($id_producto)->nombre);
            $mensaje="Has añadido el producto <a href=".$enlace."><b>".Producto::model()->findByPk($id_producto)->nombre."</b></a> a tu carrito ";
            break;
        case 2:
            $enlace=Yii::app()->createUrl('tienda/index?producto='.Producto::model()->findByPk($id_producto)->nombre);
            $mensaje="Has eliminado el producto <a href=".$enlace."><b>".Producto::model()->findByPk($id_producto)->nombre."</b></a> de tu carrito ";
            break;
        case 3:
            $enlace=Yii::app()->createUrl('tienda/index?producto='.Producto::model()->findByPk($id_producto)->nombre);
            $mensaje="Has modificado el producto <a href=".$enlace."><b>".Producto::model()->findByPk($id_producto)->nombre."</b></a> de tu carrito ";
            break;
        case 4:
            $enlace=Yii::app()->createUrl('orden/detalle', array('id'=>$id_orden));
            $mensaje="Has generado la intención de compra <a href=".$enlace."><b>#".$id_orden."</b></a>";
            break;
        case 5:
            $enlace=Yii::app()->createUrl('orden/detalle', array('id'=>$id_orden));
            $mensaje="Te han aprobado la intención de compra <a href=".$enlace."><b>#".$id_orden."</b></a>";
            break;
        case 6:
            $enlace=Yii::app()->createUrl('orden/detalle', array('id'=>$id_orden));
            $mensaje="Te han rechazado la intención de compra <a href=".$enlace."><b>#".$id_orden."</b></a>";
            break;
        case 8:
            $enlace=Yii::app()->createUrl('orden/detalleVendedor', array('id'=>$id_orden));
            $mensaje="Has aprobado la intención de compra <a href=".$enlace."><b>#".$id_orden."</b></a>";
            break;
        case 9:
            $enlace=Yii::app()->createUrl('orden/detalleVendedor', array('id'=>$id_orden));
            $mensaje="Has rechazado la intención de compra <a href=".$enlace."><b>#".$id_orden."</b></a>";
            break;
        case 10:
            $mensaje="Has solicitado la creación del producto <b>".Producto::model()->findByPk($id_producto)->nombre."</b>";
            break;
        case 11:
            $enlace=Yii::app()->createUrl('producto/detalle?producto='.$id_producto.'&almacen_id='.$id_almacen);
            $mensaje="Le has cargado inventario al producto <a href=".$enlace."><b>".Producto::model()->findByPk($id_producto)->nombre."</a></b> en el almacen <b>".Almacen::model()->findByPk($id_almacen)->alias."</b>";
            break;
        case 12:
            $mensaje="Has subido el inbound #<b>".$id_inbound."</b>";
            break;
        case 13:
            $mensaje="Has subido el masterdata  #<b>".$id_masterData."</b>";
            break;
        case 14:
            $enlace=Yii::app()->createUrl('almacen/update', array('id'=>$id_almacen));
            $mensaje="Has creado el almacen <a href=".$enlace."><b>".Almacen::model()->findByPk($id_almacen)->alias."</b> </a>";
            break;
        case 15:
            $enlace=Yii::app()->createUrl('almacen/update', array('id'=>$id_almacen));
            $mensaje="Has modificado el almacen <a href=".$enlace."><b>".Almacen::model()->findByPk($id_almacen)->alias."</b> </a>";
            break;
        case 16:
            $enlace=Yii::app()->createUrl('empresas/verEmpresa', array('id'=>$id_empresa));
            $mensaje="Has modificado la informacion de la empresa <a href=".$enlace."><b>".Empresas::model()->findByPk($id_empresa)->razon_social."</b></a>";
            break;
        case 18:
            $enlace=Yii::app()->createUrl('user/profile/index/ide/'.$id_user);
            $mensaje="Has modificado la informacion del usuario <a href=".$enlace."><b>".Profile::model()->retornarNombreCompleto($id_user)."</b></a>";
            break;
        case 21:
            $enlace=Yii::app()->createUrl('almacen/update', array('id'=>$id_almacen));
            $mensaje="Has modificado el almacen <a href=".$enlace."><b>".Almacen::model()->findByPk($id_almacen)->alias."</b> de la Empresa <b>".Almacen::model()->findByPk($id_almacen)->empresas->razon_social."</b></a>";
            break;
        case 22:
            $enlace=Yii::app()->createUrl('productoPadre/update', array('id'=>$id_producto_padre));
            $mensaje="Has creado un nuevo producto padre con el nombre <a href=".$enlace."><b>".ProductoPadre::model()->findByPk($id_producto_padre)->nombre."</b></a>";
            break;
        case 23:
            $enlace=Yii::app()->createUrl('producto/modificarProducto', array('id'=>$id_producto));
            $mensaje="Has creado una nueva variación con el nombre <a href=".$enlance."><b>".Producto::model()->findByPk($id_producto)->nombre."</b></a>";
            break;
        case 24:
            $enlace=Yii::app()->createUrl('producto/modificarProducto', array('id'=>$id_producto));
            $mensaje="Has modificado la información vital de la variación <a href=".$enlance."><b>".Producto::model()->findByPk($id_producto)->nombre."</b></a>";
            break;
        case 25:
            $enlace=Yii::app()->createUrl('producto/modificarProducto', array('id'=>$id_producto));
            $mensaje="Has aprobado la creación de la variación <a href=".$enlace."><b>".Producto::model()->findByPk($id_producto)->nombre."</b></a>";
            break;
        case 26:
            $enlace=Yii::app()->createUrl('producto/modificarProducto', array('id'=>$id_producto));
            $mensaje="Has rechazado la creacion de la variación <a href=".$enlace."><b>".Producto::model()->findByPk($id_producto)->nombre."</b></a>";
            break;
        case 27:
            $enlace=Yii::app()->createUrl('productoPadre/update', array('id'=>$id_producto_padre));
            $mensaje="Has modificado el producto padre <a href=".$enlace."><b>".ProductoPadre::model()->findByPk($id_producto_padre)->nombre."</b></a>";
            break;
        case 28:
            $enlace=Yii::app()->createUrl('marca/create', array('id'=>$id_marca));
            $mensaje="Has creado la marca <a href=".$enlace."><b>".Marca::model()->findByPk($id_marca)->nombre."</b></a>";
            break;
        case 29:
            $enlace=Yii::app()->createUrl('marca/create', array('id'=>$id_marca));
            $mensaje="Has modificado la marca <a href=".$enlace."><b>".Marca::model()->findByPk($id_marca)->nombre."</b></a>";
            break;
        case 30:
            $enlace=Yii::app()->createUrl('marca/create', array('id'=>$id_marca));
            $mensaje="Has desactivado la marca <a href=".$enlace."><b>".Marca::model()->findByPk($id_marca)->nombre."</b></a>";
            break;
        case 31:
            $enlace=Yii::app()->createUrl('marca/create', array('id'=>$id_marca));
            $mensaje="Has activado la marca <a href=".$enlace."><b>".Marca::model()->findByPk($id_marca)->nombre."</b></a>";
            break;
        case 32:
            $enlace=Yii::app()->createUrl('color/update', array('id'=>$id_color));
            $mensaje="Has creado el color <a href=".$enlace."><b>".Color::model()->findByPk($id_color)->nombre."</b></a>";
            break;
        case 33:
            $enlace=Yii::app()->createUrl('color/update', array('id'=>$id_color));
            $mensaje="Has modificado el color <a href=".$enlace."><b>".Color::model()->findByPk($id_color)->nombre."</b></a>";
            break; 
        case 34:
            $enlace=Yii::app()->createUrl('color/update', array('id'=>$id_color));
            $mensaje="Has desactivado el color <a href=".$enlace."><b>".Color::model()->findByPk($id_color)->nombre."</b></a>";
            break;
        case 35:
            $enlace=Yii::app()->createUrl('color/update', array('id'=>$id_color));
            $mensaje="Has activado el color <a href=".$enlace."><b>".Color::model()->findByPk($id_color)->nombre."</b></a>";
            break;
        case 36:
            $enlace=Yii::app()->createUrl('unidad/update', array('id'=>$id_unidad));
            $mensaje="Has creado la unidad <a href=".$enlace."><b>".Unidad::model()->findByPk($id_unidad)->nombre."</b></a>";
            break;
        case 37:
            $enlace=Yii::app()->createUrl('unidad/update', array('id'=>$id_unidad));
            $mensaje="Has modificado la unidad <a href=".$enlace."><b>".Unidad::model()->findByPk($id_unidad)->nombre."</b></a>";
            break;
        case 38:
            $enlace=Yii::app()->createUrl('unidad/update', array('id'=>$id_unidad));
            $mensaje="Has desactivado la unidad <a href=".$enlace."><b>".Unidad::model()->findByPk($id_unidad)->nombre."</b></a>";
            break;
        case 39:
            $enlace=Yii::app()->createUrl('unidad/update', array('id'=>$id_unidad));
            $mensaje="Has activado la unidad <a href=".$enlace."><b>".Unidad::model()->findByPk($id_unidad)->nombre."</b></a>";
            break;
        case 40:
            $enlace=Yii::app()->createUrl('atributo/update', array('id'=>$id_atributo));
            $mensaje="Has creado el atributo <b>".Atributo::model()->findByPk($id_atributo)->nombre."</b>";
            break;
        case 41:
            $enlace=Yii::app()->createUrl('atributo/update', array('id'=>$id_atributo));
            $mensaje="Has modificado el atributo <b>".Atributo::model()->findByPk($id_atributo)->nombre."</b>";
            break;
        case 42:
            $enlace=Yii::app()->createUrl('atributo/update', array('id'=>$id_atributo));
            $mensaje="Has desactivado el atributo <b>".Atributo::model()->findByPk($id_atributo)->nombre."</b>";
            break;
        case 43:
            $enlace=Yii::app()->createUrl('atributo/update', array('id'=>$id_atributo));
            $mensaje="Has activado el atributo <b>".Atributo::model()->findByPk($id_atributo)->nombre."</b>";
            break;
        case 44:
            $enlace=Yii::app()->createUrl('categoria/storefrontConf', array('id'=>$id_categoria));
            $mensaje="Has cambiado una imagen del storefront de la categoria <a href=".$enlace."><b>".Categoria::model()->findByPk($id_categoria)->nombre."</b></a>";
            break;
        case 45:
            $enlace=Yii::app()->createUrl('categoria/create', array('id'=>$id_categoria));
            $mensaje="Has creado la categoria <a href=".$enlace."><b>".Categoria::model()->findByPk($id_categoria)->nombre."</b></a>";
            break;
        case 46:
            $enlace=Yii::app()->createUrl('categoria/create', array('id'=>$id_categoria));
            $mensaje="Has modificado la información general de la categoria <a href=".$enlace."><b>".Categoria::model()->findByPk($id_categoria)->nombre."</b></a>";
            break;
        case 47:
            $enlace=Yii::app()->createUrl('categoria/create', array('id'=>$id_categoria));
            $mensaje="Has destacado la categoria <a href=".$enlace."><b>".Categoria::model()->findByPk($id_categoria)->nombre."</b></a>";
            break;
        case 48:
            $enlace=Yii::app()->createUrl('categoria/create', array('id'=>$id_categoria));
            $mensaje="Le has quitado el destacado a la categoria <a href=".$enlace."><b>".Categoria::model()->findByPk($id_categoria)->nombre."</b></a>";
            break;
        case 49:
            $enlace=Yii::app()->createUrl('categoria/create', array('id'=>$id_categoria));
            $mensaje="Has desactivado la categoria <a href=".$enlace."><b>".Categoria::model()->findByPk($id_categoria)->nombre."</b></a>";
            break;
        case 50:
            $enlace=Yii::app()->createUrl('categoria/create', array('id'=>$id_categoria));
            $mensaje="Has activado la categoria <a href=".$enlace."><b>".Categoria::model()->findByPk($id_categoria)->nombre."</b></a>";
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
            $enlace=Yii::app()->createUrl('producto/modificarProducto', array('id'=>$id_producto));
            $mensaje="Has desactivado la variación <a href=".$enlace."><b>".Producto::model()->findByPk($id_producto)->nombre."</b></a>";
            break;
        case 57:
            $enlace=Yii::app()->createUrl('producto/modificarProducto', array('id'=>$id_producto));
            $mensaje="Has activado la variación <a href=".$enlace."><b>".Producto::model()->findByPk($id_producto)->nombre."</b></a>";
            break;
        case 58:
            $enlace=Yii::app()->createUrl('producto/modificarProducto', array('id'=>$id_producto));
            $mensaje="Has destacado la variación <a href=".$enlace."><b>".Producto::model()->findByPk($id_producto)->nombre."</b></a>";
            break;
        case 59:
            $enlace=Yii::app()->createUrl('producto/modificarProducto', array('id'=>$id_producto));
            $mensaje="Le has quitado el destacado a la variación <a href=".$enlace."><b>".Producto::model()->findByPk($id_producto)->nombre."</b></a>";
            break;
        case 60:
            $enlace=Yii::app()->createUrl('producto/imagenes', array('id'=>$id_producto));
            $mensaje="Has modificado las imágenes de la variación <a href=".$enlace."><b>".Producto::model()->findByPk($id_producto)->nombre."</b></a>";
            break;
        case 61:
            $enlace=Yii::app()->createUrl('producto/seo', array('id'=>$id_producto));
            $mensaje="Has modificado el SEO de la variación <a href=".$enlace."><b>".Producto::model()->findByPk($id_producto)->nombre."</b></a>";
            break;
        case 62:
            $enlace=Yii::app()->createUrl('producto/características', array('id'=>$id_producto));
            $mensaje="Has modificado las características de la variación <a href=".$enlace."><b>".Producto::model()->findByPk($id_producto)->nombre."</b></a>";
            break;
        case 63:
            $enlace=Yii::app()->createUrl('producto/details', array('id'=>$id_producto));
            $mensaje="Has modificado los detalles de la variación <a href=".$enlace."><b>".Producto::model()->findByPk($id_producto)->nombre."</b></a>";
            break;
        case 64:
            $enlace=Yii::app()->createUrl('categoria/categoriaRelacionada', array('id'=>$id_categoria));
            $mensaje="Has modificado las categorías relacionadas a la categoría <b>".Categoria::model()->findByPk($id_categoria)->nombre."</b>";
            break;
        case 65:
            $enlace=Yii::app()->createUrl('categoria/categoriaAtributo', array('id'=>$id_categoria));
            $mensaje="Has modificado los atributos de la categoría <b>".Categoria::model()->findByPk($id_categoria)->nombre."</b>";
            break;
        case 66:
            $enlace=Yii::app()->createUrl('categoria/categoriaSeo', array('id'=>$id_categoria));
            $mensaje="Has modificado el SEO de la categoría <b>".Categoria::model()->findByPk($id_categoria)->nombre."</b>";
            break;
        }
        return $mensaje;   
    }
}