<?php

class GiftcardController extends Controller
{ 
    /** 
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning 
     * using two-column layout. See 'protected/views/layouts/column2.php'. 
     */ 
    public $layout='//layouts/column2'; 

    /** 
     * @return array action filters 
     */ 
    public function filters() 
    { 
        return array( 
            'accessControl', // perform access control for CRUD operations 
        ); 
    } 

    /** 
     * Specifies the access control rules. 
     * This method is used by the 'accessControl' filter. 
     * @return array access control rules 
     */ 
    public function accessRules() 
    { 
        return array(  
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('comprar','registrar'),
                'users'=>array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions 
                'actions'=>array('admin','delete','create','update','inactivar','sinpago','poraprobar','aprobar'), 
                'users'=>array('admin'), 
            ), 
            array('deny',  // deny all users 
                'users'=>array('*'), 
            ), 
        ); 
    } 

    /** 
     * Displays a particular model. 
     * @param integer $id the ID of the model to be displayed 
     */ 
    public function actionView($id) 
    { 
        $this->render('view',array( 
            'model'=>$this->loadModel($id), 
        )); 
    } 

    /** 
     * accion para comprar GC 
     */ 
    public function actionComprar() 
    { 
        $model = new Giftcard;
        $modeldos = new BolsaGC;
        $modeldos->plantilla_url = "gift_card_one"; //Default      
        $envio = new EnvioGiftcard();

        if(isset($_POST['BolsaGC']))
        {    
            $modeldos->attributes = $_POST['BolsaGC'];
            $modeldos->user_id = Yii::app()->user->id;

            if($modeldos->validate()){                    
                $envio->attributes = $_POST['EnvioGiftcard'];                        

                Yii::app()->getSession()->remove('entrega');                        
                Yii::app()->getSession()->add('entrega',$_POST['entrega']);
                        
                //si es para enviar por correo, validar email
                if(($_POST['entrega'] == 2 && $envio->validate()) || $_POST['entrega'] == 1){
                            
                    //Guardar los datos del envio pero borrar los anteriores                        
                    Yii::app()->getSession()->remove('envio');                        
                    Yii::app()->getSession()->add('envio',$envio->attributes);

                    /*
                    por los momentos se van a borrar todas las existentes en la bolsa del usuario
                    porque se va a trabajar con una sola
                     */
                    BolsaGC::model()->deleteAllByAttributes(array("user_id" => Yii::app()->user->id));

                    if($modeldos->save()){                              
                        $this->redirect($this->createAbsoluteUrl('bolsa/authGC',array(),'http')); // era https
                    }  
                }
            }           
        }else{
            Yii::app()->getSession()->remove('entrega');  
        }

        $this->render('comprar',array( 
            'giftcard'=>$model, 
            'model' => $modeldos,
            'envio'=>$envio,
        )); 
    } 

    /** 
     * Creates a new model. 
     * If creation is successful, the browser will be redirected to the 'view' page. 
     */ 
    public function actionCreate() 
    { 
        $model=new Giftcard; 

        // Uncomment the following line if AJAX validation is needed 
        // $this->performAjaxValidation($model); 

        if(isset($_POST['Giftcard'])) { 
            $model->attributes=$_POST['Giftcard'];
            $model->beneficiario=$_POST["Giftcard"]['beneficiario'];
            $model->codigo = Giftcard::model()->generarCodigo();
            $model->estado = 1; // Enviada
            $model->comprador = Yii::app()->user->id;

            $user = User::model()->findByPk(Yii::app()->user->id);

            $message = new YiiMailMessage;
            $subject = 'Te han enviado una Gift Card desde sigmatiendas.com';                                
            $message->subject = $subject;
            $body = '<h2>¡'.$user->profile->first_name.' '.$user->profile->last_name.' te ha enviado una Gift Card!</h2>
                Monto: '.$model->monto.'.
                Código: '.$model->codigo.'.
                Puedes cobrar tu Gift Card en <a href="sigmatiendas.com">Sigma Tiendas</a>.';
            $message->from = array(Yii::app()->params['adminEmail'] => "Sigma Tiendas");
            $message->setBody($body, 'text/html');                
            $message->addTo($model->beneficiario);

            Yii::app()->mail->send($message);

            if($model->save()){
                Yii::app()->user->setFlash('success',"Gift Card enviada exitosamente."); 
                $this->redirect(array('admin')); 
            }
        } 

        $this->render('create',array( 
            'model'=>$model, 
        )); 
    } 

     /* Inactivar desde administrador */ 
    public function actionInactivar($id){
        $model = Giftcard::model()->findByPk($id);
        $model->saveAttributes(array('estado'=>3)); // Inactivo 

        Yii::app()->user->setFlash('success',"Gift Card inactivada exitosamente.");

        $this->redirect(array('admin'));
    }

    /** 
     * Deletes a particular model. 
     * If deletion is successful, the browser will be redirected to the 'admin' page. 
     * @param integer $id the ID of the model to be deleted 
     */ 
    public function actionDelete($id) 
    { 
        $this->loadModel($id)->delete();
        Yii::app()->user->setFlash('success',"Gift Card eliminada correctamente.");
        $this->redirect(array('admin')); 
    } 

    /** 
     * Manages all models. 
     */ 
    public function actionAdmin() 
    { 
        $model = new Giftcard;
        $dataProvider= $model->search();

        $this->render('admin',array( 
            'dataProvider'=>$dataProvider, 
        )); 
    } 

    /** 
     * Las Ordenes de GC que faltan por pagar o por aprobar 
     */ 
    public function actionSinPago() 
    { 
        $model = new OrdenGC;
        $model->estado = 1;
        $dataProvider= $model->search();

        $this->render('sinpago',array( 
            'dataProvider'=>$dataProvider, 
        )); 
    } 

    /** 
     * Las Ordenes de GC que faltan por pagar o por aprobar 
     */ 
    public function actionPorAprobar() 
    {
        $model = new OrdenGC;
        $model->estado = 2;
        $dataProvider= $model->search();

        $this->render('poraprobar',array( 
            'dataProvider'=>$dataProvider, 
        )); 
    }

    public function actionAprobar($id){
        $model = DetalleOrden::model()->findByPk($id);
        $model->saveAttributes(array('estado'=>1)); // aprobado

        $orden = OrdenGC::model()->findByPk($model->ordenGC_id);
        $orden->saveAttributes(array('estado'=>3)); // Pago confirmado

        $this->redirect($this->createAbsoluteUrl('bolsa/crearGC',array('userId'=>$orden->user_id, 'ordenId'=>$id,'deposito'=>TRUE),'http')); 
    }

    /** 
     * Returns the data model based on the primary key given in the GET variable. 
     * If the data model is not found, an HTTP exception will be raised. 
     * @param integer the ID of the model to be loaded 
     */ 
    public function loadModel($id) 
    { 
        $model=Giftcard::model()->findByPk($id); 
        if($model===null) 
            throw new CHttpException(404,'The requested page does not exist.'); 
        return $model; 
    } 

    /** 
     * Performs the AJAX validation. 
     * @param CModel the model to be validated 
     */ 
    protected function performAjaxValidation($model) 
    { 
        if(isset($_POST['ajax']) && $_POST['ajax']==='giftcard-form') 
        { 
            echo CActiveForm::validate($model); 
            Yii::app()->end(); 
        } 
    } 
} 