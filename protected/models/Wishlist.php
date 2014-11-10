<?php

/**
 * This is the model class for table "tbl_wishlist".
 *
 * The followings are the available columns in table 'tbl_wishlist':
 * @property integer $id
 * @property string $nombre
 * @property integer $users_id
 * @property integer $fecha
 * 
 * The followings are the available model relations:
 * @property Users $users
 * @property WishlistHasTblInventario[] $wishlistHasTblInventarios
 */
class Wishlist extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Wishlist the static model class
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
		return 'tbl_wishlist';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, users_id', 'required'),
			array('users_id', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, users_id, fecha', 'safe', 'on'=>'search'),
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
			'users' => array(self::BELONGS_TO, 'Users', 'users_id'),
			'wishlistHasTblInventarios' => array(self::HAS_MANY, 'WishlistHasTblInventario', 'wishlist_id'),
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
			'users_id' => 'Users',
			'fecha' => 'Fecha',
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
		$criteria->compare('users_id',$this->users_id);
		$criteria->compare('fecha',$this->fecha);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function CuatroProductos($id)
	{
		$wishlist = Wishlist::model()->findAllByAttributes(array('users_id'=>$id));
		
		if(count($wishlist)>0){
			
		$sql = 'select c.* from tbl_wishlist a, tbl_wishlist_has_tbl_producto b, tbl_producto c where a.id = b.wishlist_id and a.users_id ='.$id.' and c.id = b.producto_id ORDER BY RAND()';
		
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
		
}