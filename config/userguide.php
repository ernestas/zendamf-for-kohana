<?php defined('SYSPATH') or die('No direct script access.');

return array(
	// Leave this alone
	'modules' => array(

		// This should be the path to this modules userguide pages, without the 'guide/'. Ex: '/guide/modulename/' would be 'modulename'
		'zendamf-for-kohana' => array(

			// Whether this modules userguide pages should be shown
			'enabled' => TRUE,
			
			// The name that should show up on the userguide index page
			'name' => 'ZendAMF for Kohana',

			// A short description of this module, shown on the index page
			'description' => 'Non-official AMF module, a gateway for using AMF0 or AMF3 protocol to change menssages betwen Kohana and Flash/Flex.',
			
			// Copyright message, shown in the footer for this module
			'copyright' => 'No copyrights, this is totaly free.',
		)	
	)
);
