<?php
    require_once(__DIR__."/database/database.php");

    //error_reporting(0);

    header('Access-Control-Allow-Origin: *');
    header("Content-type: application/json; charset=utf-8");
    header('Access-Control-Allow-Methods: POST, GET');
    header('Access-Control-Allow-Headers: *');

    $db = new Database();

    $path = $_SERVER['REQUEST_URI'];
    $requests = explode("/" , $path);
    array_splice($requests , 0, array_search('api' , $requests) + 1);

    if($requests[0] == "token")
    {
        header("Content-type: text/html;");
        include "./gettoken.php";
        exit;
    }

    // SOM TOKEN AUTHORIZATION 

    $token = //get token;

    $post = file_get_contents("php://input");
    
    $ispost = $_SERVER['REQUEST_METHOD'] == "POST" && !is_null($post) && $post != "";

    try
    {
        if($requests[0] == "tokenExists" || $requests[0] == "loginExists")
        {
            echo json_encode(array("Message"=>"Bad request") , JSON_PRETTY_PRINT);
            exit;
        }

        if(!$ispost)
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
        else
        {
            if($token->post == 1)
            {
                $post_data = json_decode($post);

                if(isset($requests[0]))
                {
                    echo $db->{$requests[0]}($post_data);
                }
            }
            else{
                echo json_encode(array("Message"=>"Method Not Allowed") , JSON_PRETTY_PRINT);
            }
        }
    }
    catch(Error $e)
    {
        echo json_encode(array("Message"=>"Bad request") , JSON_PRETTY_PRINT);
    }
?>		