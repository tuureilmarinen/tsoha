<?php

// autoload_classmap.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'BaseController' => $baseDir . '/lib/base_controller.php',
    'BaseModel' => $baseDir . '/lib/base_model.php',
    'DB' => $baseDir . '/lib/database.php',
    'DatabaseConfig' => $baseDir . '/config/database.php',
    'HelloWorldController' => $baseDir . '/app/controllers/hello_world_controller.php',
    'Redirect' => $baseDir . '/lib/redirect.php',
    'View' => $baseDir . '/lib/view.php',
    'Whoops\\Module' => $vendorDir . '/filp/whoops/src/deprecated/Zend/Module.php',
    'Whoops\\Provider\\Zend\\ExceptionStrategy' => $vendorDir . '/filp/whoops/src/deprecated/Zend/ExceptionStrategy.php',
    'Whoops\\Provider\\Zend\\RouteNotFoundStrategy' => $vendorDir . '/filp/whoops/src/deprecated/Zend/RouteNotFoundStrategy.php',
);
