<?php

/**
 * This is the model class for table "{{empleo}}".
 *
 * The followings are the available columns in table '{{empleo}}':
 * @property integer $id
 * @property string $nombre
 * @property string $email
 * @property string $fecha_nacimiento
 * @property string $direccion
 * @property integer $sexo
 * @property string $cv
 * @property string $lugar_nacimiento
 */
class Empleo extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{empleo}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nombre, email, fecha_nacimiento, direccion, sexo, cv, lugar_nacimiento', 'required'),
            array('sexo', 'numerical', 'integerOnly'=>true),
            array('nombre, email, lugar_nacimiento', 'length', 'max'=>250),
            array('cv', 'length', 'max'=>500),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, nombre, email, fecha_nacimiento, direccion, sexo, cv, lugar_nacimiento', 'safe', 'on'=>'search'),
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
            'nombre' => 'Nombre',
            'email' => 'Email',
            'fecha_nacimiento' => 'Fecha Nacimiento',
            'direccion' => 'Direccion',
            'sexo' => 'Sexo',
            'cv' => 'Cv',
            'lugar_nacimiento' => 'Lugar Nacimiento',
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
        $criteria->compare('nombre',$this->nombre,true);
        $criteria->compare('email',$this->email,true);
        $criteria->compare('fecha_nacimiento',$this->fecha_nacimiento,true);
        $criteria->compare('direccion',$this->direccion,true);
        $criteria->compare('sexo',$this->sexo);
        $criteria->compare('cv',$this->cv,true);
        $criteria->compare('lugar_nacimiento',$this->lugar_nacimiento,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Empleo the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    public function mail_attachment($ruta_completa,$filename, $mailto, $from_mail, $from_name, $replyto, $subject, $message) {  
        #$file = $path.$filename;
        #$filename="adjunto CV";
        $file = $ruta_completa;
        $file_size = filesize($file);
        $handle = fopen($file, "r");
        $content = fread($handle, $file_size);
        fclose($handle);
        $content = chunk_split(base64_encode($content));
        $uid = md5(uniqid(time()));
        $name = basename($file);
        $header = "From: ".$from_name." <".$from_mail.">\r\n";
        $header .= "Reply-To: ".$replyto."\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
        $header .= "This is a multi-part message in MIME format.\r\n";
        $header .= "--".$uid."\r\n";
        $header .= "Content-type:text/plain; charset=iso-8859-1\r\n";
        $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $header .= $message."\r\n\r\n";
        $header .= "--".$uid."\r\n";
        $header .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"; // use different content types here
        $header .= "Content-Transfer-Encoding: base64\r\n";
        $header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
        $header .= $content."\r\n\r\n";
        $header .= "--".$uid."--";
        if (mail($mailto, $subject, "", $header)) {
           // echo "mail send ... OK"; // or use booleans here
        } else {
            //echo "mail send ... ERROR!";
        }
    }


}