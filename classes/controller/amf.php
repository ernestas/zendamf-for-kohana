<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Amf extends Controller {
 
	// Server instance
	public $server;
	
	// Load the config options
	private $config;

	public function before()
	{
		parent::before();
        
		// Load config file
		$this->config = Kohana::config('zendamf-for-kohana');
		if( ! class_exists( Zend_Amf_Server ) )
			$this->_loadZendAmfServer();
		
		// Instance Zend Amf Server object
		$this->server = new Zend_Amf_Server();
		$this->server->setProduction($this->config->production);
		
		if($this->config->amfbrowser)
			$this->_enableZamfBrowser();
	}
    
	public function after()
	{
		parent::after();
        
        $handle = $this->server->handle();
        
        if (Request::is_amf())
        {
			$this->response->body($handle);
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
	
	private function _loadZendAmfServer()
	{
		/**
		 * Load Zend classes.
		 */
		if ( $path = Kohana::find_file('vendor', 'Zend/Loader') )
		{
		    ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.dirname(dirname($path)));

		    require_once 'Zend/Loader/Autoloader.php';

		    require_once 'Zend/Amf/Server.php';

		    Zend_Loader_Autoloader::getInstance();
		}
	}
	
}
