<?php
/**
 * Every single controller will extend this controller class.
 * To accessing all the common functions
 */
class controller
{

    protected function view($view,$data = null)
    {
        
        if(file_exists("app/views/{$view}.view.php")){

            include "app/views/{$view}.view.php";

        }else{

            return false;

        }

    }

    protected function model()
    {
        spl_autoload_register(function($class){

            if(file_exists("app/models/{$class}.model.php")){
                
                include "app/models/{$class}.model.php";

            }else{

                return false;
            }

        });
    }    


}