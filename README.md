# ZendAMF Module for Kohana 3.1

Simple port to work with KO3. Includes the minimal required Zend Framework. The only modified file is Zend/Amf/Server.php to use Kohana::auto_load instead of the ZendPluginLoader.

The module will use the first instance of Zend_Amf_Server loaded in your application. So if you already using the Zend Framework with Kohana it will use your version of the class.
If you expecting errors in the Zend_Amf_Server, make sure that your instanced ZendFramework is the same version from the bult-in module.

## Notes

1. The Controller class is extended to work the amf services, you can override it or disable in the config file.

    There is something in the Zend framework that doesn’t load controller classes properly in KO3, 
    and I didn’t want to muddle with the Zend code, so this was an easy workaround.

2. I made the AMF endpoint controller so that you can easily extend it to add your own setClassMap() in the action_index() function, i.e.

        class Controller_Gateway extends Controller_Amf 
        {
            public function action_index()
            {
                $this->server->setClassMap
                (
                    '{actionscript package name}', 
                    '{php class name}'
                );
            }
        }
    
3. Also you can use the setClass method, i.e.

        class Controller_Amf extends Zendamf_Controller_Amf
        {
            public function action_index()
            {
                $this->server->setClass("MyClass");
                $this->server->setClass("Controller_MyClass");
            }
        }

4. I extended Request to check for an AMF request.

        Request::is_amf()

5. Visit Zend Amf Server [reference guide](http://framework.zend.com/manual/en/zend.amf.server.html) for more info.