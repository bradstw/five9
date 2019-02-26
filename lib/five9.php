<?php
class five9
{
    # Default five9 web services end point
    private $wsdl = "https://api.five9.com/wsadmin/AdminWebService?wsdl";
    private $user_name = "USERNAME";
    private $password = "PASSWORD";
    public $client;
    
    public function __construct()
    {
        $creds = [
            'login' => $this->user_name,
            'password' => $this->password,
        ];
        try {
            $this->client = new SoapClient($this->wsdl, $creds);
        } catch (\Exception $e) {
            $error_message = $e->getMessage();
            echo $error_message;
        }
        # Load class files
        $class_name = array_diff(scandir('lib/'), array('..', '.'));
        foreach ($class_name as $class) {
            if ($class <> 'five9.php') {
                include_once($class);
            }
        }
    }
}