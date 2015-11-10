<?php

/**
 * This is the model class for table "{{confImage}}".
 *
 * The followings are the available columns in table '{{confImage}}':
 * @property integer $id
 * @property string $name
 * @property integer $index
 * @property integer $group
 * @property string $title
 * @property string $alt
 * @property string $copy
 * @property string $link
 * @property string $path
 * @property integer $type
 * @property integer $width
 * @property integer $height
 * @property integer $categoria_id
 */
class ConfImage extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{confImage}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('index, group, type, width, height, categoria_id', 'numerical', 'integerOnly'=>true),
			array('name, title, alt', 'length', 'max'=>50),
			array('copy, link', 'length', 'max'=>200),
			array('path', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, index, group, title, alt, copy, link, path, type, width, height, categoria_id', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'index' => 'Index',
			'group' => 'Group',
			'title' => 'Title',
			'alt' => 'Alt',
			'copy' => 'Copy',
			'link' => 'Link',
			'path' => 'Path',
			'type' => 'Type',
			'width' => 'Width',
			'height' => 'Height',
			'categoria_id' => 'Categoria',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('index',$this->index);
		$criteria->compare('group',$this->group);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('alt',$this->alt,true);
		$criteria->compare('copy',$this->copy,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('path',$this->path,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('width',$this->width);
		$criteria->compare('height',$this->height);
		$criteria->compare('categoria_id',$this->categoria_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ConfImage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public function getTypes(){
        $array=array(1=>'Desktop',2=>'Mobile',3=>'Ambas');
        return $array;
    }
    public function getImage($name,$index=1, $categoria_id = null, $width='100%',$height=''){
            if(!is_null($categoria_id))
            {    
                $img=$this->findByAttributes(array('name'=>$name,'index'=>$index, 'categoria_id'=>$categoria_id));
                if($img){              
                    
                    return CHtml::image($img->path, $img->alt,array('width'=>$width,'height'=>$height));
                }
                
            } 
            $url=$index==1?"http://placehold.it/1200x450":"http://placehold.it/380x270"; 
            return  CHtml::image($url, "Default",array('title'=>"",'width'=>$width,'height'=>$height));

            
        }  
     
    public function getLinkedImage($name,$index=1,$categoria_id = null, $width='100%',$height='',$class=''){
            if(!is_null($categoria_id))
            {
                $img=$this->findByAttributes(array('name'=>$name,'index'=>$index, 'categoria_id'=>$categoria_id));
                if($img){              
                    
                    return "<a  target='_blank' href='".$img->link."' title='".$img->title."' class='".$class."'>".CHtml::image($img->path, $img->alt,array('title'=>$img->title,'width'=>$width,'height'=>$height))."</a>";
                }
                else 
              
                       return "<a  target='_blank' href='' title='Default' class='".$class."'>".CHtml::image(Yii::app()->theme->baseUrl.'/images/home/default/'.$name.$index.'.jpg', "Default",array('width'=>$width,'height'=>$height))."</a>";
                          
                }
                 $url=$index==1?"http://placehold.it/1200x450":"http://placehold.it/380x270"; 
                 return "<a  target='_blank' href='' title='Default' class='".$class."'>".CHtml::image($url, "Default",array('width'=>$width,'height'=>$height))."</a>";
               
            }
}
