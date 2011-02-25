<?php
// Set up debug
error_reporting( E_ALL | E_STRICT );
ini_set( "display_errors", "on" );

// Set up include path for Zend Framework, this path is assuming a frameworks 
// folder contains the Zend package on the same level as your public_html or www folder.
ini_set( "include_path", ini_get("include_path") . ":../frameworks" );


// Require Zend_Amf_Server
require_once( "Zend/Amf/Server.php" );


// *ZAMFBROWSER IMPLEMENTATION*
// Require the ZendAmfServiceBrowser class, required to retrieve the list of methods on the ZendAMF server. 
require_once( "browser/ZendAmfServiceBrowser.php" );


// Start Server
$server = new Zend_Amf_Server();


// Register ZendAMF Service classes
$server->setClass( "YourServiceClass" );
$server->setClass( "AnotherServiceClass" );


// *ZAMFBROWSER IMPLEMENTATION*
// Add the ZendAmfServiceBrowser class to the list of available classes.
$server->setClass( "ZendAmfServiceBrowser" );

// *ZAMFBROWSER IMPLEMENTATION*
// Set this reference the class requires to the server object.
ZendAmfServiceBrowser::$ZEND_AMF_SERVER = $server;


// Handle the AMF request
echo($server->handle());
?>
