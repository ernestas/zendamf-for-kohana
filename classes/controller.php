<?php defined('SYSPATH') or die('No direct script access.');

class Controller extends Kohana_Controller {
	/**
	 * Fix the construct to work with Zend_Amf_Server
     *
     * @return  void
     */
	public function __construct(Request $request = null, Response $response = null)
	{
		if( ! isset( $request ) )
			$request = Request::current();
		if( ! isset( $response ) )
			$response = Response::factory();

		parent::__construct($request, $response);
	}
}