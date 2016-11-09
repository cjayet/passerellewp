<?php
// config
set_time_limit(90);
$pathBinary = 'D:\phantomjs\phantomjs.exe';
$pathScript = 'js/phantom-automation.js';
$login = 'admin';
$password = 'test';
$urlBackoffice = 'http://localhost/wordpress/wp-admin';

// call install script
$response = exec($pathBinary .' '.  $pathScript .' '. $login .' '. $password .' '. $urlBackoffice);
print_r($response);
echo "-- FIN SCRIPT --<br />";