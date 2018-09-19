<?php
/*
	MVCS example
*/
use Vsd\Mvcs\Example\App;

// Error handling
require '../../micro/src/Error/Error.php';
Vsd\Micro\Error\Error::register();

// Composer's autoloader
require '../vendor/autoload.php';

// Create example app with given MVCS config
//require 'App.php';
$app = new App(require 'routes.php', require 'mvcs.php');

$response = $app->run();

// Exit with app response
exit($response);

//------------------------------------------------------------------------------
// Global helpers for templates & models
//------------------------------------------------------------------------------

/*
	Create MVCS view
*/
function view($data, $template, $renderer = NULL)
{
	global $app;

	return $app->controller->view($data, $template, $renderer);
}

/*
	Render template with data and MVCS renderer
*/
function render($data, $template, $renderer = NULL)
{
	global $app;

	return $app->controller->render($data, $template, $renderer);
}

/*
	URL ЭТОГО сайта для заданного URI - абсолютный или относительный
	Если URI не задан, берем URI запроса
*/
function url($uri = NULL, $abs = FALSE)
{
	global $app;

	return $app->request->url($uri, $abs);
}

/**
 * Redirect to given application URI
 * 
 * @param  string $uri
 * @return void
 */
function redirect($uri = NULL)
{
	global $app;

	return $app->request->redirect($uri);
}
