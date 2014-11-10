<?php
class Caracteristica extends EMongoDocument{
  public $producto_id;
  public $caracteristica_id;
  public $valor;
  public $inventario_id;

  // This has to be defined in every model, this is same as with standard Yii ActiveRecord
  public static function model($className=__CLASS__){
    return parent::model($className);
  }

  // This method is required!
  public function getCollectionName(){
    return 'caracteristicas';
  }

  public function rules(){
    return array(
      array('producto_id, caracteristica_id, valor, inventario_id', 'required'),
      array('valor', 'length', 'max' => 255),
    );
  }

  public function attributeLabels(){
    return array(
      'producto_id'  => 'Producto',
      'caracteristica_id'   => 'ID Característica',
      'valor'   => 'Valor',
      'inventario_id' => 'ID Inventario',
    );
  }
}