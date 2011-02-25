<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Load Zend Amf Server class if isn't loaded yet...
 */
if( ! class_exists("Zend_Amf_Server") )
{
	ini_set('include_path',ini_get('include_path').PATH_SEPARATOR.MODPATH.'zendamf-for-kohana/vendor/');
	require 'Zend/Amf/Server.php';
}

class Controller_Amf extends Controller {
 
	public $server;

	//TODO: Fix the constructor to don't crash in inside requests

	public function before()
	{
		parent::before();
        
		$this->server = new Zend_Amf_Server();
		$this->server->setProduction(TRUE);
	}
    
	public function action_index()
	{
	        // Can override to add custom setClass(), this is for tests porpouses

		//This is only for tests, in the real world enable the proction mode and don't give ZamfBrowser support.
		$this->server->setProduction(FALSE);

		$this->server->setClass( "ZendAmfServiceBrowser" );
	        // Set a reference to the Zend_Amf_Server object so ZendAmfServiceBrowser class can retrive method information.
        	ZendAmfServiceBrowser::$ZEND_AMF_SERVER = $this->server; 
	}
    
	public function after()
	{
		parent::after();
        
	        $handle = $this->server->handle();
        
	        // fixes bug with content-type headers
	        if (Request::is_amf())
	        	$this->response->body( $handle );
	        else
	        	echo $handle;
	}
}
