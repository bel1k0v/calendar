<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
$mainConfig = array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Calendar',
    'defaultController' => 'meeting',

	// preloading 'log' component
	//'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
            'showScriptName' => false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=test',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
            'tablePrefix' => 'scheduler_',
        ),
		'errorHandler'=>array(
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),

	'params'=>array(
		'adminEmail'=>'dmitrijbelikov@gmail.com',
	),
);

/**
 * Dev config example
<?php
return CMap::mergeArray($mainConfig, array(
    'modules' => array(
        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'123',
        ),
    ),
    'components'=>array(
        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=yourdatabasename',
            'emulatePrepare' => true,
            'username' => 'yourdatabaseuser',
            'password' => 'yoursecretpassword',
            'charset' => 'utf8',
            'tablePrefix' => 'scheduler_',
        ),
        'log'=>array(
        'class'=>'CLogRouter',
            'routes'=>array(
                // Import an extension to profile queries, unfortunately doesn't work with ajax
                //array(
                //    'class'=>'ext.dbProfiler.DbProfileLogRoute',
                //    'countLimit' => 1, // How many times the same query should be executed to be considered inefficient
                //    'slowQueryMin' => 0.01, // Minimum time for the query to be slow
                //),
            ),
        ),
    ),
));
?>
 */

$devConfig = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'main.dev.php';
if (file_exists($devConfig))
    $mainConfig = require_once $devConfig;

return $mainConfig;