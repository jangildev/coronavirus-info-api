<?php
    require_once(__DIR__."/database/database.php");

    error_reporting(0);

    header('Access-Control-Allow-Origin: *');
    header("Content-type: application/json; charset=utf-8");

    $path = $_SERVER['REQUEST_URI'];
    $requests = explode("/" , $path);

    array_splice($requests , 0, array_search('api' , $requests) + 1);

    $db = new Database();
    
    try
    {
        if(isset($requests[1]))
        {
            echo $db->{$requests[0]}($requests[1]);
        }
        else 
        {
            if($requests[0] == "state" || $requests[0] == "city")
            {
                echo $db->{$requests[0]."s"}();
            }
            else
            {
               echo $db->{$requests[0]}(); 
            }
        }
    }
    catch(Error $e)
    {
        echo json_encode(array());
    }
?>		