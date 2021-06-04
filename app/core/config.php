<?php
/**
 * Config.php will contain all the configrations CONSTRANT.
 * such as: Database info, Root URL, Assets URL, 
 */
    /**
     * $condition==true (for live server)
     * $condition==false (for local server)
     */
        $condition=($_SERVER["SERVER_NAME"]=="localhost" || $_SERVER["SERVER_NAME"] == $_SERVER["SERVER_ADDR"]) ? false : true;


    /**
     * Database related information.
     * Such as: Database name, Database host, Database user, Database password
     */

        //store the Database host name for both live and local server
        define("DB_HOST", ($condition) ? "localhost" : "localhost");

        //store the Database Username for both live and local server
        define("DB_USER", ($condition) ? "live_server_db_user" : "root");

        //store the Database Password for both live and local server
        define("DB_PASS", ($condition) ? "live_server_db_pass" : "");

        //store the Database Name for both live and local server
        define("DB_NAME", ($condition) ? "live_server_db_name" : "practice");

        //store the Database type
        define("DB_TYPE", "mysql");

    /**
     * Server relate information.
     * Such as: Sever Name, Protocall, Script Name
     */ 

        //store Protocall type `http` || `https`
        define("PROTOCALL", $_SERVER["REQUEST_SCHEME"]);
        
        //store the server name
        define("SERVER_NAME", $_SERVER['SERVER_NAME']);
        
        //store the executed script name path in the server
        define("SCRIPT_PATH", $_SERVER["PHP_SELF"]);
        
        //store only the script file name like `index.php`;
        define("SCRIPT_NAME", basename(SCRIPT_PATH));
        
        //remove the script name and store the project folder's name
        define("PROJECT_FOLDER", str_replace(SCRIPT_NAME,"",SCRIPT_PATH));

    /**
     * URL's information.
     * Such as: ROOT, ASSETS
     */ 
    
        //store website's root url
        define("ROOT", PROTOCALL . "://". SERVER_NAME . PROJECT_FOLDER);
        
        //store website's assets folder url
        define("ASSETS", ROOT . "public/assets/");