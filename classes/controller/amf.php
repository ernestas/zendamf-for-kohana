<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Amf extends Controller {
 
	// Server instance
	public $server;
	
	// Load the config options
	private $config;

	//TODO: Fix the constructor to don't crash in inside requests

	public function before()
	{
		parent::before();
        
		// Load config file
		$this->config = Kohana::config('zendamf-for-kohana');
		
		// Load Zend Amf Server class
		$this->_vendorClassLoader();

		// Instance Zend Amf Server object
		$this->server = new Zend_Amf_Server();
		$this->server->setProduction($this->config->production);
		
		if($this->config->amfbrowser)
			$this->_enableZamfBrowser();
	}
    
	public function action_index()
	{
		// Can override to add custom setClass(), this is for tests porpouses
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
	
	/**
	 * Load the Zend AMF from Vendor keep the existing one loaded
	 */
	private function _vendorClassLoader() {
		if( ! class_exists("Zend_Amf_Server") )
		{
			ini_set('include_path',PATH_SEPARATOR.MODPATH.'zendamf-for-kohana/vendor/');
			require 'Zend/Amf/Server.php';
		}
	}
	
	/**
	 * Enable the ZamfBrowser when called
	 */
	private function _enableZamfBrowser()
	{
		$this->server->setClass( "ZendAmfServiceBrowser" );
        // Set a reference to the Zend_Amf_Server object so ZendAmfServiceBrowser class can retrive method information.
		ZendAmfServiceBrowser::$ZEND_AMF_SERVER = $this->server;
	}
	
}
