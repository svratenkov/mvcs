<?php
// Application routes
return [
	'/'					=> ['home:home', 'render,home'],
	'help'				=> 'home:home > render,help',
	'compile'			=> 'compile:compile > render,compile',
	'watch'				=> 'compile:watch > render,watch',
	'ajax'				=> 'compile:ajax > exit',
	'(stop|clear)'		=> 'compile:(:1) > redirect,compile',
//	'project/(:any)'	=> function($name) { return $this->view('project', ['project', 'project'])->setModelArgs($name); },
	'project/(:any)'	=> 'project:info > render,project',
	'cache'				=> 'project:cache > redirect',
	'shell'				=> 'shell:shell > render,shell',
	'shell/clear'		=> 'shell:clear > redirect',
	'shell/(cmd|copy)/(:any)/(:any)'	=> 'shell:(:1) > redirect',
	'shell/visi/(:any)/(:any)'	=> 'shell:visi > exit',	// AJAX request
	'^shell/(swd|exec)'	=> 'shell:(:1) > redirect',

	// Special rule for any route
//	'*'	=> 'home:error404',
//	'*'					=> function() { return new View('error404', ['url' => Request::url()]); },
	'*'					=> function() { return $this->view('error404'); },
];
