<?php

/**
 * This is the model class for table "{{orden_estado}}".
 *
 * The followings are the available columns in table '{{orden_estado}}':
 * @property integer $id
 * @property integer $estado
 * @property integer $empresa_id
 * @property integer $user_id
 * @property string $fecha
 * @property integer $orden_id
 * @property integer $observacion
 *
 * The followings are the available model relations:
 * @property Orden $orden
 */
class OrdenEstado extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{orden_estado}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('orden_id', 'required'),
            array('estado, empresa_id, user_id, orden_id, observacion', 'numerical', 'integerOnly'=>true),
            array('fecha', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, estado, empresa_id, user_id, fecha, orden_id, observacion', 'safe', 'on'=>'search'),
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
            'orden' => array(self::BELONGS_TO, 'Orden', 'orden_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'estado' => 'Estado',
            'empresa_id' => 'Empresa',
            'user_id' => 'User',
            'fecha' => 'Fecha',
            'orden_id' => 'Orden',
            'observacion' => 'Observacion',
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
        $criteria->compare('estado',$this->estado);
        $criteria->compare('empresa_id',$this->empresa_id);
        $criteria->compare('user_id',$this->user_id);
        $criteria->compare('fecha',$this->fecha,true);
        $criteria->compare('orden_id',$this->orden_id);
        $criteria->compare('observacion',$this->observacion);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return OrdenEstado the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}