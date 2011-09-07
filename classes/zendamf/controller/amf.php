<?php defined('SYSPATH') or die('No direct script access.');

class Zendamf_Controller_Amf extends Kohana_Controller {
 
	// Server instance
	public $server;
	
	// Load the config options
	private $config;

	public function before()
	{
		parent::before();
        
		// Load config file
		$this->config = Kohana::$config->load('zendamf-for-kohana');
		if ( ! class_exists("Zend_Amf_Server"))
		{
			$this->_load_zend_amf_server();
		}
		
		// Instance Zend Amf Server object
		$this->server = new Zend_Amf_Server;
		$this->server->setProduction($this->config->production);
		
		if ($this->config->amfbrowser)
		{
			$this->_enable_zamf_browser();
		}
	}
    
	public function action_index()
	{
		// Can override to add custom setClass(), this is for tests porpouses
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
	private function _enable_zamf_browser()
	{
		$this->_load_zamf_browser();
		$this->server->setClass("ZendAmfServiceBrowser");
		// Set a reference to the Zend_Amf_Server object
		// so ZendAmfServiceBrowser class can retrive method information.
		ZendAmfServiceBrowser::$ZEND_AMF_SERVER = $this->server;
	}
	
	/**
	 * Load Zend classes
	 */
	private function _load_zend_amf_server()
	{
		if ($path = Kohana::find_file('vendor', 'Zend/Loader'))
		{
			ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.dirname(dirname($path)));
			require_once 'Zend/Loader/Autoloader.php';
			require_once 'Zend/Amf/Server.php';
			Zend_Loader_Autoloader::getInstance();
		}
	}
	
	/**
	 * Load ZamfBrowser
	 */
	private function _load_zamf_browser()
	{
		if ($path = Kohana::find_file('vendor', 'ZamfBrowser/browser/ZendAmfServiceBrowser'))
		{
			ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.dirname($path));
			require_once 'ZendAmfServiceBrowser.php';
		}
	}
}
