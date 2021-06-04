<?php

/**
 * Route class will be used to instanciate a particular 
 * controller from `app/controller/*.php` and a method.
 */

class Route
{   
    //`home` is the default controller
    private $ctrl = "home";

    //`index` is the default index and every controller must have an index method
    private $method = "index";
    
    //initially pass an empty array when called the method
    private $params = array();
    

    public function __construct()
    {

        //catch the url by calling the $this->getURL() method
        $url = $this->getURL();

        if(isset($url[0])){

            //override the default controller
            $this->ctrl = strtolower($url[0]);

            //remove the controller name from $url variable
            unset($url[0]);
        }

        if(isset($url[1])){

            //override the default method
            $this->method = strtolower($url[1]);

            //remove the method name from $url variable
            unset($url[1]);
        }

        //store the request method `GET` or `POST`
        $request_method = strtolower($_SERVER["REQUEST_METHOD"]);
        
        //create a dynamic path for controller
        $ctrl_path = "app/controllers/{$request_method}/{$this->ctrl}.ctrl.php";

        if(file_exists($ctrl_path)){

            //inclue the controller
            include $ctrl_path;

            //create an instance and store it in $this->ctrl variable
            $this->ctrl = new $this->ctrl();

        }else{

            //exite the script and show 404 page if controller does not exist
            include "app/views/pages/404.view.php";
            die();
        }

        if(method_exists($this->ctrl, $this->method)){

            //store existing paramerter in to pass in the method
            $this->params = array_values($url);
            
            //finaly call the function from the 
            call_user_func_array(array($this->ctrl,$this->method), $this->params);

        }else{

            //exite the script and show 404 page if method does not exist
            include "app/views/pages/404.view.php";
            die();
        }

    }

    //use the function to get `ctrl`,`methods`,`params` in an array
    private function getURL()
    {
        //store the final url from $_GET["url"] variable
        $url = array();

        if(!empty($_GET)){
            
            //filter the $_GET["url"] variable
            $url = filter_var($_GET["url"],FILTER_SANITIZE_URL);
            
            //remove extra `/` from the url. otherwise an empty index will be created
            $url = trim($url,"/");

            //splite the  $url where from `/`
            $url = explode("/", $url);
        }

        return $url;
    
    }
}