<?php
/*
	MVCS config - renderers & view models definitions
*/
use App\ViewModels\HomeViewModel;
use App\ViewModels\CompileViewModel;
use	App\ViewModels\LayoutViewModel;
use App\ViewModels\ProjectViewModel;
use App\ViewModels\ShellViewModel;
use Vsd\Mvcs\Renderers\PhpTemplateRenderer;

return [
	// MVCS renderers
	'defaultRenderer'	=> 'renderers.php',
	'renderers.php'		=> new PhpTemplateRenderer(['dir' => 'templates']),

	// MVCS model domains
	'home'		=> HomeViewModel::class,
	'layout'	=> LayoutViewModel::class,
	'compile'	=> CompileViewModel::class,
	'project'	=> ProjectViewModel::class,
	'shell'		=> ShellViewModel::class,

	// App defined MVCS actions

	// Exit immediatelly from app with given resonse
	'exit'	=> function($response = NULL) { exit($response); },
	// Ajax exit with json
	'json'	=> function($response = NULL) { exit(json_encode($response)); },
];
