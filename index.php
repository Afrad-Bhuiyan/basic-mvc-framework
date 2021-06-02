<?php

//start the session to access $_SESSION variable from the entire site
session_start();

//include the app.php file where all required file is included
include "app/app.php";

//instantiate the Route class to access a controller & method
$route = new Route;