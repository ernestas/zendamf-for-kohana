# ZendAMF Module for Kohana 3.1

Simple port to work with KO3. Includes the minimal required Zend Framework. The only modified file is Zend/Amf/Server.php to use Kohana::auto_load instead of the ZendPluginLoader.

I will eventually add some examples.

## Notes

1. If you are going to use a Controller class for the amf services, you will need to modify the constructor:
<pre>    
    public function __construct(Request $req = null, Response $res = null)
    {
        if ( ! isset($req)) 
            $req = Request::instance();
        if ( ! isset($res)) 
            $res = Response::instance();
        parent::__construct($req,$res);
    }
</pre>
        There is something in the Zend framework that doesn’t load controller classes properly in KO3, 
        and I didn’t want to muddle with the Zend code, so this was an easy workaround.
        The controller load isn't working in Kohana 3.1.x.

2. I made the AMF endpoint controller so that you can easily extend it to add your own setClassMap() in the action_index() function, i.e.

<pre>
    class Controller_Gateway extends Controller_Amf {
    
        public function action_index()
        {
            $this->server->setClassMap
            (
                '{actionscript package name}', 
                '{php class name}'
            );
        }
    }
</pre>
    
3. Also you can use the setCall method, i.e.

<pre>
    class Controller_Gateway extends Controller_Amf {

        public function action_index()
        {
            $this->server->setClass("MyClass");
            $this->server->setClass("Controller_MyClass");
        }
    }
</pre>

4. I extended Request to check for an AMF request.

        Request::is_amf()

5. For more information about Zend Amf Server please visit: http://framework.zend.com/manual/en/zend.amf.server.html