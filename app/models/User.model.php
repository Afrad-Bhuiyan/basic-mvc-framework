<?php

class User extends Database
{   

    //store the instance of this model when access the `getInstance` static method
    private static $instance;

    //store table name for this model
    protected $table = "users";

    public function __construct()
    {   
        //call the from database class to establish 
        //a connection with the database
        $this->db_connect();
    }   

    //use the funtion to get the instance of this model
    public static function getInstance()
    {
        return (!self::$instance) ? self::$instance = new self() : self::$instance;
    }

    public function __destruct()
    {
        //call the from databse class to disconnect 
        //the connection with the database after calling
        //executing all the functions
        $this->db_disconnect();
    }   
    
}
