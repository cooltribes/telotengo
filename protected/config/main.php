<?php

// uncomment the following to define a path alias
 Yii::setPathOfAlias('bootstrap', dirname(dirname(__FILE__)).'/extensions/bootstrap');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');

return array(
	'theme'=>'bootstrap',
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Telotengo',
	
	'language' => 'es', // the language that the user is using and the application should be targeted to
	
	// preloading 'log' component
	'preload'=>array('log','bootstrap'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.modules.user.models.*',
        'application.modules.user.components.*',

        'application.helpers.*',
        'ext.mail.YiiMailMessage',
        'ext.yii-mail.YiiMailMessage',
        'ext.YiiMongoDbSuite.*',

	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
		 'generatorPaths'=>array(
                'bootstrap.gii',
            ),
			'class'=>'system.gii.GiiModule',
			'password'=>'Enter Your Password Here',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			//'ipFilters'=>array('127.0.0.1','::1'),
			'ipFilters'=>array('*'),
		),


		'user'=>array(
                # encrypting method (php hash function)
                'hash' => 'md5',

                # send activation email
                'sendActivationMail' => true,

                # allow access for non-activated users
                'loginNotActiv' => true,

                # activate user on registration (only sendActivationMail = false)
                'activeAfterRegister' => false,

                # automatically login from registration
                'autoLogin' => true,

                # registration path
                'registrationUrl' => array('/user/registration'),

                # recovery password path
                'recoveryUrl' => array('/user/recovery'),

                # login form path
                'loginUrl' => array('/user/login'),

                # page after login
                'returnUrl' => array('/user/profile'),

                # page after logout
                'returnLogoutUrl' => array('/user/login'),
            ),

		
	),

	// application components
	'components'=>array(
	        'bootstrap'=>array(
	      	//'class' => 'ext.yiibooster.components.Bootstrap',
            'class'=>'bootstrap.components.Bootstrap',
        ),
        /*
        'less'=>array(
      		'class'=>'ext.less.components.LessClientCompiler',
      		'files'=>array(
        	'less/styles.less'=>'css/styles.css',
      ),*/
     
       'less'=>array(
	      'class'=>'ext.less.components.Less',
	      'mode'=>'client',
	      'files'=>array(
	        'less/styles.less'=>'css/styles.less',
	      ),
    ),
		'user'=>array(
			// enable cookie-based authentication

                'class' => 'WebUser',
                'allowAutoLogin'=>true,
                'loginUrl' => array('/user/login'),

		),
		// uncomment the following to enable URLs in path-format
		
		'image'=>array(
          'class'=>'application.extensions.image.CImageComponent',
            // GD or ImageMagick
            'driver'=>'GD',
            // ImageMagick setup path
            'params'=>array('directory'=>'/opt/local/bin'),
        ),
        		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			//'baseUrl' => '/telotengo',
			'rules'=>array(
				'marcas/<alias:[a-zA-Z0-9_-]+>'=>'marca/store', 
				'tiendas/<alias:[a-zA-Z0-9_-]+>'=>'tienda/storefront',
				'categorias/<alias:[a-zA-Z0-9_-]+>'=>'categoria/store',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				
			),
		),
		
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		 * */
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=telotengo.com;dbname=db_telotengo',
			'emulatePrepare' => true,
			'username' => 'telotengo',
			'password' => 'SFGth$$%67',
			'charset' => 'utf8',
			'tablePrefix' => 'tbl_',
		),
		/*
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=db_telotengo',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '1234',
			'charset' => 'utf8',
			'tablePrefix' => 'tbl_',
		),*/

		'mongodb' => array(
	        'class'            => 'EMongoDB',
	        //'connectionString' => 'mongodb://maranjo:QPWOALSKvmr00@72.167.13.125:27017',
	        'connectionString' => 'mongodb://localhost',
	        'dbName'           => 'telotengo',
	        'fsyncFlag'        => false,
	        'safeFlag'         => false,
	        'useCursor'        => false
     	),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning, trace',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
				array(
                   'class' => 'CDbLogRoute',
                   'connectionID' => 'db',
                   'autoCreateLogTable' => false,
                   'logTableName' => 'tbl_logger',
                   'levels' => 'trace',
                   'categories' => 'registro',

				),
			),
		),
        
		'mail' => array(
       		'class' => 'application.extensions.yii-mail.YiiMail',
            'transportType'=>'php',
            'viewPath' => 'application.views.mail',             
        ),
	
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
		'contacto'=>'contacto@telotengo.com',
		//'contacto'=>'dduque@upsidecorp.ch',
		'uploadPath'=>dirname(__FILE__).'/../../documentos/',
        'uploadUrl'=>'/documentos',
	),
);