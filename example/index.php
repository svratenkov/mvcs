<?php
/**
 * This is an MVCS example
 * Defines and plays a typical `Model-ViewModel-View` scenario
 * 
 * !!! You should run composer to setup MVCS classes autoloader !!!
 */
use Vsd\Micro\Error\Error;
use Vsd\Mvcs\Controller;

// Composer's autoloader for MVCS module
require '../vendor/autoload.php';

// Create MVCS controller
$mvcs = new Controller();

// Define request action (normally should be received from the application router)
$requestAction = 'user/hello';

// Map MVCS scenarios to request actions
$mvcs->set('scenarios', [
	'user/hello' => 'UserModel > UserViewModel > view, hello',
]);

// Define UserModel getter
$mvcs->set('UserModel', function($id) {
	$users = [
		1 => ['first' => 'John', 'last' => 'Smith'],
		2 => ['first' => 'Ivan', 'last' => 'Petrov'],
	];
	return isset($users[$id]) ? $users[$id] : NULL;
});

// Define UserViewModel filter: prepare UserModel data for template
$mvcs->set('UserViewModel', function($user) {
	return ['name' => $user['first'].' '.$user['last']];
});

// Get MVCS scenario for current request action
$scenarios = $mvcs->get('scenarios');
$scenario = $scenarios[$requestAction];

//--------------------------------------------
// Play scenario with some request params...

// For request 'user/hello/1' will return 'John Smith' rendered with 'hello' template
$requestParams = ['1'];
$response = $mvcs->play($scenario, $requestParams);
echo 'Request:  '.$requestAction.'/'.implode('/', $requestParams)."<br/>";
echo $response."<br/>";

// For request 'user/hello/2' will return 'Ivan Petrov' rendered with 'hello' template
$requestParams = ['2'];
$response = $mvcs->play($scenario, $requestParams);
echo 'Request:  '.$requestAction.'/'.implode('/', $requestParams)."<br/>";
echo $response."<br/>";
